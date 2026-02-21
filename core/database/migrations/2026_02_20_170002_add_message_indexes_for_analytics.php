<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!$this->indexExists('messages', 'idx_messages_whatsapp_message_id_prefix')) {
            DB::statement('CREATE INDEX idx_messages_whatsapp_message_id_prefix ON messages (whatsapp_message_id(191))');
        }

        Schema::table('messages', function (Blueprint $table) {
            $table->index(['campaign_id', 'type', 'created_at'], 'idx_messages_campaign_type_created');
        });
    }

    public function down(): void
    {
        if ($this->indexExists('messages', 'idx_messages_whatsapp_message_id_prefix')) {
            DB::statement('DROP INDEX idx_messages_whatsapp_message_id_prefix ON messages');
        }

        Schema::table('messages', function (Blueprint $table) {
            $table->dropIndex('idx_messages_campaign_type_created');
        });
    }

    private function indexExists(string $tableName, string $indexName): bool
    {
        $databaseName = DB::getDatabaseName();
        $result = DB::selectOne(
            'SELECT COUNT(1) AS count_value FROM information_schema.statistics WHERE table_schema = ? AND table_name = ? AND index_name = ?',
            [$databaseName, $tableName, $indexName]
        );

        return ((int) ($result->count_value ?? 0)) > 0;
    }
};

