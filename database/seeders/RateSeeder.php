<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $rates = [
            1 => [
                1 => [50.00, 0.83],
                2 => [100.00, 1.67],
                3 => [200.00, 3.33],
                4 => [200.00, 3.33],
            ],
            2 => [
                1 => [100.00, 1.67],
                2 => [200.00, 3.33],
                3 => [400.00, 6.67],
                4 => [400.00, 6.67],
            ],
            3 => [
                1 => [140.00, 2.33],
                2 => [280.00, 4.67],
                3 => [560.00, 9.33],
                4 => [560.00, 9.33],
            ],
            4 => [
                1 => [180.00, 3.00],
                2 => [360,.00, 6.00],
                3 => [720.00, 12.00],
                4 => [720.00, 12.00],
            ],
        ];

        foreach ($rates as $zoneCategoryId => $vehicleRates) {
            foreach ($vehicleRates as $vehicleCategoryId => $timeRate) {
                DB::table('rates')->insert(
                    [
                        'zone_category_id' => $zoneCategoryId,
                        'vehicle_category_id' => $vehicleCategoryId,
                        'hourly_rate' => $timeRate[0],
                        'minutely_rate' => $timeRate[1],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            }

        }
    }
}
