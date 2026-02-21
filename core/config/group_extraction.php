<?php

return [
    'session_ttl_minutes' => env('GROUP_EXTRACTION_SESSION_TTL_MINUTES', 10),
    'hmac_skew_seconds' => env('GROUP_EXTRACTION_HMAC_SKEW_SECONDS', 300),
    'default_chunk_size' => env('GROUP_EXTRACTION_DEFAULT_CHUNK_SIZE', 500),
    'max_members_per_job' => env('GROUP_EXTRACTION_MAX_MEMBERS_PER_JOB', 10000),
    'max_jobs_per_day' => env('GROUP_EXTRACTION_MAX_JOBS_PER_DAY', 20),
    'max_rows_per_day' => env('GROUP_EXTRACTION_MAX_ROWS_PER_DAY', 50000),
    'max_jobs_per_cron' => env('GROUP_EXTRACTION_MAX_JOBS_PER_CRON', 5),
    'process_rows_per_job' => env('GROUP_EXTRACTION_PROCESS_ROWS_PER_JOB', 500),
    'attestation_text_version' => env('GROUP_EXTRACTION_ATTESTATION_VERSION', '2026-02-21'),
    'allowed_origins' => array_filter(array_map(
        'trim',
        explode(',', env('GROUP_EXTRACTION_ALLOWED_ORIGINS', 'https://web.whatsapp.com,https://whatsapp.firstaidmadeeasy.com.pk'))
    )),
];

