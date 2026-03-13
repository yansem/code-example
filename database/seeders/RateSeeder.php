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
                1 => [5000, 83],
                2 => [10000, 167],
                3 => [20000, 333],
                4 => [20000, 333],
            ],
            2 => [
                1 => [10000, 167],
                2 => [20000, 333],
                3 => [40000, 667],
                4 => [40000, 667],
            ],
            3 => [
                1 => [14000, 233],
                2 => [28000, 467],
                3 => [56000, 933],
                4 => [56000, 933],
            ],
            4 => [
                1 => [18000, 300],
                2 => [36000, 600],
                3 => [72000, 1200],
                4 => [72000, 1200],
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
