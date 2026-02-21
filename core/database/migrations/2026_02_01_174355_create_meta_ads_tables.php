<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ad_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->string('name')->nullable();
            $table->string('account_id')->unique(); // e.g. act_123456
            $table->string('currency')->default('USD');
            $table->string('timezone')->default('UTC');
            $table->text('access_token')->nullable(); // User token
            $table->timestamps();
        });

        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id')->index();
            $table->unsignedBigInteger('ad_account_id')->index();
            $table->string('name')->nullable();

            // Meta IDs
            $table->string('campaign_id')->nullable();
            $table->string('ad_set_id')->nullable();
            $table->string('ad_id')->unique()->nullable();

            $table->string('status')->default('DRAFT'); // DRAFT, ACTIVE, PAUSED
            $table->decimal('budget', 10, 2)->default(0);

            $table->json('analytics_json')->nullable(); // Cache clicks, impressions
            $table->timestamps();

            $table->foreign('ad_account_id')->references('id')->on('ad_accounts')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ads');
        Schema::dropIfExists('ad_accounts');
    }
};
