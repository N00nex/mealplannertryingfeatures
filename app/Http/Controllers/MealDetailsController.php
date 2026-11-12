<?php

namespace App\Http\Controllers;

use App\Actions\ControllerActions\UpdateRecipeAction;
use App\Http\Requests\MealDetailsUpdateRequest;
use App\Models\Lebensmittel;
use App\Models\Recipe; // Passe den Modellnamen an falls nötig
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;

class MealDetailsController extends Controller
{
    public function create()
    {
        return inertia('MealDetails/Create');
    }

    public function store(Request $request)
    {
        $recipe = Recipe::create($request->all());

        return redirect()->route('MealDetails.Show', ['id' => $recipe->id]);
    }

    public function show(Recipe $recipe)
    {
        return inertia('MealDetails/Show', [
            'recipe' => $recipe,
        ]);
    }

    public function edit(Recipe $recipe)
    {
        // Lade das Rezept mitsamt seiner verknüpften Lebensmittel/Pivot-Daten
        $recipe->load('lebensmittel', 'cooking_steps');

        return inertia('MealDetails/Edit', [
            'recipe' => $recipe,
            'allLebensmittel' => Lebensmittel::all(),
            'allUnits' => Unit::all(),
        ]);
    }

    public function update(MealDetailsUpdateRequest $request, Recipe $recipe, UpdateRecipeAction $updateRecipeAction): RedirectResponse
    {
        $validated = $request->validated();
        $updateRecipeAction->execute($recipe, $validated);

        return redirect()->route('mealplanner.show', [
            'recipe' => $recipe,
        ]);
    }

    public function destroy(string $id)
    {
        //
    }
}
