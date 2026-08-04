<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('global_settings')) {
            Schema::table('global_settings', function (Blueprint $table) {
                if (!Schema::hasColumn('global_settings', 'faqs')) {
                    $table->longText('faqs')->nullable();
                }
                if (!Schema::hasColumn('global_settings', 'pricing_faqs')) {
                    $table->longText('pricing_faqs')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('global_settings')) {
            Schema::table('global_settings', function (Blueprint $table) {
                if (Schema::hasColumn('global_settings', 'faqs')) {
                    $table->dropColumn('faqs');
                }
                if (Schema::hasColumn('global_settings', 'pricing_faqs')) {
                    $table->dropColumn('pricing_faqs');
                }
            });
        }
    }
};
