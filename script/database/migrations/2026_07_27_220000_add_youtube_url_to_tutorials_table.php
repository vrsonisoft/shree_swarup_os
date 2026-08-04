<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('tutorials', 'youtube_url')) {
            Schema::table('tutorials', function (Blueprint $table) {
                $table->string('youtube_url')->nullable()->after('video_title');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tutorials', 'youtube_url')) {
            Schema::table('tutorials', function (Blueprint $table) {
                $table->dropColumn('youtube_url');
            });
        }
    }
};
