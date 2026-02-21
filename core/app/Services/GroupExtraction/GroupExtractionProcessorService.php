<?php

namespace App\Services\GroupExtraction;

use App\Constants\Status;
use App\Models\Contact;
use App\Models\ContactSourceEvent;
use App\Models\ContactTag;
use App\Models\GroupExtractionItem;
use App\Models\GroupExtractionJob;
use App\Models\User;
use Illuminate\Support\Str;

class GroupExtractionProcessorService
{
    public function __construct(private readonly PhoneNormalizerService $phoneNormalizer)
    {
    }

    public function processQueuedJobs(int $jobLimit = 5, int $rowLimit = 500): array
    {
        $jobs = GroupExtractionJob::where('status', Status::GROUP_EXTRACTION_JOB_QUEUED)
            ->orderBy('id')
            ->limit($jobLimit)
            ->get();

        $processed = [];
        foreach ($jobs as $job) {
            $this->processJob($job, $rowLimit);
            $processed[] = $job->id;
        }

        return $processed;
    }

    public function processJob(GroupExtractionJob $job, int $rowLimit = 500): GroupExtractionJob
    {
        $job = GroupExtractionJob::whereKey($job->id)->firstOrFail();

        if ((int) $job->status === Status::GROUP_EXTRACTION_JOB_QUEUED) {
            $claimed = GroupExtractionJob::whereKey($job->id)
                ->where('status', Status::GROUP_EXTRACTION_JOB_QUEUED)
                ->update([
                    'status' => Status::GROUP_EXTRACTION_JOB_PROCESSING,
                    'started_at' => $job->started_at ?: now(),
                    'updated_at' => now(),
                ]);
            if (!$claimed) {
                return $job->fresh();
            }
            $job = $job->fresh();
        }

        if ((int) $job->status !== Status::GROUP_EXTRACTION_JOB_PROCESSING) {
            return $job;
        }

        $user = User::find($job->user_id);
        if (!$user) {
            $job->status = Status::GROUP_EXTRACTION_JOB_FAILED;
            $job->error_json = ['message' => 'Owner user not found'];
            $job->completed_at = now();
            $job->save();
            return $job;
        }

        $items = GroupExtractionItem::where('job_id', $job->id)
            ->where('dedupe_action', Status::GROUP_EXTRACTION_ACTION_PENDING)
            ->orderBy('id')
            ->limit($rowLimit)
            ->get();

        if ($items->isEmpty()) {
            return $this->refreshJobCounters($job);
        }

        $autoTagIds = $this->ensureAutoTags($user, $job);
        $listId = $job->contact_list_id ? (int) $job->contact_list_id : null;
        $hasContactLimitFailures = false;
        $remainingContactLimit = (int) ($user->contact_limit ?? 0);
        $isUnlimitedContactLimit = (int) ($user->contact_limit ?? 0) === Status::UNLIMITED;

        foreach ($items as $item) {
            try {
                $region = $item->country_hint ?: ($job->country_hint ?: ($user->country_code ?: 'PK'));
                $normalized = $this->phoneNormalizer->normalize($item->raw_phone, $region);
                if (!$normalized['valid']) {
                    $this->markItemAsFailed($item, 'invalid_phone', $normalized['reason'] ?? 'invalid');
                    continue;
                }

                $item->validation_status = Status::GROUP_EXTRACTION_ITEM_VALID;
                $item->normalized_e164 = $normalized['e164'];
                $item->first_name = $item->first_name ?: $this->splitName($item->raw_name)['first_name'];
                $item->last_name = $item->last_name ?: $this->splitName($item->raw_name)['last_name'];
                $item->save();

                $contact = $this->findExistingContact($user, $normalized);
                if ($contact) {
                    $updated = $this->updateExistingContact($contact, $item, $job, $normalized);
                    $this->syncContactMembership($contact, $listId, $autoTagIds);
                    $this->createSourceEvent($contact, $user, $job, $item, [
                        'action' => $updated ? 'updated' : 'skipped',
                    ]);

                    $item->contact_id = $contact->id;
                    $item->dedupe_action = $updated
                        ? Status::GROUP_EXTRACTION_ACTION_UPDATED
                        : Status::GROUP_EXTRACTION_ACTION_SKIPPED;
                    $item->reason_code = $updated ? null : 'already_exists';
                    $item->reason_detail = $updated ? null : 'Contact already exists with no missing profile fields';
                    $item->processing_meta_json = [
                        'matched_by' => 'mobile_e164_or_fallback',
                        'updated' => $updated,
                    ];
                    $item->save();
                    continue;
                }

                if (!$isUnlimitedContactLimit && $remainingContactLimit <= 0) {
                    $hasContactLimitFailures = true;
                    $this->markItemAsFailed($item, 'contact_limit_reached', 'User contact limit reached');
                    continue;
                }

                $newContact = $this->createNewContact($user, $item, $job, $normalized);
                decrementFeature($user, 'contact_limit', 1);
                if (!$isUnlimitedContactLimit) {
                    $remainingContactLimit = max(0, $remainingContactLimit - 1);
                }
                $this->syncContactMembership($newContact, $listId, $autoTagIds);
                $this->createSourceEvent($newContact, $user, $job, $item, [
                    'action' => 'created',
                ]);

                $item->contact_id = $newContact->id;
                $item->dedupe_action = Status::GROUP_EXTRACTION_ACTION_CREATED;
                $item->reason_code = null;
                $item->reason_detail = null;
                $item->processing_meta_json = [
                    'created' => true,
                ];
                $item->save();
            } catch (\Throwable $exception) {
                $this->markItemAsFailed($item, 'processing_error', $exception->getMessage());
            }
        }

        return $this->refreshJobCounters($job->fresh(), $hasContactLimitFailures);
    }

