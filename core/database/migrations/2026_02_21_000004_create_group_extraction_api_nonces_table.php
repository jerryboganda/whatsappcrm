<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('group_extraction_api_nonces')) {
            return;
        }

        Schema::create('group_extraction_api_nonces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('session_id');
            $table->string('nonce', 80);
            $table->unsignedBigInteger('request_ts');
            $table->timestamps();

            $table->unique(['session_id', 'nonce'], 'uq_group_extraction_api_nonces_session_nonce');
            $table->index(['session_id', 'request_ts'], 'idx_group_extraction_api_nonces_session_ts');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_extraction_api_nonces');
    }
};

