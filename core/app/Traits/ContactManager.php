<?php

namespace App\Traits;

use App\Constants\Status;
use App\Lib\WhatsApp\WhatsAppLib;
use App\Models\Contact;
use App\Models\ContactList;
use App\Models\ContactTag;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

trait ContactManager
{

    public $module = "contact";

    public function list()
    {
        $user = getParentUser();
        $contactTags = ContactTag::where('user_id', $user->id)->orderBy('name')->get();
        $baseQuery = Contact::where('user_id', $user->id)
            ->with('lists', 'tags', 'conversation')
            ->searchable(['mobile', 'firstname', 'lastname'])
            ->orderBy('id', 'desc');

        $tagId = request()->tag_id;

        if ($tagId) {
            $baseQuery->whereHas('tags', function ($q) use ($tagId) {
                $q->where('contact_tags.id', $tagId);
            });
        }
        if ($this->module == 'customer') {
            $baseQuery->where('is_customer', Status::YES);
        }

        $contactLists = ContactList::where('user_id', $user->id)->orderBy('name')->get();
        $pageTitle = "All " . $this->moduleNameTitle();
        $contacts = $baseQuery->apiQuery();
        $view = 'Template::user.' . $this->module . '.index';

        return responseManager($this->module, $pageTitle, "success", [
            'pageTitle' => $pageTitle,
            'view' => $view,
            'contacts' => $contacts,
            'contactTags' => $contactTags,
            'contactLists' => $contactLists,
            'profilePath' => getFilePath('contactProfile')
        ]);
    }

    public function create()
    {
        $user = getParentUser();
        $pageTitle = "Add " . ucfirst($this->module);
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $contactLists = ContactList::where('user_id', $user->id)->orderBy('name')->get();
        $contactTags = ContactTag::where('user_id', $user->id)->orderBy('name')->get();
        $view = 'Template::user.' . $this->module . '.create';

        return responseManager($this->module, $pageTitle, "success", [
            'pageTitle' => $pageTitle,
            'view' => $view,
            'countries' => $countries,
            'contactLists' => $contactLists,
            'contactTags' => $contactTags
        ]);
    }

    public function saveContact(Request $request, $id = 0)
    {
        $user = getParentUser();
        $request->validate([
            'firstname' => 'required|string|max:40',
            'lastname' => 'required|string|max:40',
            'mobile_code' => 'required',
            'profile_image' => 'nullable|mimes:jpg,jpeg,png',
            'mobile' => ['required', 'regex:/^([0-9]*)$/', Rule::unique('contacts')->ignore($id)->where('mobile_code', $request->mobile_code)->where('user_id', $user->id)],
            'tags' => 'nullable|array',
            'lists' => 'nullable|array',
            'attributes' => 'nullable|array',
        ]);

        if (!$id && !featureAccessLimitCheck($user->contact_limit)) {
            $notify = 'You???ve reached your ' . $this->module . ' limit. Please upgrade your plan to continue.';
            return responseManager("contact_limit", $notify, "error");
        }

        if ($id) {
            $message = $this->moduleNameTitle() . " updated successfully";
            $contact = Contact::where('user_id', $user->id)->find($id);
            if (!$contact) {
                $notify = $this->moduleNameTitle() . ' not found';
                return responseManager("not_found", $notify, "error");
            }
        } else {
            $message = $this->moduleNameTitle() . " created successfully";
            $contact = new Contact();
            $contact->user_id = $user->id;
            if ($this->module == 'customer') {
                $contact->is_customer = Status::YES;
            }
        }

        $contact->firstname = $request->firstname;
        $contact->lastname = $request->lastname;
        $contact->mobile_code = $request->mobile_code;
        $contact->mobile = $request->mobile;


        if ($request->custom_attributes && is_array($request->custom_attributes) && count($request->custom_attributes)) {
            $attributeNames = $request->custom_attributes['name'] ?? [];
            $attributeValues = $request->custom_attributes['value'] ?? [];

            $attributeNames = array_values(array_filter($attributeNames, fn($name) => !is_null($name) && $name !== ''));
            $attributeValues = array_values(array_filter($attributeValues, fn($value) => !is_null($value) && $value !== ''));

            if (count($attributeNames) === count($attributeValues) && count($attributeNames) > 0) {
                $contact->details = array_combine($attributeNames, $attributeValues);
            }
        } else {
            $contact->details = [];
        }

        if ($request->hasFile('profile_image')) {
            try {
                $old = $contact->image;
                $contact->image = fileUploader($request->profile_image, getFilePath('contactProfile'), getFileSize('contactProfile'), $old);
            } catch (\Exception $exp) {
                $notify = 'Couldn\'t upload your image';
                return responseManager("upload_error", $notify, "error");
            }
        }

        $contact->save();
        if (!$id) {
            decrementFeature($user, 'contact_limit');
        }

        $contact->tags()->sync($request->tags ?? []);
        $contact->lists()->sync($request->lists ?? []);
        return responseManager("contact_created", $message, "success");
    }

