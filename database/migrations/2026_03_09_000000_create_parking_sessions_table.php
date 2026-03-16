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
        Schema::create('parking_sessions', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_auto_renewal')->default(false);
            $table->foreignId('vehicle_id')->constrained();
            $table->foreignId('zone_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('parking_session_status')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_sessions');
    }
};
