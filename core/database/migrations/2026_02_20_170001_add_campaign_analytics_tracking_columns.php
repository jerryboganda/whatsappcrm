<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            if (!Schema::hasColumn('campaigns', 'analytics_version')) {
                $table->tinyInteger('analytics_version')->default(1)->after('status');
            }
        });

        Schema::table('campaign_contacts', function (Blueprint $table) {
            if (!Schema::hasColumn('campaign_contacts', 'message_id')) {
                $table->unsignedBigInteger('message_id')->nullable()->after('contact_id');
            }
            if (!Schema::hasColumn('campaign_contacts', 'whatsapp_message_id')) {
                $table->string('whatsapp_message_id', 191)->nullable()->after('message_id');
            }
            if (!Schema::hasColumn('campaign_contacts', 'sent_at')) {
                $table->dateTime('sent_at')->nullable()->after('send_at');
            }
            if (!Schema::hasColumn('campaign_contacts', 'delivered_at')) {
                $table->dateTime('delivered_at')->nullable()->after('sent_at');
            }
            if (!Schema::hasColumn('campaign_contacts', 'read_at')) {
                $table->dateTime('read_at')->nullable()->after('delivered_at');
            }
            if (!Schema::hasColumn('campaign_contacts', 'failed_at')) {
                $table->dateTime('failed_at')->nullable()->after('read_at');
            }
            if (!Schema::hasColumn('campaign_contacts', 'responded_at')) {
                $table->dateTime('responded_at')->nullable()->after('failed_at');
            }
            if (!Schema::hasColumn('campaign_contacts', 'first_response_message_id')) {
                $table->unsignedBigInteger('first_response_message_id')->nullable()->after('responded_at');
            }
            if (!Schema::hasColumn('campaign_contacts', 'delivery_status')) {
                $table->tinyInteger('delivery_status')->default(0)->after('status');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_conversation_id')) {
                $table->string('meta_conversation_id', 191)->nullable()->after('delivery_status');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_conversation_category')) {
                $table->string('meta_conversation_category', 50)->nullable()->after('meta_conversation_id');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_conversation_type')) {
                $table->string('meta_conversation_type', 50)->nullable()->after('meta_conversation_category');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_pricing_model')) {
                $table->string('meta_pricing_model', 50)->nullable()->after('meta_conversation_type');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_pricing_category')) {
                $table->string('meta_pricing_category', 50)->nullable()->after('meta_pricing_model');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_billable')) {
                $table->tinyInteger('meta_billable')->nullable()->after('meta_pricing_category');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_error_code')) {
                $table->string('meta_error_code', 64)->nullable()->after('meta_billable');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_error_title')) {
                $table->string('meta_error_title', 255)->nullable()->after('meta_error_code');
            }
            if (!Schema::hasColumn('campaign_contacts', 'meta_error_details')) {
                $table->text('meta_error_details')->nullable()->after('meta_error_title');
            }
        });

        Schema::table('campaign_contacts', function (Blueprint $table) {
            $table->index(['campaign_id', 'delivery_status'], 'idx_campaign_contacts_campaign_delivery');
            $table->index(['campaign_id', 'responded_at'], 'idx_campaign_contacts_campaign_responded');
            $table->index('whatsapp_message_id', 'idx_campaign_contacts_whatsapp_mid');
            $table->index('message_id', 'idx_campaign_contacts_message_id');
        });
    }

    public function down(): void
    {
        Schema::table('campaign_contacts', function (Blueprint $table) {
            $table->dropIndex('idx_campaign_contacts_campaign_delivery');
            $table->dropIndex('idx_campaign_contacts_campaign_responded');
            $table->dropIndex('idx_campaign_contacts_whatsapp_mid');
            $table->dropIndex('idx_campaign_contacts_message_id');
        });

        Schema::table('campaign_contacts', function (Blueprint $table) {
            $table->dropColumn([
                'message_id',
                'whatsapp_message_id',
                'sent_at',
                'delivered_at',
                'read_at',
                'failed_at',
                'responded_at',
                'first_response_message_id',
                'delivery_status',
                'meta_conversation_id',
                'meta_conversation_category',
                'meta_conversation_type',
                'meta_pricing_model',
                'meta_pricing_category',
                'meta_billable',
                'meta_error_code',
                'meta_error_title',
                'meta_error_details',
            ]);
        });

        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropColumn('analytics_version');
        });
    }
};

