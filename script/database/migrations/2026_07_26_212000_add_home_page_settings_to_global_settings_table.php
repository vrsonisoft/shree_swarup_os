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
                if (!Schema::hasColumn('global_settings', 'hero_settings')) {
                    $table->longText('hero_settings')->nullable();
                }
                if (!Schema::hasColumn('global_settings', 'video_settings')) {
                    $table->longText('video_settings')->nullable();
                }
                if (!Schema::hasColumn('global_settings', 'why_choose_us')) {
                    $table->longText('why_choose_us')->nullable();
                }
                if (!Schema::hasColumn('global_settings', 'payment_gateways')) {
                    $table->longText('payment_gateways')->nullable();
                }
                if (!Schema::hasColumn('global_settings', 'templates')) {
                    $table->longText('templates')->nullable();
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
                if (Schema::hasColumn('global_settings', 'hero_settings')) {
                    $table->dropColumn('hero_settings');
                }
                if (Schema::hasColumn('global_settings', 'video_settings')) {
                    $table->dropColumn('video_settings');
                }
                if (Schema::hasColumn('global_settings', 'why_choose_us')) {
                    $table->dropColumn('why_choose_us');
                }
                if (Schema::hasColumn('global_settings', 'payment_gateways')) {
                    $table->dropColumn('payment_gateways');
                }
                if (Schema::hasColumn('global_settings', 'templates')) {
                    $table->dropColumn('templates');
                }
            });
        }
    }
};
