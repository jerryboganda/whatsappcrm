<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('contact_source_events')) {
            return;
        }

        Schema::create('contact_source_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('user_id');
            $table->string('source_type', 64);
            $table->string('source_ref_type', 64)->nullable();
            $table->unsignedBigInteger('source_ref_id')->nullable();
            $table->string('group_name', 191)->nullable();
            $table->string('group_identifier', 191)->nullable();
            $table->dateTime('captured_at')->nullable();
            $table->json('meta_json')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'source_type'], 'idx_contact_source_events_user_source');
            $table->index(['contact_id', 'captured_at'], 'idx_contact_source_events_contact_time');
            $table->index(['source_ref_type', 'source_ref_id'], 'idx_contact_source_events_ref');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_source_events');
    }
};

