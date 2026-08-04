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
        // 1. Create subscribes table if not exists
        if (!Schema::hasTable('subscribes')) {
            Schema::create('subscribes', function (Blueprint $table) {
                $table->id();
                $table->string('email')->unique();
                $table->timestamps();
            });
        }

        // 2. Add missing columns to contacts table
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                if (!Schema::hasColumn('contacts', 'name')) {
                    $table->string('name')->nullable()->after('id');
                }
                if (!Schema::hasColumn('contacts', 'phone')) {
                    $table->string('phone')->nullable()->after('email');
                }
                if (!Schema::hasColumn('contacts', 'category')) {
                    $table->string('category')->nullable()->after('phone');
                }
                if (!Schema::hasColumn('contacts', 'message')) {
                    $table->text('message')->nullable()->after('category');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('contacts')) {
            Schema::table('contacts', function (Blueprint $table) {
                $columns = ['name', 'phone', 'category', 'message'];
                foreach ($columns as $column) {
                    if (Schema::hasColumn('contacts', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }

        Schema::dropIfExists('subscribes');
    }
};