    public function retryFailed(GroupExtractionJob $job, ?string $countryHint = null): int
    {
        $query = GroupExtractionItem::where('job_id', $job->id)
            ->where('dedupe_action', Status::GROUP_EXTRACTION_ACTION_FAILED);

        $retryCount = (int) $query->count();
        if ($retryCount <= 0) {
            return 0;
        }

        $data = [
            'validation_status' => Status::GROUP_EXTRACTION_ITEM_PENDING,
            'dedupe_action' => Status::GROUP_EXTRACTION_ACTION_PENDING,
            'contact_id' => null,
            'reason_code' => null,
            'reason_detail' => null,
            'processing_meta_json' => null,
            'updated_at' => now(),
        ];

        if ($countryHint) {
            $data['country_hint'] = strtoupper(substr(trim($countryHint), 0, 10));
        }

        $query->update($data);

        $job->status = Status::GROUP_EXTRACTION_JOB_QUEUED;
        $job->completed_at = null;
        $job->error_json = null;
        if ($countryHint) {
            $job->country_hint = strtoupper(substr(trim($countryHint), 0, 10));
        }
        $job->save();

        $this->refreshJobCounters($job->fresh());

        return $retryCount;
    }

    public function refreshJobCounters(GroupExtractionJob $job, bool $forcePartial = false): GroupExtractionJob
    {
        $items = GroupExtractionItem::where('job_id', $job->id);

        $pending = (clone $items)->where('dedupe_action', Status::GROUP_EXTRACTION_ACTION_PENDING)->count();
        $valid = (clone $items)->where('validation_status', Status::GROUP_EXTRACTION_ITEM_VALID)->count();
        $invalid = (clone $items)->where('validation_status', Status::GROUP_EXTRACTION_ITEM_INVALID)->count();

        $created = (clone $items)->where('dedupe_action', Status::GROUP_EXTRACTION_ACTION_CREATED)->count();
        $updated = (clone $items)->where('dedupe_action', Status::GROUP_EXTRACTION_ACTION_UPDATED)->count();
        $skipped = (clone $items)->where('dedupe_action', Status::GROUP_EXTRACTION_ACTION_SKIPPED)->count();
        $failed = (clone $items)->where('dedupe_action', Status::GROUP_EXTRACTION_ACTION_FAILED)->count();

        $total = (int) (clone $items)->count();
        $processed = max($total - $pending, 0);

        $job->total_rows = $total;
        $job->processed_rows = $processed;
        $job->valid_rows = (int) $valid;
        $job->invalid_rows = (int) $invalid;
        $job->imported_count = (int) $created;
        $job->updated_count = (int) $updated;
        $job->skipped_count = (int) $skipped;
        $job->failed_count = (int) $failed;
        $job->duplicate_in_crm_count = (int) ($updated + $skipped);
        $job->started_at = $job->started_at ?: now();

        if ($pending > 0) {
            $job->status = Status::GROUP_EXTRACTION_JOB_QUEUED;
            $job->completed_at = null;
        } else {
            if ($failed > 0) {
                if (($created + $updated + $skipped) > 0 || $forcePartial) {
                    $job->status = Status::GROUP_EXTRACTION_JOB_PARTIAL;
                } else {
                    $job->status = Status::GROUP_EXTRACTION_JOB_FAILED;
                }
            } else {
                $job->status = Status::GROUP_EXTRACTION_JOB_COMPLETED;
            }
            $job->completed_at = now();
        }

        $job->save();
        return $job->fresh();
    }

