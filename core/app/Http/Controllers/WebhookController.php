<?php

namespace App\Http\Controllers;

use App\Models\WhatsappAccount;
use Illuminate\Http\Request;
use App\Models\Campaign;
use App\Models\CampaignContact;
use App\Models\CampaignMessageEvent;
use App\Models\Message;
use App\Models\Contact;
use App\Models\Conversation;
use App\Constants\Status;
use App\Events\ReceiveMessage;
use App\Lib\WhatsApp\AutomationLib;
use App\Lib\WhatsApp\WhatsAppLib;
use App\Models\ContactFlowState;
use App\Models\Flow;
use App\Models\User;
use libphonenumber\PhoneNumberUtil;
use App\Traits\WhatsappManager;
use Carbon\Carbon;
use Exception;
use App\Models\Order;

class WebhookController extends Controller
{
    use WhatsappManager;

    public function webhookConnect(Request $request)
    {
        $systemWebhookToken = gs('webhook_verify_token');

        if ($systemWebhookToken && $systemWebhookToken != $request->hub_verify_token) {
            return response('Invalid token', 401);
        }

        return response($request->hub_challenge)->header('Content-type', 'plain/text'); // meta need a specific type of response
    }

    public function webhookResponse(Request $request)
    {
        $entry = $request->input('entry', []);
        if (!is_array($entry))
            return;

        $receiverPhoneNumber = null;
        $senderPhoneNumber = null;
        $senderId = null;
        $messageText = null;
        $buttonReply = null;
        $listReply = null;
        $mediaId = null;
        $mediaType = null;
        $mediaMimeType = null;
        $messageType = 'text';
        $messageCaption = null;
        $profileName = null;

        $whatsappAccount = WhatsappAccount::where('whatsapp_business_account_id', $entry[0]['id'])->first();

        if (!$whatsappAccount)
            return;

        $user = User::active()->find($whatsappAccount->user_id);

        if (!$user)
            return;

        foreach ($entry as $entryItem) {

            foreach ($entryItem['changes'] as $change) {

                if (!is_array($change) || !isset($change['value']))
                    continue;

                if (isset($change['field']) && $change['field'] == 'message_template_status_update') {
                    sleep(10); // wait for 10 seconds until the template store
                    $this->templateUpdateNotify($change['value']['message_template_id'], $change['value']['event'], $change['value']['reason'] ?? '');
                    continue;
                }
                ;

                $metaValue = $change['value'];
                if (!is_array($metaValue))
                    continue;

                $profileName = $metaValue['contacts'][0]['profile']['name'] ?? null;
                $metaData = $metaValue['metadata'] ?? [];
                $metaMessage = $metaValue['messages'] ?? null;

                if (isset($metaData['phone_number_id'])) {
                    $receiverPhoneNumberId = $metaData['phone_number_id'];
                }

                if (isset($metaData['display_phone_number'])) {
                    $receiverPhoneNumber = $metaData['display_phone_number'];
                }

                if (isset($metaMessage[0]['from'])) {
                    $senderPhoneNumber = $metaMessage[0]['from'];
                }

                if (isset($metaMessage[0]['id'])) {
                    $senderId = $metaMessage[0]['id'];
                }

                $statusPayloads = $metaValue['statuses'] ?? [];
                if (is_array($statusPayloads) && count($statusPayloads) > 0) {
                    foreach ($statusPayloads as $statusPayload) {
                        if (is_array($statusPayload)) {
                            $this->handleStatusUpdate($statusPayload, $whatsappAccount);
                        }
                    }
                }

                if (isset($metaMessage[0]['text']['body']) || isset($metaMessage[0]['button']['text'])) {
                    $messageText = $metaMessage[0]['button']['text'] ?? $metaMessage[0]['text']['body'];
                }

                if (isset($metaMessage[0]['type'])) {
                    $messageType = $metaMessage[0]['type'];
                }

                if ($messageType == 'interactive') {
                    if (isset($metaMessage[0]['interactive']['button_reply']['title'])) {
                        $buttonReply = $metaMessage[0]['interactive']['button_reply']['title'];
                    }
                    if (isset($metaMessage[0]['interactive']['list_reply']['title'])) {
                        $listReply = [
                            'title' => $metaMessage[0]['interactive']['list_reply']['title'] ?? '',
                            'description' => $metaMessage[0]['interactive']['list_reply']['description'] ?? '',
                        ];
                    }
                }

                // Handle media messages
                if (isset($metaMessage[0]['type']) && $metaMessage[0]['type'] !== 'text') {
                    $mediaType = $metaMessage[0]['type'];

                    if (isset($metaMessage[0][$mediaType]['id'])) {
                        $mediaId = $metaMessage[0][$mediaType]['id'];
                    }
                    if (isset($metaMessage[0][$mediaType]['mime_type'])) {
                        $mediaMimeType = $metaMessage[0][$mediaType]['mime_type'];
                    }
                    if (isset($metaMessage[0][$mediaType]['caption'])) {
                        $messageCaption = $metaMessage[0][$mediaType]['caption'];
                    }
                }
            }
        }

        if (($messageText || $buttonReply || $listReply || $mediaId) && $senderPhoneNumber && $senderId) {
            // Save the incoming message first
            $receiverPhoneNumber = preg_replace('/\D/', '', $receiverPhoneNumber);
            $phoneUtil = PhoneNumberUtil::getInstance();
            $parseNumber = $phoneUtil->parse('+' . $senderPhoneNumber, '');
            $countryCode = $parseNumber->getCountryCode();
            $nationalNumber = $parseNumber->getNationalNumber();
            $newContact = false;

            $contact = Contact::where('mobile_code', $countryCode)
                ->where('mobile', $nationalNumber)
                ->where('user_id', $user->id)
                ->with('conversation')
                ->first();

            if (!$contact) {
                $newContact = true;
                $contact = new Contact();
                $contact->firstname = $profileName;
                $contact->mobile_code = $countryCode;
                $contact->mobile = $nationalNumber;
                $contact->user_id = $user->id;
                $contact->save();
            }

            $conversation = Conversation::where('contact_id', $contact->id)->where('user_id', $user->id)->where('whatsapp_account_id', $whatsappAccount->id)->first();
            if (!$conversation) {
                $newContact = true;
                $conversation = $this->createConversation($contact, $whatsappAccount);
            }

            $messageExists = Message::where('whatsapp_message_id', $senderId)->exists();

            $whatsappLib = new WhatsAppLib();
            $automationLib = new AutomationLib();

            if (!$messageExists) {
                // Save the incoming message
                $message = new Message();
                $message->whatsapp_account_id = $whatsappAccount->id;
                $message->whatsapp_message_id = $senderId;
                $message->user_id = $user->id ?? 0;
                $message->conversation_id = $conversation->id;
                $message->message = $messageText ?? $buttonReply ?? '';
                $message->list_reply = $listReply;
                $message->type = Status::MESSAGE_RECEIVED;
                $message->message_type = getIntMessageType($messageType);
                $message->media_id = $mediaId;
                $message->media_type = $mediaType;
                $message->media_caption = $messageCaption;
                $message->mime_type = $mediaMimeType;
                $message->ordering = Carbon::now();
                $message->save();

                $conversation->last_message_at = Carbon::now();
                $conversation->save();

                $this->attributeInboundReplyToCampaign($message, $contact, $whatsappAccount);

                // If it's a media message, fetch and store the media
                if ($mediaId) {
                    $accessToken = $whatsappAccount->access_token;
                    try {
                        $mediaUrl = $whatsappLib->getMediaUrl($mediaId, $accessToken);

                        if ($mediaUrl && $mediaType == 'image') {
                            $mediaPath = $whatsappLib->storedMediaToLocal($mediaUrl['url'], $mediaId, $accessToken, $user->id);
                            $message->media_url = $mediaUrl;
                            $message->media_path = $mediaPath;

                            $message->save();
                        }
                    } catch (Exception $ex) {
                    }
                }

                // Handle Order Messages
                if ($messageType == 'order') {
                    $orderData = $metaMessage[0]['order'] ?? null;
                    if ($orderData) {
                        try {
                            $totalAmount = 0;
                            $currency = 'USD';
                            $products = [];

                            foreach ($orderData['product_items'] as $item) {
                                $totalAmount += $item['item_price'] * $item['quantity'];
                                $currency = $item['currency'];
                                $products[] = [
                                    'retailer_id' => $item['product_retailer_id'],
                                    'quantity' => $item['quantity'],
                                    'price' => $item['item_price'],
                                    'currency' => $item['currency']
                                ];
                            }

                            $order = new Order();
                            $order->user_id = $user->id;
                            $order->contact_id = $contact->id;
                            $order->conversation_id = $conversation->id;
                            $order->amount = $totalAmount;
                            $order->currency = $currency;
                            $order->status = 'pending';
                            $order->products_json = $products;
                            $order->save();

                            // Optional: Send auto-reply for order received
                            $whatsappLib->sendAutoReply($user, $conversation, "Order Received: #" . $order->id);

                        } catch (Exception $e) {
                            // Log error
                        }
                    }
                }

                $html = view('Template::user.inbox.single_message', compact('message'))->render();
                $lastConversationMessageHtml = view("Template::user.inbox.conversation_last_message", compact('message'))->render();

                event(new ReceiveMessage($whatsappAccount->id, [
                    'html' => $html,
                    'message' => $message,
                    'newMessage' => true,
                    'newContact' => $newContact,
                    'lastMessageHtml' => $lastConversationMessageHtml,
                    'unseenMessage' => $conversation->unseenMessages()->count() < 10 ? $conversation->unseenMessages()->count() : '9+',
                    'lastMessageAt' => showDateTime(Carbon::now()),
                    'conversationId' => $conversation->id,
                    'mediaPath' => getFilePath('conversation')
                ]));
            }

            $messagesInConversation = Message::where('conversation_id', $conversation->id)->where('type', Status::MESSAGE_RECEIVED)->count();

            if ($messagesInConversation == 1 && @$whatsappAccount->welcomeMessage) {
                $this->sendWelcomeMessage($whatsappAccount, $user, $contact, $conversation);
            } else {


                if (!$messageExists) {
                    $automationFlowQuery = Flow::where('user_id', $user->id)->with(['nodes', 'nodes.media'])->active();
                    $lastState = ContactFlowState::where('conversation_id', $conversation->id)
                        ->latest('last_interacted_at')
                        ->first();
                    $queryText = $buttonReply ?? strtolower($messageText);

                    if ($newContact) {
                        $automationFlow = $automationFlowQuery->newMessage()->first();
                    } else {
                        if ($buttonReply && $lastState && $lastState->status == Status::FLOW_STATE_WAITING) {
                            $automationFlow = Flow::with('nodes', 'nodes.media')->find($lastState->flow_id);
                            if (!$automationFlow) {
                                $automationFlow = $automationFlowQuery->keywordMatch()->where('keyword', $messageText)->first();
                            }
                        } else {
                            $automationFlow = $automationFlowQuery->keywordMatch()->where('keyword', $messageText)->first();
                        }
                    }
                    if ($automationFlow) {
                        $automationLib->process($user, $automationFlow, $lastState, $conversation, $queryText);
                    } else {
                        // Dialogflow Logic
                        $dialogflowConfig = \App\Models\DialogflowConfig::where('user_id', $user->id)->where('status', 1)->first();
                        $dialogflowResponse = null;

                        if ($dialogflowConfig) {
                            try {
                                $dialogflowService = new \App\Lib\Dialogflow\DialogflowService($dialogflowConfig);
                                $dialogflowResult = $dialogflowService->detectIntent($conversation->id, $messageText);

                                if ($dialogflowResult && !empty($dialogflowResult['fulfillmentText'])) {
                                    $dialogflowResponse = $dialogflowResult['fulfillmentText'];
                                }
                            } catch (\Exception $e) {
                                // Log error or ignore
                            }
                        }

                        if ($dialogflowResponse) {
                            // Send Dialogflow Response
                            $request = new Request(['message' => $dialogflowResponse]);
                            $messageSend = $whatsappLib->messageSend($request, $conversation->contact->mobileNumber, $whatsappAccount);

                            if ($messageSend) {
                                extract($messageSend);
                                $message = new Message();
                                $message->user_id = $user->id;
                                $message->whatsapp_account_id = $whatsappAccount->id;
                                $message->whatsapp_message_id = $whatsAppMessage[0]['id'];
                                $message->conversation_id = $conversation->id;
                                $message->type = Status::MESSAGE_SENT;
                                $message->message = $dialogflowResponse;
                                $message->message_type = getIntMessageType($messageType);
                                $message->status = Status::MESSAGE_SENT;
                                $message->ordering = Carbon::now();
                                $message->save();

                                $conversation->last_message_at = Carbon::now();
                                $conversation->save();
                            }

                        } else {
                            $whatsappLib->sendAutoReply($user, $conversation, $messageText);
                        }
                    }
                }
            }
        }

        return response()->json(['status' => 'received'], 200);
    }

