<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('vehicle_categories')->insert([
            [
                'category' => 'A',
                'title' => 'Мотоцикл',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'B',
                'title' => 'Авто',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'C',
                'title' => 'Грузовик',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'D',
                'title' => 'Автобус',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
