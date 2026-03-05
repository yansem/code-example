<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->count(20)
            ->create()
            ->each(function (User $user) {
                Vehicle::factory()
                    ->count(fake()->numberBetween(1, 2))
                    ->create([
                        'user_id' => $user->id,
                    ]);
            });
    }
}