    private function createNewContact(User $user, GroupExtractionItem $item, GroupExtractionJob $job, array $normalized): Contact
    {
        $nameParts = $this->splitName($item->raw_name);
        $fallbackSuffix = substr($normalized['digits'], -4);
        $firstName = $nameParts['first_name'] ?: 'Group Member';
        $lastName = $nameParts['last_name'] ?: $fallbackSuffix;

        $details = [];
        if ($item->raw_name) {
            $details['group_aliases'] = [$item->raw_name];
        }

        $contact = new Contact();
        $contact->user_id = $user->id;
        $contact->firstname = mb_substr($firstName, 0, 40);
        $contact->lastname = mb_substr($lastName, 0, 40);
        $contact->mobile_code = $normalized['mobile_code'] ?? '';
        $contact->mobile = mb_substr((string) ($normalized['national_number'] ?? ''), 0, 40);
        $contact->mobile_e164 = $normalized['e164'];
        $contact->details = $details;
        $contact->last_source_type = 'wa_group_extract';
        $contact->last_source_ref = 'job:' . $job->id;
        $contact->last_seen_at = now();
        $contact->name_confidence = $nameParts['confidence'];
        $contact->save();

        return $contact;
    }

    private function updateExistingContact(Contact $contact, GroupExtractionItem $item, GroupExtractionJob $job, array $normalized): bool
    {
        $nameParts = $this->splitName($item->raw_name);
        $updated = false;

        if (!$contact->mobile_e164) {
            $contact->mobile_e164 = $normalized['e164'];
            $updated = true;
        }

        if (!$contact->firstname && $nameParts['first_name']) {
            $contact->firstname = mb_substr($nameParts['first_name'], 0, 40);
            $updated = true;
        }

        if (!$contact->lastname && $nameParts['last_name']) {
            $contact->lastname = mb_substr($nameParts['last_name'], 0, 40);
            $updated = true;
        }

        $details = is_array($contact->details) ? $contact->details : [];
        if (!isset($details['group_aliases']) || !is_array($details['group_aliases'])) {
            $details['group_aliases'] = [];
        }

        if ($item->raw_name) {
            $existingName = trim((string) ($contact->firstname . ' ' . $contact->lastname));
            if (strcasecmp($existingName, trim($item->raw_name)) !== 0 && !in_array($item->raw_name, $details['group_aliases'], true)) {
                $details['group_aliases'][] = $item->raw_name;
                $updated = true;
            }
        }

        $contact->details = $details;
        $contact->last_source_type = 'wa_group_extract';
        $contact->last_source_ref = 'job:' . $job->id;
        $contact->last_seen_at = now();
        $contact->name_confidence = max((float) ($contact->name_confidence ?? 0), (float) $nameParts['confidence']);

        if ($contact->isDirty()) {
            $contact->save();
            $updated = true;
        }

        return $updated;
    }

