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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('retailer_id')->index();
            $table->string('name')->nullable();
            $table->decimal('price', 16, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->timestamps();
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('contact_id');
            $table->unsignedBigInteger('conversation_id')->nullable();
            $table->decimal('amount', 16, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->string('status', 20)->default('pending')->comment('pending, paid, shipped, completed');
            $table->longText('products_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('products');
    }
};
