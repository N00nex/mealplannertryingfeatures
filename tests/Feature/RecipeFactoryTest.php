<?php

use App\Models\CookingStep;
use App\Models\Recipe;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates twenty recipes for a user with cooking steps', function () {
    $user = User::factory()->create();

    $recipes = Recipe::factory()
        ->count(20)
        ->for($user)
        ->create();

    expect($recipes)->toHaveCount(20)
        ->and($recipes->every(fn (Recipe $recipe): bool => $recipe->user_id === $user->id))->toBeTrue();

    expect(CookingStep::query()->count())->toBe(60)
        ->and($recipes->every(fn (Recipe $recipe): bool => $recipe->cookingSteps()->count() === 3))->toBeTrue()
        ->and($recipes->every(fn (Recipe $recipe): bool => $recipe->tags()->count() === 2))->toBeTrue();
});