    private function findExistingContact(User $user, array $normalized): ?Contact
    {
        $byE164 = Contact::where('user_id', $user->id)
            ->where('mobile_e164', $normalized['e164'])
            ->first();

        if ($byE164) {
            return $byE164;
        }

        $digits = $normalized['digits'];
        $national = (string) ($normalized['national_number'] ?? '');

        return Contact::where('user_id', $user->id)
            ->where(function ($query) use ($digits, $national) {
                $query->whereRaw(
                    "REPLACE(CONCAT(COALESCE(mobile_code,''),COALESCE(mobile,'')), '+', '') = ?",
                    [$digits]
                );
                if ($national !== '') {
                    $query->orWhere('mobile', $national);
                }
            })
            ->first();
    }

    private function splitName(?string $rawName): array
    {
        $rawName = trim((string) $rawName);
        $rawName = preg_replace('/\s+/', ' ', $rawName ?? '');
        $rawName = trim((string) $rawName);

        if ($rawName === '') {
            return [
                'first_name' => '',
                'last_name' => '',
                'confidence' => 0.2,
            ];
        }

        $parts = explode(' ', $rawName);
        $first = array_shift($parts) ?: '';
        $last = trim(implode(' ', $parts));

        return [
            'first_name' => mb_substr($first, 0, 40),
            'last_name' => mb_substr($last, 0, 40),
            'confidence' => $last !== '' ? 0.95 : 0.75,
        ];
    }

    private function syncContactMembership(Contact $contact, ?int $listId, array $tagIds): void
    {
        if ($listId) {
            $contact->lists()->syncWithoutDetaching([$listId]);
        }

        if (!empty($tagIds)) {
            $contact->tags()->syncWithoutDetaching($tagIds);
        }
    }

    private function createSourceEvent(Contact $contact, User $user, GroupExtractionJob $job, GroupExtractionItem $item, array $meta = []): void
    {
        ContactSourceEvent::create([
            'contact_id' => $contact->id,
            'user_id' => $user->id,
            'source_type' => 'wa_group_extract',
            'source_ref_type' => 'group_extraction_item',
            'source_ref_id' => $item->id,
            'group_name' => $job->group_name,
            'group_identifier' => $job->group_identifier,
            'captured_at' => now(),
            'meta_json' => $meta,
        ]);
    }

    private function ensureAutoTags(User $user, GroupExtractionJob $job): array
    {
        $groupSlug = Str::slug((string) ($job->group_name ?: 'group'));
        if ($groupSlug === '') {
            $groupSlug = 'group';
        }

        $candidateTags = [
            'wa_group',
            mb_substr('group:' . $groupSlug, 0, 40),
            mb_substr('extract:' . now()->format('Y-m-d'), 0, 40),
        ];

        $tagIds = [];
        foreach ($candidateTags as $tagName) {
            $tagName = trim($tagName);
            if ($tagName === '') {
                continue;
            }

            $tag = ContactTag::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => $tagName,
                ],
                [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
            $tagIds[] = $tag->id;
        }

        return array_values(array_unique($tagIds));
    }

    private function markItemAsFailed(GroupExtractionItem $item, string $code, ?string $detail = null): void
    {
        $item->validation_status = Status::GROUP_EXTRACTION_ITEM_INVALID;
        $item->dedupe_action = Status::GROUP_EXTRACTION_ACTION_FAILED;
        $item->reason_code = mb_substr($code, 0, 64);
        $item->reason_detail = $detail ? mb_substr($detail, 0, 5000) : null;
        $item->processing_meta_json = [
            'failed_at' => now()->toIso8601String(),
        ];
        $item->save();
    }
}
