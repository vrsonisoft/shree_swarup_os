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
        Schema::table('kot_items', function (Blueprint $table) {
            $table->enum('status', ['pending', 'cooking', 'ready', 'served', 'cancelled'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kot_items', function (Blueprint $table) {
            $table->enum('status', ['pending', 'cooking', 'ready', 'cancelled'])->nullable()->change();
        });
    }
};
