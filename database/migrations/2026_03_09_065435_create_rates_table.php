<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->decimal('hourly_rate', 10, 2);
            $table->decimal('minutely_rate', 10, 2);
            $table->foreignId('zone_category_id')->constrained();
            $table->foreignId('vehicle_category_id')->constrained();
            $table->unique([
                'zone_category_id',
                'vehicle_category_id'
            ]);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
