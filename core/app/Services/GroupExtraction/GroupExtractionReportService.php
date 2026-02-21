<?php

namespace App\Services\GroupExtraction;

use App\Models\GroupExtractionItem;
use App\Models\GroupExtractionJob;
use App\Models\User;

class GroupExtractionReportService
{
    public function status(GroupExtractionJob $job): array
    {
        $job = $job->fresh();
        $total = (int) $job->total_rows;
        $processed = (int) $job->processed_rows;
        $progress = $total > 0 ? round(($processed / $total) * 100, 2) : 0;

        return [
            'id' => $job->id,
            'status' => (int) $job->status,
            'progress_percent' => $progress,
            'total_rows' => $total,
            'processed_rows' => $processed,
            'valid_rows' => (int) $job->valid_rows,
            'invalid_rows' => (int) $job->invalid_rows,
            'duplicate_in_job_count' => (int) $job->duplicate_in_job_count,
            'duplicate_in_crm_count' => (int) $job->duplicate_in_crm_count,
            'imported_count' => (int) $job->imported_count,
            'updated_count' => (int) $job->updated_count,
            'skipped_count' => (int) $job->skipped_count,
            'failed_count' => (int) $job->failed_count,
            'group_name' => $job->group_name,
            'group_identifier' => $job->group_identifier,
            'contact_list_id' => $job->contact_list_id,
            'started_at' => optional($job->started_at)?->toIso8601String(),
            'completed_at' => optional($job->completed_at)?->toIso8601String(),
            'error_json' => $job->error_json,
            'top_failure_reasons' => $this->topFailureReasons($job),
        ];
    }

    public function history(User $user, int $perPage = 20)
    {
        return GroupExtractionJob::where('user_id', $user->id)
            ->orderByDesc('id')
            ->paginate($perPage);
    }

    public function result(GroupExtractionJob $job): array
    {
        $status = $this->status($job);

        $failedRows = GroupExtractionItem::where('job_id', $job->id)
            ->where('dedupe_action', 9)
            ->orderBy('id')
            ->get([
                'id',
                'row_no',
                'raw_name',
                'raw_phone',
                'reason_code',
                'reason_detail',
            ]);

        return [
            'summary' => $status,
            'failed_rows' => $failedRows,
            'failure_count' => $failedRows->count(),
        ];
    }

    public function failedRowsForCsv(GroupExtractionJob $job): array
    {
        return GroupExtractionItem::where('job_id', $job->id)
            ->where('dedupe_action', 9)
            ->orderBy('id')
            ->get(['row_no', 'raw_name', 'raw_phone', 'reason_code', 'reason_detail'])
            ->map(function ($item) {
                return [
                    'row_no' => (int) $item->row_no,
                    'name' => (string) ($item->raw_name ?? ''),
                    'phone_raw' => (string) ($item->raw_phone ?? ''),
                    'reason_code' => (string) ($item->reason_code ?? ''),
                    'reason_detail' => (string) ($item->reason_detail ?? ''),
                ];
            })->all();
    }

    private function topFailureReasons(GroupExtractionJob $job): array
    {
        return GroupExtractionItem::where('job_id', $job->id)
            ->where('dedupe_action', 9)
            ->selectRaw('reason_code, COUNT(*) as total')
            ->groupBy('reason_code')
            ->orderByDesc('total')
            ->limit(10)
            ->get()
            ->map(function ($row) {
                return [
                    'reason_code' => $row->reason_code ?: 'unknown',
                    'count' => (int) $row->total,
                ];
            })->all();
    }
}

