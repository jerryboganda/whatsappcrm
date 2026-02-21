<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('cron_jobs') || !Schema::hasTable('cron_schedules')) {
            return;
        }

        $exists = DB::table('cron_jobs')->where('alias', 'group_extraction_jobs')->exists();
        if ($exists) {
            return;
        }

        $scheduleId = null;
        if (Schema::hasColumn('cron_schedules', 'name')) {
            $scheduleId = DB::table('cron_schedules')
                ->where('name', 'Every 2 Minutes')
                ->value('id');
        }

        if (!$scheduleId) {
            if (Schema::hasColumn('cron_schedules', 'interval')) {
                $scheduleId = DB::table('cron_schedules')
                    ->where('interval', 120)
                    ->value('id');
            }
        }

        if (!$scheduleId) {
            $scheduleQuery = DB::table('cron_schedules');
            if (Schema::hasColumn('cron_schedules', 'status')) {
                $scheduleQuery->where('status', 1);
            }
            if (Schema::hasColumn('cron_schedules', 'interval')) {
                $scheduleQuery->orderBy('interval');
            }
            $scheduleId = $scheduleQuery->value('id');
        }

        if (!$scheduleId) {
            return;
        }

        DB::table('cron_jobs')->insert([
            'name' => 'Process Group Extraction Jobs',
            'alias' => 'group_extraction_jobs',
            'action' => json_encode(['\\App\\Http\\Controllers\\CronController', 'processGroupExtractionJobs']),
            'url' => null,
            'cron_schedule_id' => $scheduleId,
            'next_run' => now(),
            'last_run' => null,
            'is_running' => 1,
            'is_default' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (!Schema::hasTable('cron_jobs')) {
            return;
        }

        DB::table('cron_jobs')->where('alias', 'group_extraction_jobs')->delete();
    }
};
