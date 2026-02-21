<?php

namespace App\Http\Middleware;

use App\Models\GroupExtractionApiNonce;
use App\Models\GroupExtractionSession;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyGroupExtractionSignature
{
    public function handle(Request $request, Closure $next): Response
    {
        $authHeader = (string) $request->header('Authorization', '');
        $bearerToken = '';
        if (preg_match('/^Bearer\s+(.+)$/i', $authHeader, $matches)) {
            $bearerToken = trim((string) ($matches[1] ?? ''));
        }

        $sessionToken = (string) ($request->header('X-GE-Session', '') ?: $bearerToken);
        $timestamp = (string) $request->header('X-GE-Timestamp', '');
        $nonce = (string) $request->header('X-GE-Nonce', '');
        $signature = (string) $request->header('X-GE-Signature', '');

        if (!$sessionToken || !$timestamp || !$nonce || !$signature) {
            return apiResponse('group_extraction_signature', 'error', ['Missing signature headers'], [], 401);
        }

        $session = GroupExtractionSession::with('user')
            ->where('session_token', $sessionToken)
            ->first();

        if (!$session || !$session->user) {
            return apiResponse('group_extraction_session', 'error', ['Invalid extraction session'], [], 401);
        }

        if ($session->revoked_at || now()->greaterThan($session->expires_at)) {
            return apiResponse('group_extraction_session_expired', 'error', ['Session expired'], [], 401);
        }

        if (!$session->attested_at) {
            return apiResponse('group_extraction_attestation', 'error', ['Compliance attestation is required'], [], 403);
        }

        $maxRequests = (int) ($session->max_requests ?? 0);
        if ($maxRequests > 0 && (int) $session->used_requests >= $maxRequests) {
            return apiResponse('group_extraction_limit', 'error', ['Session request limit reached'], [], 429);
        }

        $origin = (string) $request->header('Origin', '');
        if ($origin && str_starts_with($origin, 'chrome-extension://')) {
            // Extension requests originate from chrome-extension://<id> and should pass.
        } elseif (
            $session->allowed_origin &&
            $origin &&
            rtrim($origin, '/') !== rtrim((string) $session->allowed_origin, '/')
        ) {
            return apiResponse('group_extraction_origin', 'error', ['Origin not allowed'], [], 403);
        }

        if (!ctype_digit($timestamp)) {
            return apiResponse('group_extraction_timestamp', 'error', ['Invalid timestamp'], [], 401);
        }

        $skew = (int) config('group_extraction.hmac_skew_seconds', 300);
        $nowTs = now()->timestamp;
        $requestTs = (int) $timestamp;
        if (abs($nowTs - $requestTs) > $skew) {
            return apiResponse('group_extraction_timestamp', 'error', ['Stale request timestamp'], [], 401);
        }

        $payloadHash = hash('sha256', $request->getContent() ?? '');
        $canonical = strtoupper($request->method()) . "\n"
            . $request->path() . "\n"
            . $timestamp . "\n"
            . $nonce . "\n"
            . $payloadHash;

        $expected = hash_hmac('sha256', $canonical, $session->signing_secret);
        if (!hash_equals($expected, $signature)) {
            return apiResponse('group_extraction_signature', 'error', ['Signature mismatch'], [], 401);
        }

        try {
            GroupExtractionApiNonce::create([
                'session_id' => $session->id,
                'nonce' => substr($nonce, 0, 80),
                'request_ts' => $requestTs,
            ]);
        } catch (QueryException $queryException) {
            return apiResponse('group_extraction_nonce', 'error', ['Duplicate nonce detected'], [], 409);
        }

        $session->increment('used_requests');
        $session->refresh();

        $request->attributes->set('group_extraction_session', $session);
        $request->attributes->set('group_extraction_user', $session->user);

        return $next($request);
    }
}
