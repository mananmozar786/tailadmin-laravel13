<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;

uses(RefreshDatabase::class);

test('it calculates BMI correctly and saves to user', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/v1/health/bmi', [
            'height' => 180, // 1.8m
            'weight' => 75,  // 75kg
        ])
        ->assertStatus(200)
        ->assertJson([
            'bmi' => 23.15, // 75 / (1.8 * 1.8) = 23.148...
            'status' => 'Normal',
        ]);

    $user->refresh();
    expect($user->height)->toEqual(180.0)
        ->and($user->weight)->toEqual(75.0)
        ->and($user->bmi)->toEqual(23.15)
        ->and($user->bmi_status)->toBe('Normal');
});

test('it determines different BMI statuses correctly', function ($height, $weight, $expectedStatus) {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/v1/health/bmi', [
            'height' => $height,
            'weight' => $weight,
        ])
        ->assertStatus(200)
        ->assertJson(['status' => $expectedStatus]);
})->with([
    [180, 50, 'Underweight'],
    [180, 75, 'Normal'],
    [180, 90, 'Overweight'],
    [180, 110, 'Obese'],
]);

test('it updates profile and recalculates BMI when both height and weight are provided', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->patchJson('/api/v1/health/profile', [
            'height' => 170,
            'weight' => 70,
            'age' => 25,
        ])
        ->assertStatus(200)
        ->assertJsonFragment([
            'height' => 170,
            'weight' => 70,
            'age' => 25,
            'bmi' => 24.22, // 70 / (1.7 * 1.7) = 24.221...
            'bmi_status' => 'Normal',
        ]);
});

test('it validates height and weight ranges', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->postJson('/api/v1/health/bmi', [
            'height' => 40, // min 50
            'weight' => 10, // min 20
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['height', 'weight']);

    actingAs($user)
        ->postJson('/api/v1/health/bmi', [
            'height' => 310, // max 300
            'weight' => 310, // max 300
        ])
        ->assertStatus(422)
        ->assertJsonValidationErrors(['height', 'weight']);
});
