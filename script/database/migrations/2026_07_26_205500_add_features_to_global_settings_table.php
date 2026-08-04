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
                if (!Schema::hasColumn('global_settings', 'features')) {
                    $table->longText('features')->nullable();
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
                if (Schema::hasColumn('global_settings', 'features')) {
                    $table->dropColumn('features');
                }
            });
        }
    }
};
