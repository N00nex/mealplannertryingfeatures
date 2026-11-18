<?php

use App\Models\Lebensmittel;
use App\Models\Recipe;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;

uses(RefreshDatabase::class);

it('passes lebensmittel names and units to the edit page', function () {
    $user = User::factory()->create();
    $recipe = Recipe::factory()->for($user)->create();
    Lebensmittel::factory()->create(['name' => 'Mehl']);
    Unit::factory()->create();

    $this->actingAs($user)
        ->get(route('mealplanner.edit', $recipe))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('MealDetails/Edit', false)
            ->has('allLebensmittel', 1, fn (Assert $item) => $item->where('name', 'Mehl')->has('id'))
            ->has('units', 1)
        );
});