    private function handleStatusUpdate(array $statusPayload, WhatsappAccount $whatsappAccount): void
    {
        $messageId = $statusPayload['id'] ?? null;
        $messageStatus = strtolower((string) ($statusPayload['status'] ?? ''));

        if (!$messageId || !$messageStatus) {
            return;
        }

        $wMessage = Message::where('whatsapp_message_id', $messageId)->first();
        if (!$wMessage) {
            return;
        }

        $wMessage->status = messageStatus($messageStatus);
        $wMessage->save();

        $isNewMessage = false;
        if ($wMessage->status == Status::SENT || $wMessage->status == Status::FAILED) {
            $isNewMessage = true;
        }

        $message = $wMessage;
        $html = view('Template::user.inbox.single_message', compact('message'))->render();

        event(new ReceiveMessage($whatsappAccount->id, [
            'html' => $html,
            'messageId' => $message->id,
            'message' => $message,
            'statusHtml' => $message->statusBadge,
            'newMessage' => $isNewMessage,
            'mediaPath' => getFilePath('conversation'),
            'conversationId' => $wMessage->conversation_id,
            'unseenMessage' => $wMessage->conversation ? ($wMessage->conversation->unseenMessages()->count() < 10 ? $wMessage->conversation->unseenMessages()->count() : '9+') : 0,
        ]));

        $this->syncCampaignDeliveryStatus($wMessage, $statusPayload, $messageStatus);
    }

