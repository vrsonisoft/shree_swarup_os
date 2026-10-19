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
        if (!Schema::hasTable('restapi_fcm_settings')) {
            Schema::create('restapi_fcm_settings', function (Blueprint $table) {
                $table->id();
                $table->boolean('delivery_partner_enabled')->default(false);
                $table->string('delivery_partner_credentials_path')->nullable();
                $table->boolean('waiter_pos_enabled')->default(false);
                $table->string('waiter_pos_credentials_path')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restapi_fcm_settings');
    }
};
