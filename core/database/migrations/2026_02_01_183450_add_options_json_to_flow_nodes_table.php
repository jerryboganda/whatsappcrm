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
        Schema::table('flow_nodes', function (Blueprint $table) {
            $table->text('options_json')->nullable()->after('buttons_json');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('flow_nodes', function (Blueprint $table) {
            $table->dropColumn('options_json');
        });
    }
};