    public function importContact(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'file' => ['required', 'file', 'max:2048', "mimes:csv,xlsx,xls,txt"]
        ]);

        if ($validator->fails()) {
            return apiResponse('validation_error', 'error', $validator->errors()->all());
        }

        $contactList = null;
        if ($request->contact_list_id) {
            $contactList = ContactList::where('user_id', getParentUser()->id)->find($request->contact_list_id);

            if (!$contactList) {
                return apiResponse('not_found', 'error', ['Contact list not found']);
            }
        }

        $references = [];

        if ($contactList) {
            $references['contact_list_id'] = $contactList->id;
        }

        $columnNames = ['firstname', 'lastname', 'mobile_code', 'mobile'];
        $aliases = [
            'firstname' => ['name', 'first_name', 'saved_name', 'public_name', 'given_name', 'first name'],
            'lastname' => ['last_name', 'surname', 'family_name', 'last name'],
            'mobile' => ['phone', 'phone_number', 'cell', 'contact_number', 'phone number'],
            'mobile_code' => ['country_code', 'dial_code', 'code', 'country code']
        ];

        // Fallback: If no headers found, assume Col 0 is Name, Col 1 is Mobile
        $fallbackMap = [
            'firstname' => 0,
            'mobile' => 1
        ];

        $notify = [];

        try {
            $import = importFileReader($request->file, $columnNames, $columnNames, references: $references, aliases: $aliases, fallbackMap: $fallbackMap);
            $notify[] = $import->notifyMessage();
            $status = "success";
        } catch (Exception $ex) {
            $status = "error";
            $notify[] = $ex->getMessage();
        }
        return apiResponse("contact_import", $status, $notify);
    }

    public function groupContactImport(Request $request)
    {
        $request->validate([
            'paste_text'      => 'required|string',
            'contact_list_id' => 'nullable|exists:contact_lists,id',
            'country_hint'    => 'nullable|string|max:10',
        ]);

        $user = getParentUser();
        $text = $request->paste_text;
        $countryHint = strtoupper(trim($request->country_hint ?? '')) ?: 'PK';

        /*
         * ──────────────────────────────────────────────────────────────
         *  UNIVERSAL PHONE EXTRACTION - handles ANY pasted format:
         *   • Pipe-separated:  +923001234567|+923012345678
         *   • One per line:    +92 300 1234567\n+92 301 2345678
         *   • CSV rows:        John Doe,+923001234567
         *   • Name + number:   John (+92 300 1234567)
         *   • Raw digits:      923001234567
         *   • vCard:           TEL:+923001234567
         *   • Mixed free text with numbers embedded anywhere
         * ──────────────────────────────────────────────────────────────
         */

        $entries = $this->extractPhoneEntries($text);

        $importedCount  = 0;
        $duplicateCount = 0;
        $invalidCount   = 0;
        $namePrefix     = $request->name_prefix ?: '';

        foreach ($entries as $entry) {
            $rawPhone = $entry['phone'];
            $rawName  = $entry['name'];
            $digits   = preg_replace('/\D/', '', $rawPhone);

            // Validate digit length (international range)
            if (strlen($digits) < 7 || strlen($digits) > 15) {
                $invalidCount++;
                continue;
            }

            // Try libphonenumber validation if available
            $mobileCode    = '';
            $nationalNumber = $digits;
            try {
                $util = \libphonenumber\PhoneNumberUtil::getInstance();
                $inputForParsing = $digits;
                if (!str_starts_with($digits, '0') && !str_starts_with($rawPhone, '+')) {
                    $inputForParsing = '+' . $digits;
                }
                $parsed = $util->parse($inputForParsing, $countryHint);
                if ($util->isValidNumber($parsed) || $util->isPossibleNumber($parsed)) {
                    $mobileCode     = '+' . $parsed->getCountryCode();
                    $nationalNumber = (string) $parsed->getNationalNumber();
                    $digits         = preg_replace('/\D/', '', $util->format($parsed, \libphonenumber\PhoneNumberFormat::E164));
                }
            } catch (\Throwable $e) {
                // libphonenumber not available or parse failed — keep raw digits
            }

            // Broad duplicate check against CRM (multiple matching strategies)
            $last10  = strlen($digits) >= 10 ? substr($digits, -10) : $digits;
            $exists  = Contact::where('user_id', $user->id)
                ->where(function ($q) use ($digits, $nationalNumber, $last10) {
                    $q->where('mobile', $digits)
                      ->orWhere('mobile', $nationalNumber)
                      ->orWhere('mobile', ltrim($digits, '0'))
                      ->orWhereRaw("REPLACE(REPLACE(CONCAT(COALESCE(mobile_code,''),COALESCE(mobile,'')), '+', ''), ' ', '') = ?", [$digits]);
                    if (strlen($last10) >= 10) {
                        $q->orWhere('mobile', 'LIKE', '%' . $last10);
                    }
                })->exists();

            if ($exists) {
                $duplicateCount++;
                continue;
            }

            // Feature limit check
            if (!featureAccessLimitCheck($user->contact_limit)) {
                break;
            }

            // Create contact
            $contact          = new Contact();
            $contact->user_id = $user->id;

            // Name derivation
            if (!empty($rawName) && mb_strlen($rawName) > 1 && !preg_match('/^\d+$/', $rawName)) {
                $nameParts          = preg_split('/\s+/', trim($rawName), 2);
                $contact->firstname = mb_substr($nameParts[0], 0, 40);
                $contact->lastname  = isset($nameParts[1]) ? mb_substr($nameParts[1], 0, 40) : substr($digits, -4);
            } else {
                $contact->firstname = $namePrefix ?: 'Group Member';
                $contact->lastname  = substr($digits, -4);
            }

            $contact->mobile      = $nationalNumber ?: $digits;
            $contact->mobile_code = $mobileCode;
            $contact->save();

            if ($request->contact_list_id) {
                $contact->lists()->syncWithoutDetaching([$request->contact_list_id]);
            }

            $importedCount++;
            decrementFeature($user, 'contact_limit');
        }

        $parts = ["Imported $importedCount unique contacts."];
        if ($duplicateCount > 0) $parts[] = "$duplicateCount duplicates skipped.";
        if ($invalidCount > 0)   $parts[] = "$invalidCount invalid numbers skipped.";
        $notify[] = ['success', implode(' ', $parts)];
        return back()->withNotify($notify);
    }

    /**
     * Multi-strategy phone number extraction from ANY pasted text.
     * Returns array of ['phone' => ..., 'name' => ...] entries.
     */
    private function extractPhoneEntries(string $text): array
    {
        $entries = [];
        $seenKeys = [];

        // Normalize line endings
        $text = str_replace(["\r\n", "\r"], "\n", $text);
        $text = trim($text);

        if (empty($text)) {
            return [];
        }

        // ───── Strategy 1: vCard format ─────
        if (stripos($text, 'BEGIN:VCARD') !== false) {
            preg_match_all('/BEGIN:VCARD.*?END:VCARD/si', $text, $vCards);
            foreach ($vCards[0] ?? [] as $vCard) {
                $name  = '';
                $phone = '';
                if (preg_match('/FN[;:]([^\r\n]+)/i', $vCard, $m)) {
                    $name = trim($m[1]);
                }
                if (preg_match('/TEL[^:]*:([^\r\n]+)/i', $vCard, $m)) {
                    $phone = trim($m[1]);
                }
                if ($phone) {
                    $this->addPhoneEntry($entries, $seenKeys, $phone, $name);
                }
            }
        }

        // ───── Strategy 2: JSON array (from extension copy) ─────
        $trimmed = trim($text);
        if (str_starts_with($trimmed, '[') || str_starts_with($trimmed, '{')) {
            try {
                $decoded = json_decode($trimmed, true);
                if (is_array($decoded)) {
                    $items = isset($decoded[0]) ? $decoded : [$decoded];
                    foreach ($items as $item) {
                        if (!is_array($item)) continue;
                        $phone = $item['phone_raw'] ?? $item['phone'] ?? $item['mobile'] ?? '';
                        $name  = $item['name'] ?? $item['full_name'] ?? $item['firstname'] ?? '';
                        if ($phone) {
                            $this->addPhoneEntry($entries, $seenKeys, $phone, $name);
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Not valid JSON — fall through to text strategies
            }
        }

        // ───── Strategy 3: Line-by-line / chunk-by-chunk parsing ─────
        // Split on newlines, pipes, semicolons, tabs
        $chunks = preg_split('/[\n\|;\t]+/', $text);

        foreach ($chunks as $chunk) {
            $chunk = trim($chunk);
            if (empty($chunk)) continue;

            // Skip header-like rows
            if (preg_match('/^(name|phone|mobile|number|contact|firstname|lastname|tel|email)[,\s:;|]/i', $chunk)) {
                continue;
            }

            // Find ALL phone-like patterns in this chunk
            // Pattern matches: +XX XXXXXXXXX, (0XX) XXX-XXXX, 00XXXXXXXXXXX, 0XXXXXXXXXX, XXXXXXXXXXX, etc.
            $phonePattern = '/(?:\+\s*)?(?:00\s*)?(?:\(?\d{1,4}\)?\s*[-.\s]?\s*){1,}\d{2,}/';
            preg_match_all($phonePattern, $chunk, $phoneMatches);

            $foundPhones = [];
            $foundRawMatches = [];
            foreach ($phoneMatches[0] ?? [] as $rawMatch) {
                $d = preg_replace('/\D/', '', $rawMatch);
                if (strlen($d) >= 7 && strlen($d) <= 15) {
                    $foundPhones[]     = $d;
                    $foundRawMatches[] = $rawMatch;
                }
            }

            if (empty($foundPhones)) continue;

            // Extract name by removing phone parts from the chunk
            $remaining = $chunk;
            foreach ($foundRawMatches as $rm) {
                $remaining = str_replace($rm, ' ', $remaining);
            }
            // Clean up name: remove delimiters, noise words, trim
            $remaining = preg_replace('/[,;:\|\t\/\\\\]+/', ' ', $remaining);
            $remaining = preg_replace('/\s+/', ' ', trim($remaining));
            $remaining = preg_replace('/^[\s\-\.\,;:]+|[\s\-\.\,;:]+$/', '', $remaining);
            // Remove noise-only tokens
            if (preg_match('/^(tel|phone|mobile|cell|contact|name|number|no|num|member|\d{1,3})$/i', $remaining)) {
                $remaining = '';
            }
            $namePart = mb_strlen($remaining) > 1 ? $remaining : '';

            foreach ($foundPhones as $phone) {
                $this->addPhoneEntry($entries, $seenKeys, $phone, $namePart);
            }
        }

        // ───── Strategy 4: Global sweep for any missed phone numbers ─────
        // Run a broad regex over the entire text to catch anything the chunk-based scan missed
        preg_match_all('/(?:\+\s*)?(?:00)?\d[\d\s\-\.\(\)]{5,18}\d/', $text, $globalMatches);
        foreach ($globalMatches[0] ?? [] as $gm) {
            $d = preg_replace('/\D/', '', $gm);
            if (strlen($d) >= 7 && strlen($d) <= 15) {
                $this->addPhoneEntry($entries, $seenKeys, $d, '');
            }
        }

        return $entries;
    }

    /**
     * Add a phone entry if not already seen (deduplicates by last 10 digits).
     */
    private function addPhoneEntry(array &$entries, array &$seenKeys, string $phone, string $name): void
    {
        $digits = preg_replace('/\D/', '', $phone);
        if (strlen($digits) < 7 || strlen($digits) > 15) {
            return;
        }

        // Normalize: strip leading 00
        if (str_starts_with($digits, '00') && strlen($digits) > 10) {
            $digits = substr($digits, 2);
        }

        // Deduplicate by last 10 digits
        $key = strlen($digits) >= 10 ? substr($digits, -10) : $digits;
        if (isset($seenKeys[$key])) {
            return;
        }
        $seenKeys[$key] = true;

        $entries[] = [
            'phone' => $digits,
            'name'  => trim($name),
        ];
    }

    public function downloadCsv()
    {
        $filePath = "assets/export_templates/contact.csv";

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        return responseManager("not_found", "File not found", "error");
    }

    public function deleteContact($id)
    {
        $contact = Contact::where('user_id', getParentUser()->id)->findOrFailWithApi('contact', $id);

        if ($contact->conversation && $contact->conversation->messages()->count() > 0) {
            $notify = 'Unable to delete ' . $this->module . ' with messages';
            return responseManager("contact_error", $notify, "error");
        }

        if ($contact->is_blocked) {
            $notify = "Unable to delete contact which is blocked";
            return responseManager("contact_error", $notify, "error");
        }

        $contact->tags()->detach();
        $contact->lists()->detach();
        $contact->delete();
        $notify = "Contact deleted successfully";
        return responseManager("contact_deleted", $notify, "success");
    }

    public function deleteContactAll(Request $request)
    {
        // Debugging: Log the entire request data
        \Log::info('Bulk Delete Request Data:', $request->all());

        $request->validate([
            'ids' => 'required',
        ]);

        $ids = json_decode($request->ids, true);

        if (!is_array($ids)) {
            $notify[] = ['error', 'Invalid selection data'];
            return back()->withNotify($notify);
        }

        $user = getParentUser();

        $contacts = Contact::where('user_id', $user->id)->whereIn('id', $ids)->get();
        $deletedCount = 0;
        $skippedCount = 0;

        foreach ($contacts as $contact) {
            if ($contact->conversation && $contact->conversation->messages()->count() > 0) {
                $skippedCount++;
                continue;
            }

            if ($contact->is_blocked) {
                $skippedCount++;
                continue;
            }

            $contact->tags()->detach();
            $contact->lists()->detach();
            $contact->delete();
            $deletedCount++;
        }

        $notify[] = ['success', "$deletedCount contacts deleted successfully." . ($skippedCount > 0 ? " ($skippedCount skipped)" : "")];
        return back()->withNotify($notify);
    }

    public function searchContact()
    {
        $user = getParentUser();
        $query = Contact::where('user_id', $user->id)->whereDoesntHave('contactListContact')->searchable(['mobile', 'firstname', 'lastname']);

        $contacts = $query->apiQuery();
        return apiResponse("contact_search", "success", [], [
            'contacts' => $contacts,
            'more' => $contacts->hasMorePages(),
        ]);
    }

    public function checkContact(Request $request, $id = 0)
    {
        $request->validate(['mobile_code' => 'required', 'mobile' => 'required']);
        $contact = Contact::where('user_id', getParentUser())->whereNot('id', $id)->where('mobile_code', $request->mobile_code)->where('mobile', $request->mobile)->first();

        if ($contact) {
            $exist['data'] = true;
        } else {
            $exist['data'] = false;
        }

        return response($exist);
    }

    public function edit($id)
    {
        $user = getParentUser();
        $module = $this->moduleNameTitle();
        $contact = Contact::where('user_id', $user->id)->findOrFail($id);
        $pageTitle = "Edit " . $module . " . - " . $contact->fullName;
        $countries = json_decode(file_get_contents(resource_path('views/partials/country.json')));
        $contactLists = ContactList::where('user_id', $user->id)->orderBy('name')->get();
        $contactTags = ContactTag::where('user_id', $user->id)->orderBy('name')->get();
        $existingTagId = $contact->tags()->pluck('contact_tag_id')->toArray();
        $existingListId = $contact->lists()->pluck('contact_list_id')->toArray();

        return view('Template::user.contact.edit', compact('pageTitle', 'countries', 'contact', 'contactLists', 'contactTags', 'existingTagId', 'existingListId', 'module'));
    }

    private function moduleNameTitle()
    {
        return ucfirst($this->module);
    }

    public function contactStatus(Request $request, $id)
    {
        $user = getParentUser();

        try {
            $contact = Contact::where('user_id', $user->id)->find($id);

            if (!$contact) {
                $notify[] = ['error', 'Contact not found'];
                return back()->withNotify($notify);
            }

            $whatsappAccount = $user->currentWhatsapp();

            if (!$whatsappAccount) {
                $notify[] = ['error', 'Please add a WhatsApp account first'];
                return back()->withNotify($notify);
            }

            $whatsappLib = new WhatsAppLib();

            if ($request->status === 'block') {
                $whatsappLib->userBlockAction($whatsappAccount, $contact);
                $contact->is_blocked = Status::YES;
                $contact->blocked_by = auth()->id();
                $message = 'Contact blocked successfully';
            } else {
                $whatsappLib->userBlockAction($whatsappAccount, $contact, 'unblock');
                $contact->is_blocked = Status::NO;
                $contact->blocked_by = 0;
                $message = 'Contact unblocked successfully';
            }

            $contact->save();

            $notify[] = ['success', $message];
            return back()->withNotify($notify);

        } catch (Exception $ex) {
            $notify[] = ['error', $ex->getMessage() ?? 'Something went wrong while updating contact status'];
            return back()->withNotify($notify);
        }
    }

}