    private function syncCampaignDeliveryStatus(Message $message, array $statusPayload, string $messageStatus): void
    {
        $campaignContact = $this->resolveCampaignContact($message);
        if (!$campaignContact) {
            return;
        }

        if ((int) $message->campaign_id <= 0 && (int) $campaignContact->campaign_id > 0) {
            $message->campaign_id = $campaignContact->campaign_id;
            $message->save();
        }

        $campaign = $campaignContact->campaign;
        if (!$campaign) {
            return;
        }

        $eventAt = $this->statusEventTime($statusPayload);
        $oldStatus = (int) $campaignContact->status;
        $oldDeliveryStatus = (int) ($campaignContact->delivery_status ?? Status::CAMPAIGN_DELIVERY_PENDING);

        if ($oldDeliveryStatus === Status::CAMPAIGN_DELIVERY_FAILED && in_array($messageStatus, ['sent', 'delivered', 'read'], true)) {
            return;
        }
        if ($oldDeliveryStatus === Status::CAMPAIGN_DELIVERY_READ && $messageStatus === 'failed') {
            return;
        }

        $this->applyMetaContext($campaignContact, $statusPayload);
        $eventType = $messageStatus;

        if ($messageStatus === 'sent') {
            $campaignContact->sent_at = $campaignContact->sent_at ?: $eventAt;
            $campaignContact->status = Status::CAMPAIGN_MESSAGE_IS_SENT;
            $campaignContact->delivery_status = $this->promoteDeliveryStatus($oldDeliveryStatus, Status::CAMPAIGN_DELIVERY_SENT);
        } elseif ($messageStatus === 'delivered') {
            $campaignContact->sent_at = $campaignContact->sent_at ?: $eventAt;
            $campaignContact->delivered_at = $campaignContact->delivered_at ?: $eventAt;
            $campaignContact->status = Status::CAMPAIGN_MESSAGE_IS_SUCCESS;
            $campaignContact->delivery_status = $this->promoteDeliveryStatus($oldDeliveryStatus, Status::CAMPAIGN_DELIVERY_DELIVERED);

            if ($oldStatus !== Status::CAMPAIGN_MESSAGE_IS_SUCCESS) {
                $campaign->increment('total_success');
            }
        } elseif ($messageStatus === 'read') {
            $campaignContact->sent_at = $campaignContact->sent_at ?: $eventAt;
            $campaignContact->delivered_at = $campaignContact->delivered_at ?: $eventAt;
            $campaignContact->read_at = $campaignContact->read_at ?: $eventAt;
            $campaignContact->status = Status::CAMPAIGN_MESSAGE_IS_SUCCESS;
            $campaignContact->delivery_status = $this->promoteDeliveryStatus($oldDeliveryStatus, Status::CAMPAIGN_DELIVERY_READ);

            if ($oldStatus !== Status::CAMPAIGN_MESSAGE_IS_SUCCESS) {
                $campaign->increment('total_success');
            }
        } elseif ($messageStatus === 'failed') {
            $campaignContact->failed_at = $campaignContact->failed_at ?: $eventAt;
            $campaignContact->status = Status::CAMPAIGN_MESSAGE_IS_FAILED;
            $campaignContact->delivery_status = $this->promoteDeliveryStatus($oldDeliveryStatus, Status::CAMPAIGN_DELIVERY_FAILED);

            if ($oldStatus !== Status::CAMPAIGN_MESSAGE_IS_FAILED) {
                $campaign->increment('total_failed');
            }
        } else {
            return;
        }

        $campaignContact->save();

        $this->logCampaignEvent(
            $campaignContact,
            $eventType,
            $eventAt,
            'webhook',
            $statusPayload,
            (int) $message->id,
            $message->whatsapp_message_id
        );

        $this->syncCampaignRollupStatus($campaign);
    }

