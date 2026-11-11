<?php

namespace App\Http\Controllers;

use App\Actions\ControllerActions\UpdateRecipeAction;
use App\Models\Recipe;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MealDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('MealDetails/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate

        $recipe = Recipe::create($request->all());

        return redirect()->route('MealDetails.show', ['id' => $recipe->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        return inertia('MealDetails/Show', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe)
    {
        return inertia('MealDetails/Edit', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe, UpdateRecipeAction $updateRecipeAction): RedirectResponse
    {
        abort_unless($recipe->user_id === auth()->id(), 404);

        $validated = $request->validate([
            'cooking_time' => ['required', 'integer', 'min:0'],
            'servings' => ['required', 'integer', 'min:1'],
            'cooking_steps' => ['array'],
            'cooking_steps.*.id' => [
                'nullable',
                'integer',
                Rule::exists('cooking_steps', 'id')
                    ->where('recipe_id', $recipe->id),
            ],
            'cooking_steps.*.instructions' => ['nullable', 'string'],
            'cooking_steps.*.preparation_time' => ['nullable', 'integer', 'min:0'],
        ]);

        $updateRecipeAction->execute($recipe, $validated);

        return redirect()->route('mealplanner.show', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
