<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

pest()->use(RefreshDatabase::class);
//todo: questions
it('logs out the user and deletes the current access token', function () {
    $user = User::factory()->create();

    Sanctum::actingAs($user);

    $tokenId = $user->currentAccessToken()->id;

    $response = $this->postJson('/api/auth/logout');

    $response->assertNoContent();

    expect($user->tokens()->where('id', $tokenId)->exists())->toBeFalse();
});