    private function resolveCampaignContact(Message $message): ?CampaignContact
    {
        $campaignContact = CampaignContact::where('message_id', $message->id)
            ->orWhere('whatsapp_message_id', $message->whatsapp_message_id)
            ->latest('id')
            ->first();

        if ($campaignContact) {
            return $campaignContact;
        }

        if ((int) $message->campaign_id > 0 && $message->conversation) {
            return CampaignContact::where('campaign_id', $message->campaign_id)
                ->where('contact_id', $message->conversation->contact_id)
                ->latest('id')
                ->first();
        }

        return null;
    }

    private function attributeInboundReplyToCampaign(Message $incomingMessage, Contact $contact, WhatsappAccount $whatsappAccount): void
    {
        $eventAt = Carbon::parse($incomingMessage->created_at ?? now());
        $campaignContact = CampaignContact::where('contact_id', $contact->id)
            ->whereNotNull('sent_at')
            ->whereNull('responded_at')
            ->where('sent_at', '<=', $eventAt)
            ->whereHas('campaign', function ($query) use ($whatsappAccount, $contact) {
                $query->where('user_id', $contact->user_id)
                    ->where('whatsapp_account_id', $whatsappAccount->id);
            })
            ->orderByDesc('sent_at')
            ->first();

        if (!$campaignContact) {
            return;
        }

        $campaignContact->responded_at = $eventAt;
        $campaignContact->first_response_message_id = $incomingMessage->id;
        $campaignContact->save();

        $this->logCampaignEvent(
            $campaignContact,
            'replied',
            $eventAt,
            'webhook',
            ['message_type' => $incomingMessage->message_type],
            (int) $incomingMessage->id,
            $incomingMessage->whatsapp_message_id
        );
    }

