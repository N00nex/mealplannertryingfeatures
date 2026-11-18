<?php

use App\Models\Lebensmittel;
use App\Models\Recipe;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

// 1. Show Method
it('shows each ingredient with its lebensmittel, unit and quantity', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->for($user)->create();
    $lebensmittel = Lebensmittel::factory()->create(['name' => 'Mehl']);
    $unit = Unit::factory()->create(['unit' => 'Gramm', 'symbol' => 'g']);
    $recipe->lebensmittel()->attach($lebensmittel->id, ['unit_id' => $unit->id, 'quantity' => 250]);

    $this->actingAs($user)
        ->get(route('MealDetails.Show', $recipe))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('MealDetails/Show', false)
            ->has('recipe.ingredients', 1)
            ->where('recipe.ingredients.0.quantity', '250.00')
            ->where('recipe.ingredients.0.lebensmittel.name', 'Mehl')
            ->where('recipe.ingredients.0.unit.symbol', 'g')
        );
});

// 2. Auth Check for Show
it('forbids viewing another users recipe', function () {
    $recipe = Recipe::factory()->create();

    $this->actingAs(User::factory()->create())
        ->get(route('MealDetails.Show', $recipe))
        ->assertForbidden();
});

// 3. Store Method
test('it stores a recipe with ingredients and pivot attributes', function () {
    $user = User::factory()->create();
    $lebensmittel = Lebensmittel::factory()->create(['name' => 'Mehl']);
    $unit = Unit::factory()->create(['unit' => 'Gramm', 'symbol' => 'g']);

    $response = $this->actingAs($user)->postJson(route('MealDetails.Store'), [
        'name' => 'Pancakes',
        'difficulty' => 'easy',
        'ingredients' => [
            [
                'lebensmittel_id' => $lebensmittel->id,
                'unit_id' => $unit->id,
                'quantity' => 250,
            ],
        ],
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('recipes', [
        'name' => 'Pancakes',
        'user_id' => $user->id,
    ]);

    $this->assertDatabaseHas('lebensmittel_recipes_units', [
        'lebensmittel_id' => $lebensmittel->id,
        'unit_id' => $unit->id,
        'quantity' => '250.00',
    ]);
});

// 4. Update Method
test('it updates a recipe and its ingredients pivot attributes', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->for($user)->create([
        'name' => 'Old Title',
        'difficulty' => 'easy',
    ]);

    $oldLebensmittel = Lebensmittel::factory()->create(['name' => 'Old Mehl']);
    $newLebensmittel = Lebensmittel::factory()->create(['name' => 'New Mehl']);
    $unit = Unit::factory()->create(['symbol' => 'g']);

    $recipe->lebensmittel()->attach($oldLebensmittel->id, [
        'unit_id' => $unit->id,
        'quantity' => 100,
    ]);

    $response = $this->actingAs($user)->putJson(route('MealDetails.Update', $recipe), [
        'name' => 'Updated Pancakes',
        'difficulty' => 'medium',
        'ingredients' => [
            [
                'lebensmittel_id' => $newLebensmittel->id,
                'unit_id' => $unit->id,
                'quantity' => 300,
            ],
        ],
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('recipes', [
        'id' => $recipe->id,
        'name' => 'Updated Pancakes',
        'difficulty' => 'medium',
    ]);

    $this->assertDatabaseMissing('lebensmittel_recipes_units', [
        'recipe_id' => $recipe->id,
        'lebensmittel_id' => $oldLebensmittel->id,
    ]);

    $this->assertDatabaseHas('lebensmittel_recipes_units', [
        'recipe_id' => $recipe->id,
        'lebensmittel_id' => $newLebensmittel->id,
        'unit_id' => $unit->id,
        'quantity' => '300.00',
    ]);
});

// 5. Auth Check for Update
test('it forbids updating another users recipe', function () {
    $recipe = Recipe::factory()->create(['name' => 'Original Name']);

    $response = $this->actingAs(User::factory()->create())->patchJson(route('MealDetails.Update', $recipe), [
        'name' => 'Hacked Name',
    ]);

    $response->assertForbidden();

    $this->assertDatabaseHas('recipes', [
        'id' => $recipe->id,
        'name' => 'Original Name',
    ]);
});
