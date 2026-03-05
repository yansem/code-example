<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

pest()->use(RefreshDatabase::class);

it('registers user successfully', function () {
    $response = $this->postJson('/api/auth/register', [
        'name' => 'Ivan',
        'surname' => 'Ivanov',
        'patronymic' => 'Ivanovich',
        'email' => 'ivan@mail.ru',
        'phone' => '+79999999999',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertCreated()
        ->assertJsonStructure([
            'token',
            'token_type',
        ]);

    $this->assertDatabaseHas('users', [
        'email' => 'ivan@mail.ru',
    ]);
});

it('fails if email already exists', function () {
    User::factory()->create([
        'email' => 'ivan@mail.ru',
    ]);

    $response = $this->postJson('/api/auth/register', [
        'name' => 'Ivan',
        'surname' => 'Ivanov',
        'email' => 'ivan@mail.ru',
        'phone' => '+79999999999',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertUnprocessable()
        ->assertJsonValidationErrors(['email']);
});