    private function statusEventTime(array $statusPayload): Carbon
    {
        $timestamp = $statusPayload['timestamp'] ?? null;
        if (is_numeric($timestamp)) {
            return Carbon::createFromTimestamp((int) $timestamp);
        }
        return now();
    }

    private function applyMetaContext(CampaignContact $campaignContact, array $statusPayload): void
    {
        $conversation = $statusPayload['conversation'] ?? [];
        $pricing = $statusPayload['pricing'] ?? [];
        $errors = $statusPayload['errors'][0] ?? [];

        $campaignContact->meta_conversation_id = $conversation['id'] ?? $campaignContact->meta_conversation_id;
        $campaignContact->meta_conversation_category = $conversation['origin']['type'] ?? $campaignContact->meta_conversation_category;
        $campaignContact->meta_conversation_type = $conversation['type'] ?? $campaignContact->meta_conversation_type;
        $campaignContact->meta_pricing_model = $pricing['pricing_model'] ?? $campaignContact->meta_pricing_model;
        $campaignContact->meta_pricing_category = $pricing['category'] ?? $campaignContact->meta_pricing_category;
        if (array_key_exists('billable', $pricing)) {
            $campaignContact->meta_billable = (int) ((bool) $pricing['billable']);
        }
        if ($errors) {
            $campaignContact->meta_error_code = (string) ($errors['code'] ?? $campaignContact->meta_error_code);
            $campaignContact->meta_error_title = (string) ($errors['title'] ?? $campaignContact->meta_error_title);
            $campaignContact->meta_error_details = (string) ($errors['message'] ?? $campaignContact->meta_error_details);
        }
    }

