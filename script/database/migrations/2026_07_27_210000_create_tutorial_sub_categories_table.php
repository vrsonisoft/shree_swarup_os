<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('tutorial_sub_categories')) {
            Schema::create('tutorial_sub_categories', function (Blueprint $table) {
                $table->id();
                $table->foreignId('tutorial_category_id')->constrained('tutorial_categories')->onDelete('cascade');
                $table->string('name');
                $table->string('slug');
                $table->text('description')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasColumn('tutorials', 'tutorial_sub_category_id')) {
            Schema::table('tutorials', function (Blueprint $table) {
                $table->foreignId('tutorial_sub_category_id')->nullable()->after('tutorial_category_id')->constrained('tutorial_sub_categories')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('tutorials', 'tutorial_sub_category_id')) {
            Schema::table('tutorials', function (Blueprint $table) {
                $table->dropForeign(['tutorial_sub_category_id']);
                $table->dropColumn('tutorial_sub_category_id');
            });
        }
        Schema::dropIfExists('tutorial_sub_categories');
    }
};
