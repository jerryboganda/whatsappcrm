<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Template;
use App\Lib\CurlRequest;
use Exception;
use Illuminate\Support\Facades\Log;

class UpdateTemplateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'template:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update WhatsApp template statuses from Meta API';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting template status update...');
        Log::info('Cron Job: Starting template status update...');

        // Fetch templates that are PENDING or have an unknown status using generic approved check
        // We fundamentally want to check templates that are NOT approved or REJECTED locally but might be on Meta.
        // Or simply check all templates to sync status periodically.
        // The user specifically mentioned "Pending" templates.

        // Let's get templates not approved yet.
        // Assuming status 1 is Approved (based on metaTemplateStatus helper logic which I checked earlier or inferred).
        // Let's check 'approved' scope in Template model if possible, but reading the controller:
        // $template->status = metaTemplateStatus($data['data'][0]['status']);

        // Use a broader query: NOT approved or recently updated. 
        // For efficiency, let's just check all templates that are NOT approved/rejected final states.
        // STATUS: 0 = Pending (usually), 1 = Approved, 2 = Rejected etc.
        // Let's rely on standard logic: fetch all templates where status != 1

        $templates = Template::where('status', '!=', 1)->whereHas('whatsappAccount')->get();

        $this->info("Found {$templates->count()} pending templates.");

        foreach ($templates as $template) {
            try {
                $account = $template->whatsappAccount;
                if (!$account)
                    continue;

                $businessAccountId = $account->whatsapp_business_account_id;
                $accessToken = $account->access_token;

                $header = [
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $accessToken
                ];

                // Note: v22.0 is used in Controller
                $url = "https://graph.facebook.com/v22.0/{$businessAccountId}/message_templates?name={$template->name}";

                $response = CurlRequest::curlContent($url, $header);
                $data = json_decode($response, true);

                if (!is_array($data) || isset($data['error']) || !isset($data['data'][0]['status'])) {
                    // Log error but continue
                    Log::error("Failed to fetch status for template ID {$template->id}: " . json_encode($data));
                    continue;
                }

                $newStatusString = $data['data'][0]['status'];
                $newStatusInt = metaTemplateStatus($newStatusString);

                if ($template->status !== $newStatusInt) {
                    $template->status = $newStatusInt;
                    $template->save();
                    $this->info("Updated template {$template->name} ({$template->id}) to status: {$newStatusString}");
                    Log::info("Updated template {$template->name} ({$template->id}) to status: {$newStatusString}");
                }

            } catch (Exception $ex) {
                Log::error("Exception updating template ID {$template->id}: " . $ex->getMessage());
            }
        }

        $this->info('Template status update completed.');
        Log::info('Cron Job: Template status update completed.');
    }
}
