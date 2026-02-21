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
        Schema::table('whatsapp_accounts', function (Blueprint $table) {
            $table->boolean('is_cart_enabled')->default(true);
            $table->boolean('is_catalog_visible')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_accounts', function (Blueprint $table) {
            $table->dropColumn(['is_cart_enabled', 'is_catalog_visible']);
        });
    }
};
