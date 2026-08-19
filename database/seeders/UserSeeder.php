<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()
            ->create([
                'name' => 'test1',
                'surname' => 'test2',
                'patronymic' => 'test3',
                'email' => 'test@mail.ru',
                'phone' => '+79991234567',
                'email_verified_at' => now(),
                'phone_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]);

        Vehicle::factory()
            ->count(fake()->numberBetween(1, 2))
            ->create([
                'user_id' => $user->id,
            ]);

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
