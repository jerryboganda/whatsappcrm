<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('contacts')) {
            return;
        }

        Schema::table('contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('contacts', 'mobile_e164')) {
                $table->string('mobile_e164', 32)->nullable()->after('mobile');
            }
            if (!Schema::hasColumn('contacts', 'last_source_type')) {
                $table->string('last_source_type', 64)->nullable()->after('details');
            }
            if (!Schema::hasColumn('contacts', 'last_source_ref')) {
                $table->string('last_source_ref', 128)->nullable()->after('last_source_type');
            }
            if (!Schema::hasColumn('contacts', 'last_seen_at')) {
                $table->dateTime('last_seen_at')->nullable()->after('last_source_ref');
            }
            if (!Schema::hasColumn('contacts', 'name_confidence')) {
                $table->decimal('name_confidence', 5, 2)->nullable()->after('last_seen_at');
            }
        });

        if (Schema::hasColumn('contacts', 'mobile_e164')) {
            Schema::table('contacts', function (Blueprint $table) {
                if (!$this->indexExists('contacts', 'idx_contacts_mobile_e164')) {
                    $table->index(['mobile_e164'], 'idx_contacts_mobile_e164');
                }
                if (!$this->indexExists('contacts', 'idx_contacts_user_mobile_e164')) {
                    $table->index(['user_id', 'mobile_e164'], 'idx_contacts_user_mobile_e164');
                }
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('contacts')) {
            return;
        }

        Schema::table('contacts', function (Blueprint $table) {
            if ($this->indexExists('contacts', 'idx_contacts_mobile_e164')) {
                $table->dropIndex('idx_contacts_mobile_e164');
            }
            if ($this->indexExists('contacts', 'idx_contacts_user_mobile_e164')) {
                $table->dropIndex('idx_contacts_user_mobile_e164');
            }
        });

        Schema::table('contacts', function (Blueprint $table) {
            $columns = [];
            foreach (['mobile_e164', 'last_source_type', 'last_source_ref', 'last_seen_at', 'name_confidence'] as $column) {
                if (Schema::hasColumn('contacts', $column)) {
                    $columns[] = $column;
                }
            }
            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }

    private function indexExists(string $table, string $indexName): bool
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            $indexes = DB::select("PRAGMA index_list('$table')");
            foreach ($indexes as $index) {
                if (($index->name ?? null) === $indexName) {
                    return true;
                }
            }
            return false;
        }

        if (in_array($driver, ['mysql', 'mariadb'], true)) {
            $row = DB::selectOne('SHOW INDEX FROM `' . $table . '` WHERE Key_name = ?', [$indexName]);
            return !is_null($row);
        }

        return false;
    }
};
