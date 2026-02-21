<?php

namespace App\Services\GroupExtraction;

use App\Models\GroupExtractionJob;
use App\Models\GroupExtractionSession;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class GroupExtractionSessionService
{
    public function createForUser(User $user, array $payload, string $ip, ?string $userAgent = null): GroupExtractionSession
    {
        $todayJobs = GroupExtractionJob::where('user_id', $user->id)
            ->whereDate('created_at', now()->toDateString())
            ->count();

        $maxJobsPerDay = (int) config('group_extraction.max_jobs_per_day', 20);
        if ($todayJobs >= $maxJobsPerDay) {
            throw ValidationException::withMessages([
                'limit' => "Daily extraction job limit reached ($maxJobsPerDay).",
            ]);
        }

        $allowedOrigins = config('group_extraction.allowed_origins', []);
        $allowedOrigin = $payload['allowed_origin'] ?? ($allowedOrigins[0] ?? url('/'));
        $requestedOrigin = trim((string) $allowedOrigin);

        if (!in_array($requestedOrigin, $allowedOrigins, true)) {
            $requestedOrigin = $allowedOrigins[0] ?? url('/');
        }

        return GroupExtractionSession::create([
            'user_id' => $user->id,
            'session_token' => Str::random(72),
            'signing_secret' => Str::random(96),
            'allowed_origin' => $requestedOrigin,
            'expires_at' => now()->addMinutes((int) config('group_extraction.session_ttl_minutes', 10)),
            'max_requests' => (int) ($payload['max_requests'] ?? 500),
            'used_requests' => 0,
            'attested_at' => now(),
            'attestation_text_version' => (string) config('group_extraction.attestation_text_version', '2026-02-21'),
            'attested_ip' => $ip,
            'attested_user_agent' => $this->trimText($userAgent, 255),
        ]);
    }

    private function trimText(?string $value, int $limit): ?string
    {
        if (is_null($value)) {
            return null;
        }

        $value = trim($value);
        if ($value === '') {
            return null;
        }

        return mb_substr($value, 0, $limit);
    }
}
