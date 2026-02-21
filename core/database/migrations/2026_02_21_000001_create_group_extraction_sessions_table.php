<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('group_extraction_sessions')) {
            return;
        }

        Schema::create('group_extraction_sessions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('session_token', 120)->unique();
            $table->string('signing_secret', 120);
            $table->string('allowed_origin', 191)->nullable();
            $table->dateTime('expires_at');
            $table->unsignedInteger('max_requests')->default(500);
            $table->unsignedInteger('used_requests')->default(0);
            $table->dateTime('attested_at')->nullable();
            $table->string('attestation_text_version', 40)->nullable();
            $table->string('attested_ip', 64)->nullable();
            $table->string('attested_user_agent', 255)->nullable();
            $table->dateTime('revoked_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'expires_at'], 'idx_group_extraction_sessions_user_exp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_extraction_sessions');
    }
};