    private function promoteDeliveryStatus(int $currentStatus, int $candidateStatus): int
    {
        if ($currentStatus === Status::CAMPAIGN_DELIVERY_READ && $candidateStatus === Status::CAMPAIGN_DELIVERY_FAILED) {
            return $currentStatus;
        }

        $rank = [
            Status::CAMPAIGN_DELIVERY_PENDING => 0,
            Status::CAMPAIGN_DELIVERY_SENT => 1,
            Status::CAMPAIGN_DELIVERY_DELIVERED => 2,
            Status::CAMPAIGN_DELIVERY_READ => 3,
            Status::CAMPAIGN_DELIVERY_FAILED => 4,
        ];

        $currentRank = $rank[$currentStatus] ?? 0;
        $candidateRank = $rank[$candidateStatus] ?? 0;

        if ($candidateRank >= $currentRank) {
            return $candidateStatus;
        }

        return $currentStatus;
    }

    private function syncCampaignRollupStatus(Campaign $campaign): void
    {
        if ($campaign->total_message <= $campaign->total_failed) {
            $campaign->status = Status::CAMPAIGN_FAILED;
        } elseif ($campaign->total_message <= $campaign->total_send) {
            $campaign->status = Status::CAMPAIGN_COMPLETED;
        }
        $campaign->save();
    }

    private function logCampaignEvent(
        CampaignContact $campaignContact,
        string $eventType,
        Carbon $eventAt,
        string $source,
        array $meta = [],
        int $messageId = 0,
        ?string $whatsappMessageId = null
    ): void {
        CampaignMessageEvent::updateOrCreate(
            [
                'campaign_id' => (int) $campaignContact->campaign_id,
                'campaign_contact_id' => (int) $campaignContact->id,
                'whatsapp_message_id' => $whatsappMessageId,
                'event_type' => $eventType,
                'event_ts' => $eventAt->copy()->startOfSecond(),
                'source' => $source,
            ],
            [
                'message_id' => $messageId ?: (int) ($campaignContact->message_id ?? 0),
                'contact_id' => (int) ($campaignContact->contact_id ?? 0),
                'meta_json' => $meta ?: null,
            ]
        );
    }

    private function createConversation($contact, $whatsappAccount)
    {
        $conversation = new Conversation();
        $conversation->contact_id = $contact->id;
        $conversation->whatsapp_account_id = $whatsappAccount->id;
        $conversation->user_id = $whatsappAccount->user_id;
        $conversation->save();

        return $conversation;
    }
}
