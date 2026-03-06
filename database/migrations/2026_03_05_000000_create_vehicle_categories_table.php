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
        Schema::create('vehicle_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->string('title');
            $table->timestamps();
        });

        DB::table('vehicle_categories')->insert([
            [
                'category' => 'A',
                'title' => 'Мотоцикл',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'B',
                'title' => 'Авто',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'C',
                'title' => 'Грузовик',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'category' => 'D',
                'title' => 'Автобус',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_categories');
    }
};
