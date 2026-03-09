<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZoneCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('zone_categories')->insert([
            [
                'title' => '1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '2',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '3',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => '4',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
