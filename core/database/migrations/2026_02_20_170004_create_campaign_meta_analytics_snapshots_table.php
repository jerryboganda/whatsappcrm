<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaign_meta_analytics_snapshots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->default(0);
            $table->string('source_type', 40);
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            $table->string('granularity', 30)->nullable();
            $table->string('request_fingerprint', 191);
            $table->json('payload_json')->nullable();
            $table->string('attribution_confidence', 20)->default('low');
            $table->tinyInteger('is_estimated')->default(1);
            $table->dateTime('fetched_at')->nullable();
            $table->timestamps();

            $table->unique(
                ['campaign_id', 'source_type', 'request_fingerprint'],
                'uniq_campaign_meta_snapshots'
            );
            $table->index(['campaign_id', 'source_type'], 'idx_campaign_meta_campaign_source');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_meta_analytics_snapshots');
    }
};

