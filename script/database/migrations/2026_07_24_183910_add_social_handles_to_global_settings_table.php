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
        Schema::table('global_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('global_settings', 'whatsapp_number')) {
                $table->string('whatsapp_number')->nullable();
            }
            if (!Schema::hasColumn('global_settings', 'linkedin_link')) {
                $table->string('linkedin_link')->nullable();
            }
            if (!Schema::hasColumn('global_settings', 'github_link')) {
                $table->string('github_link')->nullable();
            }
            if (!Schema::hasColumn('global_settings', 'phone_number_1')) {
                $table->string('phone_number_1')->nullable();
            }
            if (!Schema::hasColumn('global_settings', 'phone_number_2')) {
                $table->string('phone_number_2')->nullable();
            }
            if (!Schema::hasColumn('global_settings', 'primary_email')) {
                $table->string('primary_email')->nullable();
            }
            if (!Schema::hasColumn('global_settings', 'secondary_email')) {
                $table->string('secondary_email')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('global_settings', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_number',
                'linkedin_link',
                'github_link',
                'phone_number_1',
                'phone_number_2',
                'primary_email',
                'secondary_email'
            ]);
        });
    }
};
