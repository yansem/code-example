<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParkingSessionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        DB::table('parking_session_statuses')->insert([
            [
                'code' => 'ACTIVE',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'EXPIRED',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'CANCELED',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
