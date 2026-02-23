<?php

namespace App\Console\Commands;

use App\Models\WhatsappAccount;
use App\Services\WhatsappTokenRefreshService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class RefreshWhatsappTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'whatsapp:refresh-tokens {--force : Force refresh all tokens regardless of expiry}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh expiring WhatsApp long-lived tokens before they expire';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('WhatsApp Token Refresh: Starting...');
        Log::info('WhatsApp Token Refresh: cron started');

        $force = $this->option('force');

        // Get all accounts that have an access token
        $query = WhatsappAccount::whereNotNull('access_token')->where('access_token', '!=', '');

        if (!$force) {
            // Refresh tokens that:
            // 1. Have token_expires_at set and it's within the next 7 days
            // 2. Have NO token_expires_at set (legacy accounts - we don't know when they expire)
            // 3. Haven't been refreshed in the last 30 days
            $query->where(function ($q) {
                // Tokens expiring within 7 days
                $q->where('token_expires_at', '<=', Carbon::now()->addDays(7))
                    // Legacy tokens with no expiry tracked - refresh if not refreshed in 30 days
                    ->orWhere(function ($sub) {
                        $sub->whereNull('token_expires_at')
                            ->where(function ($inner) {
                                $inner->whereNull('token_refreshed_at')
                                    ->orWhere('token_refreshed_at', '<=', Carbon::now()->subDays(30));
                            });
                    })
                    // Tokens not refreshed in 45 days (safety net)
                    ->orWhere(function ($sub) {
                        $sub->whereNotNull('token_expires_at')
                            ->where(function ($inner) {
                                $inner->whereNull('token_refreshed_at')
                                    ->orWhere('token_refreshed_at', '<=', Carbon::now()->subDays(45));
                            });
                    });
            });
        }

        $accounts = $query->get();

        if ($accounts->isEmpty()) {
            $this->info('WhatsApp Token Refresh: No tokens need refreshing.');
            Log::info('WhatsApp Token Refresh: no tokens need refreshing');
            return self::SUCCESS;
        }

        $this->info("WhatsApp Token Refresh: Found {$accounts->count()} account(s) to refresh.");

        $successCount = 0;
        $failCount = 0;

        foreach ($accounts as $account) {
            $this->line("  Refreshing account #{$account->id} (WABA: {$account->whatsapp_business_account_id})...");

            $result = WhatsappTokenRefreshService::refreshTokenForAccount($account);

            if ($result) {
                $successCount++;
                $this->info("    -> Success. New expiry: {$account->token_expires_at}");
            } else {
                $failCount++;
                $this->error("    -> FAILED to refresh token for account #{$account->id}");

                // If the token is already expired, mark the verification status
                if ($account->token_expires_at && Carbon::parse($account->token_expires_at)->isPast()) {
                    $account->code_verification_status = 'EXPIRED';
                    $account->save();
                    $this->warn("    -> Marked account #{$account->id} as EXPIRED");
                }
            }
        }

        $summary = "WhatsApp Token Refresh: Done. Success: {$successCount}, Failed: {$failCount}";
        $this->info($summary);
        Log::info($summary);

        return $failCount > 0 ? self::FAILURE : self::SUCCESS;
    }
}
