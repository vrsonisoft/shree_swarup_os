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
        if (!Schema::hasTable('ai_device_tokens')) {
            Schema::create('ai_device_tokens', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
                $table->unsignedBigInteger('branch_id')->nullable();
                $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
                $table->text('token');
                $table->string('platform', 20)->nullable(); // android | ios | web
                $table->string('device_id', 191)->nullable();
                // delivery_partner | waiter_pos
                $table->string('app_type', 30)->nullable();
                $table->timestamps();
 
                $table->index(['restaurant_id', 'branch_id']);
                $table->index('platform');
                $table->index('app_type');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_device_tokens');
    }
};
