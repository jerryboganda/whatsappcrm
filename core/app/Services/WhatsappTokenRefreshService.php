<?php

namespace App\Services;

use App\Models\WhatsappAccount;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsappTokenRefreshService
{
    /**
     * Refresh the access token for a WhatsApp account by exchanging
     * the existing long-lived token for a new one via Meta's OAuth endpoint.
     *
     * Long-lived tokens can be exchanged for new long-lived tokens (60-day expiry).
     * If the token is a System User Access Token, this will return it unchanged.
     *
     * Uses per-account credentials (meta_app_id + meta_app_secret) first,
     * falling back to global general settings.
     *
     * @param  WhatsappAccount  $account
     * @return bool  true if the token was refreshed successfully
     */
    public static function refreshTokenForAccount(WhatsappAccount $account): bool
    {
        if (empty($account->access_token)) {
            Log::warning('WhatsappTokenRefreshService: no access_token on account', ['account_id' => $account->id]);
            return false;
        }

        // Use per-account credentials first, fall back to general settings
        $appId = $account->meta_app_id ?: gs('meta_app_id');
        $appSecret = $account->meta_app_secret ?: gs('meta_app_secret');

        if (empty($appId) || empty($appSecret)) {
            Log::error('WhatsappTokenRefreshService: app credentials not configured', [
                'account_id' => $account->id,
                'has_account_app_id' => !empty($account->meta_app_id),
                'has_account_app_secret' => !empty($account->meta_app_secret),
                'has_global_app_id' => !empty(gs('meta_app_id')),
                'has_global_app_secret' => !empty(gs('meta_app_secret')),
            ]);
            return false;
        }

        $url = "https://graph.facebook.com/v22.0/oauth/access_token";

        try {
            $response = Http::timeout(30)->get($url, [
                'grant_type' => 'fb_exchange_token',
                'client_id' => $appId,
                'client_secret' => $appSecret,
                'fb_exchange_token' => $account->access_token,
            ]);

            $result = $response->json();

            if ($response->failed() || isset($result['error']) || empty($result['access_token'])) {
                Log::error('WhatsappTokenRefreshService: refresh failed', [
                    'account_id' => $account->id,
                    'http_status' => $response->status(),
                    'error' => $result['error'] ?? null,
                ]);
                return false;
            }

            $expiresAt = null;
            if (!empty($result['expires_in'])) {
                $expiresAt = Carbon::now()->addSeconds((int) $result['expires_in']);
            } else {
                // No expires_in means it could be a permanent token
                // Set a conservative 58-day expiry for safety
                $expiresAt = Carbon::now()->addDays(58);
            }

            $account->access_token = $result['access_token'];
            $account->token_expires_at = $expiresAt;
            $account->token_refreshed_at = Carbon::now();
            $account->save();

            // Re-subscribe the WABA so webhooks keep working with the new token
            $subscribeUrl = "https://graph.facebook.com/v23.0/{$account->whatsapp_business_account_id}/subscribed_apps";
            Http::post($subscribeUrl, ['access_token' => $result['access_token']]);

            Log::info('WhatsappTokenRefreshService: token refreshed successfully', [
                'account_id' => $account->id,
                'expires_at' => $expiresAt?->toDateTimeString(),
            ]);

            return true;
        } catch (\Throwable $e) {
            Log::error('WhatsappTokenRefreshService: exception', [
                'account_id' => $account->id,
                'message' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
