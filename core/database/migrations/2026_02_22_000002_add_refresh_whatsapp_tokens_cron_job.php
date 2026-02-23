<?php

use App\Models\CronJob;
use App\Models\CronSchedule;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

return new class extends Migration
{
    public function up(): void
    {
        // Use the "Daily" schedule (interval = 86400, id=3 typically)
        $dailySchedule = CronSchedule::where('name', 'Daily')->first();
        $scheduleId = $dailySchedule ? $dailySchedule->id : 3;

        // Check if the cron job already exists
        if (CronJob::where('alias', 'refresh_whatsapp_tokens')->exists()) {
            return;
        }

        $cronJob = new CronJob();
        $cronJob->name = 'Refresh WhatsApp Tokens';
        $cronJob->alias = 'refresh_whatsapp_tokens';
        $cronJob->action = [
            '\\App\\Http\\Controllers\\CronController',
            'refreshWhatsappTokens'
        ];
        $cronJob->is_running = 1;
        $cronJob->is_default = 1;
        $cronJob->cron_schedule_id = $scheduleId;
        $cronJob->next_run = now();
        $cronJob->save();

        Log::info('Migration: Registered refresh_whatsapp_tokens cron job');
    }

    public function down(): void
    {
        CronJob::where('alias', 'refresh_whatsapp_tokens')->delete();
    }
};
