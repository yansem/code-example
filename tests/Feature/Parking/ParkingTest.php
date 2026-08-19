<?php

use App\Enums\ParkingSessionStatusEnum;
use App\Models\ParkingPeriod;
use App\Models\ParkingSession;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Zone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

uses(RefreshDatabase::class);

describe('ParkingSession API', function () {

    it('требует авторизацию Sanctum', function () {
        $response = $this->postJson('/api/parkings', [
            'zone_id' => 1,
            'vehicle_id' => 1,
            'duration' => 60,
            'is_auto_renewal' => false,
        ]);

        $response->assertStatus(401);
    });

    it('валидирует обязательные поля и минимальную длительность', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/parkings', [
            'duration' => 30,
            'is_auto_renewal' => 'не булево',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'zone_id',
                'vehicle_id',
                'duration',
                'is_auto_renewal',
            ]);
    });

    it('валидирует существование zone_id и vehicle_id', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/parkings', [
            'zone_id' => 999999,
            'vehicle_id' => 999999,
            'duration' => 60,
            'is_auto_renewal' => false,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['zone_id', 'vehicle_id']);
    });

    it('создание парковочной сессии и парковочного периода', function () {
        $user = User::factory()->create();
        Sanctum::actingAs($user);
//        Balance::factory()->create([
//            'user_id' => $user->id,
//            'balance' => 1000,
//        ]);

        $this->seed(\Database\Seeders\VehicleCategorySeeder::class);

        $vehicle = Vehicle::factory()->create([
            'user_id' => $user->id,
            'vehicle_category_id' => 2
        ]);

        $zone = Zone::factory()->create();

        $payload = [
            'zone_id' => $zone->id,
            'vehicle_id' => $vehicle->id,
            'duration' => 60,
            'is_auto_renewal' => false,
        ];

        $this->postJson('/api/parkings', $payload)->assertCreated();

        $parkingSession = ParkingSession::query()->first();
        $parkingPeriod = ParkingPeriod::query()->first();

        $this->assertDatabaseHas('parking_sessions', [
            'id' => $parkingSession->id,
            'user_id' => $user->id,
            'vehicle_id' => $vehicle->id,
            'zone_id' => $zone->id,
            'parking_session_status_id' => ParkingSessionStatusEnum::ACTIVE->value,
            'current_parking_period_id' => $parkingPeriod->id,
        ]);

        $this->assertDatabaseHas('parking_periods', [
            'id' => $parkingPeriod->id,
            'parking_session_id' => $parkingSession->id,
            'user_id' => $user->id,
            'source' => 'manual',
        ]);
    });
});
