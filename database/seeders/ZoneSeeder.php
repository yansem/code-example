<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Zone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $districts = District::all();
        $count = 1;

        foreach ($districts as $district) {
            for ($i = 1; $i <= 10; $i++) {
                DB::table('zones')->insert([
                    'title' => $count,
                    'district_id' => $district->id,
                    'zone_category_id' => rand(1, 4),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
                $count++;
            }
        }
    }
}
