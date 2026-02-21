<?php

namespace App\Services\GroupExtraction;

use App\Constants\Status;
use App\Models\ContactList;
use App\Models\GroupExtractionItem;
use App\Models\GroupExtractionJob;
use App\Models\GroupExtractionSession;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GroupExtractionIngestService
{
    public function createJob(User $user, GroupExtractionSession $session, array $payload): GroupExtractionJob
    {
        $todayRows = (int) GroupExtractionJob::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->sum('total_rows');

        $maxRowsPerDay = (int) config('group_extraction.max_rows_per_day', 50000);
        if ($todayRows >= $maxRowsPerDay) {
            throw ValidationException::withMessages([
                'limit' => "Daily extraction row limit reached ($maxRowsPerDay).",
            ]);
        }

        $groupName = $this->cleanText($payload['group_name'] ?? null, 191);
        $groupIdentifier = $this->cleanText($payload['group_identifier'] ?? null, 191);
        $countryHint = strtoupper($this->cleanText($payload['country_hint'] ?? null, 10) ?? '');
        $chunkSize = $this->clamp((int) ($payload['chunk_size'] ?? config('group_extraction.default_chunk_size', 500)), 50, 1000);

        $contactListId = $this->resolveContactListId(
            $user,
            $payload['target_contact_list_id'] ?? null,
            $groupName ?: 'WhatsApp Group'
        );

        return GroupExtractionJob::create([
            'user_id' => $user->id,
            'whatsapp_account_id' => $payload['whatsapp_account_id'] ?? getWhatsappAccountId($user),
            'session_id' => $session->id,
            'source' => 'extension',
            'group_name' => $groupName,
            'group_identifier' => $groupIdentifier,
            'status' => Status::GROUP_EXTRACTION_JOB_INGESTING,
            'contact_list_id' => $contactListId,
            'country_hint' => $countryHint ?: ($user->country_code ?: 'PK'),
            'chunk_size' => $chunkSize,
            'meta_json' => [
                'attested_at' => optional($session->attested_at)?->toIso8601String(),
                'attestation_text_version' => $session->attestation_text_version,
                'source' => 'extension',
                'is_finalized' => false,
            ],
        ]);
    }

    public function appendMembers(GroupExtractionJob $job, array $members): array
    {
        return DB::transaction(function () use ($job, $members) {
            $job = GroupExtractionJob::whereKey($job->id)->lockForUpdate()->firstOrFail();

            if ((int) $job->status !== Status::GROUP_EXTRACTION_JOB_INGESTING) {
                throw ValidationException::withMessages([
                    'job' => 'Job is not accepting new chunks.',
                ]);
            }

            $maxRowsPerDay = (int) config('group_extraction.max_rows_per_day', 50000);
            $todayRows = (int) GroupExtractionJob::where('user_id', $job->user_id)
                ->whereDate('created_at', now()->toDateString())
                ->sum('total_rows');
            if (($todayRows + count($members)) > $maxRowsPerDay) {
                throw ValidationException::withMessages([
                    'limit' => "Daily extraction row limit reached ($maxRowsPerDay).",
                ]);
            }

            $maxMembersPerJob = (int) config('group_extraction.max_members_per_job', 10000);
            if (($job->total_rows + count($members)) > $maxMembersPerJob) {
                throw ValidationException::withMessages([
                    'members' => "Maximum $maxMembersPerJob members are allowed per job.",
                ]);
            }

            $accepted = 0;
            $duplicateInJob = 0;
            $nextRow = (int) $job->total_rows + 1;
            $chunkSeen = [];
            $prepared = [];

            foreach ($members as $member) {
                $name = $this->cleanText($member['name'] ?? $member['full_name'] ?? null, 191);
                $rawPhone = $this->cleanText($member['phone_raw'] ?? $member['phone'] ?? null, 120);
                $countryHint = strtoupper($this->cleanText($member['country_hint'] ?? $job->country_hint, 10) ?: '');
                $sourceHash = $this->sourceHash($name, (string) ($rawPhone ?? ''));

                if (isset($chunkSeen[$sourceHash])) {
                    $duplicateInJob++;
                    continue;
                }

                $chunkSeen[$sourceHash] = true;
                $prepared[] = [
                    'source_hash' => $sourceHash,
                    'raw_name' => $name,
                    'raw_phone' => $rawPhone,
                    'country_hint' => $countryHint,
                ];
            }

            $existingHashes = [];
            if (!empty($prepared)) {
                $existingHashes = GroupExtractionItem::where('job_id', $job->id)
                    ->whereIn('source_hash', array_column($prepared, 'source_hash'))
                    ->pluck('source_hash')
                    ->flip()
                    ->all();
            }

            $now = now();
            $rowsToInsert = [];
            foreach ($prepared as $row) {
                if (isset($existingHashes[$row['source_hash']])) {
                    $duplicateInJob++;
                    continue;
                }

                $missingPhone = empty($row['raw_phone']);
                $rowsToInsert[] = [
                    'job_id' => $job->id,
                    'row_no' => $nextRow,
                    'source_hash' => $row['source_hash'],
                    'raw_name' => $row['raw_name'],
                    'raw_phone' => $row['raw_phone'],
                    'country_hint' => $row['country_hint'],
                    'validation_status' => $missingPhone
                        ? Status::GROUP_EXTRACTION_ITEM_INVALID
                        : Status::GROUP_EXTRACTION_ITEM_PENDING,
                    'dedupe_action' => $missingPhone
                        ? Status::GROUP_EXTRACTION_ACTION_FAILED
                        : Status::GROUP_EXTRACTION_ACTION_PENDING,
                    'reason_code' => $missingPhone ? 'missing_phone' : null,
                    'reason_detail' => $missingPhone ? 'Phone number is missing in extracted row' : null,
                    'processing_meta_json' => $missingPhone ? json_encode([
                        'failed_at' => $now->toIso8601String(),
                    ]) : null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $nextRow++;
                $accepted++;
            }

            if (!empty($rowsToInsert)) {
                GroupExtractionItem::insert($rowsToInsert);
            }

            $job->total_rows += $accepted;
            $job->duplicate_in_job_count += $duplicateInJob;
            $job->save();

            return [
                'accepted_count' => $accepted,
                'duplicate_in_job_count' => $duplicateInJob,
                'total_rows' => (int) $job->total_rows,
            ];
        });
    }

    public function finalizeJob(GroupExtractionJob $job): GroupExtractionJob
    {
        $meta = $job->meta_json ?? [];
        $meta['is_finalized'] = true;
        $meta['finalized_at'] = now()->toIso8601String();

        if ((int) $job->total_rows <= 0) {
            $job->status = Status::GROUP_EXTRACTION_JOB_FAILED;
            $job->error_json = ['message' => 'No members were uploaded for this job'];
            $job->completed_at = now();
        } else {
            $job->status = Status::GROUP_EXTRACTION_JOB_QUEUED;
            $job->completed_at = null;
        }

        $job->meta_json = $meta;
        $job->save();

        return $job->fresh();
    }

    private function sourceHash(?string $name, ?string $rawPhone): string
    {
        $phoneDigits = preg_replace('/\D+/', '', (string) $rawPhone);
        if ($phoneDigits !== '') {
            return hash('sha256', $phoneDigits);
        }

        $name = mb_strtolower(trim((string) $name));
        return hash('sha256', 'missing_phone|' . $name);
    }

    private function resolveContactListId(User $user, $requestedListId, string $groupName): int
    {
        if ($requestedListId) {
            $existing = ContactList::where('user_id', $user->id)->where('id', $requestedListId)->first();
            if ($existing) {
                return (int) $existing->id;
            }
        }

        $listName = $this->cleanText('WA Group - ' . $groupName . ' - ' . now()->format('d M H:i'), 40) ?: 'WA Group Import';
        $list = new ContactList();
        $list->user_id = $user->id;
        $list->name = $listName;
        $list->save();

        return (int) $list->id;
    }

    private function cleanText($value, int $limit): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        return mb_substr($value, 0, $limit);
    }

    private function clamp(int $value, int $min, int $max): int
    {
        if ($value < $min) {
            return $min;
        }
        if ($value > $max) {
            return $max;
        }
        return $value;
    }
}
