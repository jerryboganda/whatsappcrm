<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('group_extraction_items')) {
            return;
        }

        Schema::create('group_extraction_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_id');
            $table->unsignedInteger('row_no')->default(0);
            $table->string('source_hash', 64);
            $table->string('raw_name', 191)->nullable();
            $table->string('raw_phone', 120)->nullable();
            $table->string('normalized_e164', 32)->nullable();
            $table->string('country_hint', 10)->nullable();
            $table->string('first_name', 80)->nullable();
            $table->string('last_name', 80)->nullable();
            $table->tinyInteger('validation_status')->default(0);
            $table->tinyInteger('dedupe_action')->default(0);
            $table->unsignedBigInteger('contact_id')->nullable();
            $table->string('reason_code', 64)->nullable();
            $table->text('reason_detail')->nullable();
            $table->json('processing_meta_json')->nullable();
            $table->timestamps();

            $table->unique(['job_id', 'source_hash'], 'uq_group_extraction_items_job_hash');
            $table->index(['job_id', 'validation_status'], 'idx_group_extraction_items_job_validation');
            $table->index(['job_id', 'dedupe_action'], 'idx_group_extraction_items_job_action');
            $table->index(['normalized_e164'], 'idx_group_extraction_items_e164');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_extraction_items');
    }
};

