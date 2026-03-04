<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

pest()->use(RefreshDatabase::class);

it('logs in successfully', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password123!'),
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'Password123!',
    ]);

    $response->assertOk()
        ->assertJsonStructure(['token', 'token_type']);

    expect($user->tokens()->count())->toBe(1);
});

it('fails with wrong password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('Password123!'),
    ]);

    $response = $this->postJson('/api/auth/login', [
        'email' => $user->email,
        'password' => 'WrongPassword',
    ]);

    $response->assertUnauthorized();
});

it('fails if user not found', function () {
    $response = $this->postJson('/api/auth/login', [
        'email' => 'notfound@example.com',
        'password' => 'Password123!',
    ]);

    $response->assertUnauthorized();
});
