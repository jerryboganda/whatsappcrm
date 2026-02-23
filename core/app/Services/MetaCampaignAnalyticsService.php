<?php

namespace App\Services;

use App\Models\Campaign;
use App\Models\CampaignMetaAnalyticsSnapshot;
use App\Services\WhatsappTokenRefreshService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MetaCampaignAnalyticsService
{
    public function refreshForCampaign(
        Campaign $campaign,
        ?Carbon $from = null,
        ?Carbon $to = null,
        string $granularity = 'DAILY'
    ): array {
        $whatsappAccount = $campaign->whatsappAccount;
        if (!$whatsappAccount || !$whatsappAccount->access_token || !$whatsappAccount->whatsapp_business_account_id) {
            return [
                'ok' => false,
                'message' => 'Missing WhatsApp account credentials for meta analytics',
                'snapshots' => [],
            ];
        }

        $from = ($from ?: Carbon::parse($campaign->send_at ?? $campaign->created_at ?? now()))->copy()->startOfDay();
        $to = ($to ?: now())->copy();
        if ($to->lt($from)) {
            $to = $from->copy()->endOfDay();
        }

        $confidence = $this->resolveAttributionConfidence($campaign, $from, $to);
        $wabaId = $whatsappAccount->whatsapp_business_account_id;
        $token = $whatsappAccount->access_token;
        $normalizedGranularity = $this->normalizeGranularity($granularity);

        $sources = [
            'conversation_analytics' => [
                'granularity' => $normalizedGranularity,
                'start' => $from->timestamp,
                'end' => $to->timestamp,
            ],
            'pricing_analytics' => [
                'granularity' => $normalizedGranularity,
                'start' => $from->timestamp,
                'end' => $to->timestamp,
            ],
        ];

        $templateIds = $this->resolveTemplateIds($campaign);
        if (!empty($templateIds)) {
            $sources['template_analytics'] = [
                'granularity' => $normalizedGranularity,
                'start' => $from->timestamp,
                'end' => $to->timestamp,
                'metric_types' => json_encode(['SENT', 'DELIVERED', 'READ', 'CLICKED']),
                'template_ids' => json_encode($templateIds),
            ];
        }

        $snapshots = [];

        foreach ($sources as $sourceType => $params) {
            $responsePayload = $this->fetchGraphEdge($wabaId, $sourceType, $params, $token, $whatsappAccount);
            $fingerprint = sha1(json_encode([
                'campaign' => $campaign->id,
                'source' => $sourceType,
                'params' => $params,
            ]));

            $snapshot = CampaignMetaAnalyticsSnapshot::updateOrCreate(
                [
                    'campaign_id' => $campaign->id,
                    'source_type' => $sourceType,
                    'request_fingerprint' => $fingerprint,
                ],
                [
                    'date_start' => $from,
                    'date_end' => $to,
                    'granularity' => $normalizedGranularity,
                    'payload_json' => $responsePayload,
                    'attribution_confidence' => $confidence,
                    'is_estimated' => 1,
                    'fetched_at' => now(),
                ]
            );

            $snapshots[$sourceType] = $snapshot;
        }

        return [
            'ok' => true,
            'message' => 'Meta analytics snapshot refreshed',
            'snapshots' => $snapshots,
            'attribution_confidence' => $confidence,
        ];
    }

    private function fetchGraphEdge(string $wabaId, string $edge, array $params, string $token, $whatsappAccount = null): array
    {
        $url = "https://graph.facebook.com/v22.0/{$wabaId}/{$edge}";

        try {
            $response = Http::timeout(20)
                ->retry(2, 500)
                ->withToken($token)
                ->acceptJson()
                ->get($url, $params);

            $payload = $response->json();
            if (!is_array($payload)) {
                $payload = ['raw' => (string) $response->body()];
            }

            // Auto-retry on token expiry
            $errorCode = $payload['error']['code'] ?? null;
            $errorSubcode = $payload['error']['error_subcode'] ?? null;
            $isTokenExpired = $response->status() === 401
                || $errorCode == 190
                || $errorSubcode == 463
                || $errorSubcode == 467;

            if ($isTokenExpired && $whatsappAccount) {
                Log::warning('MetaCampaignAnalyticsService: token expired, attempting refresh', [
                    'edge' => $edge,
                    'account_id' => $whatsappAccount->id,
                ]);

                $refreshed = WhatsappTokenRefreshService::refreshTokenForAccount($whatsappAccount);
                if ($refreshed) {
                    $whatsappAccount->refresh();
                    $newToken = $whatsappAccount->access_token;

                    $response = Http::timeout(20)
                        ->retry(2, 500)
                        ->withToken($newToken)
                        ->acceptJson()
                        ->get($url, $params);

                    $payload = $response->json();
                    if (!is_array($payload)) {
                        $payload = ['raw' => (string) $response->body()];
                    }

                    Log::info('MetaCampaignAnalyticsService: retried after token refresh', [
                        'edge' => $edge,
                        'success' => $response->successful(),
                    ]);
                }
            }

            return [
                'ok' => $response->successful(),
                'status' => $response->status(),
                'request' => [
                    'url' => $url,
                    'params' => $params,
                ],
                'payload' => $payload,
            ];
        } catch (Throwable $e) {
            return [
                'ok' => false,
                'status' => 0,
                'request' => [
                    'url' => $url,
                    'params' => $params,
                ],
                'payload' => [
                    'error' => [
                        'message' => $e->getMessage(),
                    ],
                ],
            ];
        }
    }

    private function resolveTemplateIds(Campaign $campaign): array
    {
        $templateId = (string) ($campaign->template->whatsapp_template_id ?? '');
        $templateId = trim($templateId);

        if ($templateId === '') {
            return [];
        }

        return [$templateId];
    }

    private function normalizeGranularity(string $granularity): string
    {
        $value = strtoupper(trim($granularity));

        return match ($value) {
            'DAY', 'DAILY' => 'DAILY',
            'HALF_HOUR', 'HALFHOUR', 'HALF-HOUR' => 'HALF_HOUR',
            'MONTH', 'MONTHLY' => 'MONTHLY',
            default => 'DAILY',
        };
    }

    private function resolveAttributionConfidence(Campaign $campaign, Carbon $from, Carbon $to): string
    {
        $overlapCount = Campaign::where('id', '!=', $campaign->id)
            ->where('user_id', $campaign->user_id)
            ->where('whatsapp_account_id', $campaign->whatsapp_account_id)
            ->where('template_id', $campaign->template_id)
            ->whereBetween('send_at', [$from, $to])
            ->count();

        if ($overlapCount === 0) {
            return 'high';
        }

        if ($overlapCount <= 2) {
            return 'medium';
        }

        return 'low';
    }
}