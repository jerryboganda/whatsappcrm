<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('campaign_message_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('campaign_id')->default(0);
            $table->unsignedBigInteger('campaign_contact_id')->default(0);
            $table->unsignedBigInteger('message_id')->default(0);
            $table->unsignedBigInteger('contact_id')->default(0);
            $table->string('whatsapp_message_id', 191)->nullable();
            $table->string('event_type', 50);
            $table->dateTime('event_ts')->nullable();
            $table->string('source', 30)->default('system');
            $table->json('meta_json')->nullable();
            $table->timestamps();

            $table->index(['campaign_id', 'event_type', 'event_ts'], 'idx_campaign_events_campaign_type_ts');
            $table->index(['campaign_contact_id', 'event_type'], 'idx_campaign_events_contact_type');
            $table->unique(
                ['whatsapp_message_id', 'event_type', 'event_ts', 'source'],
                'uniq_campaign_events_dedupe'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaign_message_events');
    }
};

