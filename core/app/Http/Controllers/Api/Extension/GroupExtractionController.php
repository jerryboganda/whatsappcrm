<?php

namespace App\Http\Controllers\Api\Extension;

use App\Http\Controllers\Controller;
use App\Models\GroupExtractionJob;
use App\Models\GroupExtractionSession;
use App\Models\User;
use App\Services\GroupExtraction\GroupExtractionIngestService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GroupExtractionController extends Controller
{
    public function __construct(private readonly GroupExtractionIngestService $ingestService)
    {
    }

    public function createJob(Request $request)
    {
        [$session, $user] = $this->resolveAuthContext($request);

        $request->validate([
            'group_name' => 'required|string|max:191',
            'group_identifier' => 'nullable|string|max:191',
            'country_hint' => 'nullable|string|max:10',
            'target_contact_list_id' => 'nullable|integer|min:1',
            'chunk_size' => 'nullable|integer|min:50|max:1000',
            'members' => 'nullable|array',
            'members.*.name' => 'nullable|string|max:191',
            'members.*.phone_raw' => 'nullable|string|max:120',
            'attested' => 'required|accepted',
            'finalize' => 'nullable|boolean',
        ]);

        $job = $this->ingestService->createJob($user, $session, $request->all());

        $accepted = 0;
        $duplicateInJob = 0;
        if ($request->filled('members') && is_array($request->members) && count($request->members) > 0) {
            $ingestResult = $this->ingestService->appendMembers($job, $request->members);
            $accepted = (int) ($ingestResult['accepted_count'] ?? 0);
            $duplicateInJob = (int) ($ingestResult['duplicate_in_job_count'] ?? 0);
            $shouldFinalize = $request->boolean('finalize', true);
            if ($shouldFinalize) {
                $job = $this->ingestService->finalizeJob($job->fresh());
            }
        }

        return apiResponse('group_extraction_job_created', 'success', ['Group extraction job created'], [
            'job_id' => $job->id,
            'status' => (int) $job->status,
            'accepted_count' => $accepted,
            'duplicate_in_job_count' => $duplicateInJob,
            'total_rows' => (int) $job->total_rows,
        ]);
    }

    public function appendChunk(Request $request, $jobId)
    {
        [$session, $user] = $this->resolveAuthContext($request);

        $request->validate([
            'members' => 'required|array|min:1|max:2000',
            'members.*.name' => 'nullable|string|max:191',
            'members.*.phone_raw' => 'nullable|string|max:120',
            'members.*.country_hint' => 'nullable|string|max:10',
        ]);

        $job = $this->resolveOwnedJob((int) $jobId, $session, $user);
        $ingestResult = $this->ingestService->appendMembers($job, $request->members);

        return apiResponse('group_extraction_chunk_accepted', 'success', ['Chunk accepted'], [
            'job_id' => $job->id,
            'accepted_count' => (int) ($ingestResult['accepted_count'] ?? 0),
            'duplicate_in_job_count' => (int) ($ingestResult['duplicate_in_job_count'] ?? 0),
            'total_rows' => (int) ($ingestResult['total_rows'] ?? $job->total_rows),
        ]);
    }

    public function finalize(Request $request, $jobId)
    {
        [$session, $user] = $this->resolveAuthContext($request);
        $job = $this->resolveOwnedJob((int) $jobId, $session, $user);
        $job = $this->ingestService->finalizeJob($job);

        return apiResponse('group_extraction_job_finalized', 'success', ['Job finalized for processing'], [
            'job_id' => $job->id,
            'status' => (int) $job->status,
            'total_rows' => (int) $job->total_rows,
        ]);
    }

    private function resolveOwnedJob(int $jobId, GroupExtractionSession $session, User $user): GroupExtractionJob
    {
        $job = GroupExtractionJob::where('id', $jobId)
            ->where('user_id', $user->id)
            ->where('session_id', $session->id)
            ->first();

        if (!$job) {
            throw ValidationException::withMessages([
                'job' => 'Group extraction job not found for this session',
            ]);
        }

        return $job;
    }

    private function resolveAuthContext(Request $request): array
    {
        $session = $request->attributes->get('group_extraction_session');
        $user = $request->attributes->get('group_extraction_user');

        if (!$session instanceof GroupExtractionSession || !$user instanceof User) {
            throw ValidationException::withMessages([
                'session' => 'Invalid extraction context',
            ]);
        }

        return [$session, $user];
    }
}

