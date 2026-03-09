<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistinctSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('districts')->insert([
            [
                'title' => 'Адмиралтейский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Василеостровской район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Выборгский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Калининский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Кировский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Колпинский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Красногвардейский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Красносельский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Кронштадтский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Курортный район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Московский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Невский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Петроградский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Петродворцовый район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Приморский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Пушкинский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Фрунзенский район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Центральный район',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
