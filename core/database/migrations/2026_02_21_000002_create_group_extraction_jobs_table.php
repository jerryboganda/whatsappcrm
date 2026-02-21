<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('group_extraction_jobs')) {
            return;
        }

        Schema::create('group_extraction_jobs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('whatsapp_account_id')->nullable();
            $table->unsignedBigInteger('session_id')->nullable();
            $table->string('source', 40)->default('extension');
            $table->string('group_name', 191)->nullable();
            $table->string('group_identifier', 191)->nullable();
            $table->tinyInteger('status')->default(10);
            $table->unsignedInteger('total_rows')->default(0);
            $table->unsignedInteger('processed_rows')->default(0);
            $table->unsignedInteger('valid_rows')->default(0);
            $table->unsignedInteger('invalid_rows')->default(0);
            $table->unsignedInteger('duplicate_in_job_count')->default(0);
            $table->unsignedInteger('duplicate_in_crm_count')->default(0);
            $table->unsignedInteger('imported_count')->default(0);
            $table->unsignedInteger('updated_count')->default(0);
            $table->unsignedInteger('skipped_count')->default(0);
            $table->unsignedInteger('failed_count')->default(0);
            $table->unsignedBigInteger('contact_list_id')->nullable();
            $table->string('country_hint', 10)->nullable();
            $table->unsignedInteger('chunk_size')->default(500);
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->json('error_json')->nullable();
            $table->json('meta_json')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status', 'created_at'], 'idx_group_extraction_jobs_user_status');
            $table->index(['session_id'], 'idx_group_extraction_jobs_session');
            $table->index(['contact_list_id'], 'idx_group_extraction_jobs_contact_list');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_extraction_jobs');
    }
};

