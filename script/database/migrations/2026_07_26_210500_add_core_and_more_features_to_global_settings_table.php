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
                if (!Schema::hasColumn('global_settings', 'core_features')) {
                    $table->longText('core_features')->nullable();
                }
                if (!Schema::hasColumn('global_settings', 'more_features')) {
                    $table->longText('more_features')->nullable();
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
                if (Schema::hasColumn('global_settings', 'core_features')) {
                    $table->dropColumn('core_features');
                }
                if (Schema::hasColumn('global_settings', 'more_features')) {
                    $table->dropColumn('more_features');
                }
            });
        }
    }
};
