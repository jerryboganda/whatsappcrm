<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\GroupExtractionJob;
use App\Services\GroupExtraction\GroupExtractionProcessorService;
use App\Services\GroupExtraction\GroupExtractionReportService;
use App\Services\GroupExtraction\GroupExtractionSessionService;
use Illuminate\Http\Request;

class GroupExtractionController extends Controller
{
    public function __construct(
        private readonly GroupExtractionSessionService $sessionService,
        private readonly GroupExtractionReportService $reportService,
        private readonly GroupExtractionProcessorService $processorService,
    ) {
    }

    public function createSession(Request $request)
    {
        $request->validate([
            'attested' => 'required|accepted',
            'allowed_origin' => 'nullable|string|max:191',
            'max_requests' => 'nullable|integer|min:1|max:5000',
        ]);

        $user = getParentUser();
        $session = $this->sessionService->createForUser($user, $request->all(), $request->ip(), $request->userAgent());

        return apiResponse('group_extraction_session_created', 'success', ['Group extraction session created'], [
            'session_token' => $session->session_token,
            'signing_secret' => $session->signing_secret,
            'expires_at' => optional($session->expires_at)->toIso8601String(),
            'allowed_origin' => $session->allowed_origin,
            'api_base' => url('/api/extension/group-extraction'),
            'max_members_per_job' => (int) config('group_extraction.max_members_per_job', 10000),
            'default_chunk_size' => (int) config('group_extraction.default_chunk_size', 500),
            'attestation_text_version' => (string) config('group_extraction.attestation_text_version', '2026-02-21'),
        ]);
    }

    public function status($id)
    {
        $job = $this->resolveOwnedJob((int) $id);
        $status = $this->reportService->status($job);

        return apiResponse('group_extraction_job_status', 'success', ['Group extraction status fetched'], [
            'job' => $status,
        ]);
    }

    public function result(Request $request, $id)
    {
        $job = $this->resolveOwnedJob((int) $id);

        if ($request->query('download') === 'failed_csv') {
            $rows = $this->reportService->failedRowsForCsv($job);
            $filename = 'group_extraction_failed_' . $job->id . '.csv';

            return response()->streamDownload(function () use ($rows) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Row', 'Name', 'Phone Raw', 'Reason Code', 'Reason Detail']);
                foreach ($rows as $row) {
                    fputcsv($file, [
                        $row['row_no'],
                        $row['name'],
                        $row['phone_raw'],
                        $row['reason_code'],
                        $row['reason_detail'],
                    ]);
                }
                fclose($file);
            }, $filename, ['Content-Type' => 'text/csv']);
        }

        $result = $this->reportService->result($job);
        $failedCsvUrl = route('user.contact.group.extraction.result', [
            'id' => $job->id,
            'download' => 'failed_csv',
        ]);

        return apiResponse('group_extraction_job_result', 'success', ['Group extraction result fetched'], [
            'result' => $result,
            'failed_csv_url' => $failedCsvUrl,
        ]);
    }

    public function retryFailed(Request $request, $id)
    {
        $request->validate([
            'country_hint' => 'nullable|string|max:10',
        ]);

        $job = $this->resolveOwnedJob((int) $id);
        $retryCount = $this->processorService->retryFailed($job, $request->country_hint);

        if ($retryCount <= 0) {
            return apiResponse('group_extraction_retry_failed', 'error', ['No failed rows available for retry']);
        }

        return apiResponse('group_extraction_retry_queued', 'success', ["Queued $retryCount failed rows for retry"], [
            'retry_count' => $retryCount,
            'job_id' => $job->id,
        ]);
    }

    public function history(Request $request)
    {
        $user = getParentUser();
        $perPage = max(5, min((int) ($request->paginate ?? 20), 100));
        $history = $this->reportService->history($user, $perPage);

        return apiResponse('group_extraction_history', 'success', ['Group extraction history fetched'], [
            'history' => $history,
        ]);
    }

    private function resolveOwnedJob(int $id): GroupExtractionJob
    {
        $user = getParentUser();
        return GroupExtractionJob::where('id', $id)->where('user_id', $user->id)->firstOrFail();
    }
}

