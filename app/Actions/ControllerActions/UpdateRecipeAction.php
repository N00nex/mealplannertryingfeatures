<?php

namespace App\Actions\ControllerActions;

use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class UpdateRecipeAction
{
    public function execute(Recipe $recipe, array $validated): Recipe
    {
        return DB::transaction(function () use ($recipe, $validated) {
            // 1. Rezept-Stammdaten aktualisieren
            $recipe->update([
                'cooking_time' => $validated['cooking_time'],
                'servings' => $validated['servings'],
            ]);

            if (! isset($validated['ingredients']) || ! isset($validated['units'])) {
                return $recipe;
            }

            // Wenn keine Schritte übergeben wurden, abbrechen
            if (! isset($validated['cooking_steps'])) {
                return $recipe;
            }

            $steps = collect($validated['cooking_steps']);
            $ingredients = collect($validated['ingredients']);
            $units = collect($validated['units']);

            // 2. IDs herausfiltern, die im Request mitgeschickt wurden
            $submittedIds = $steps->pluck('id')->filter();

            // 3. Nicht mehr vorhandene Schritte löschen
            $recipe->cookingSteps()->whereNotIn('id', $submittedIds)->delete();

            // 4. Schritte aktualisieren oder neu anlegen
            foreach ($steps as $stepData) {
                $recipe->cookingSteps()->updateOrCreate(
                    ['id' => $stepData['id'] ?? null],
                    [
                        'instructions' => $stepData['instructions'] ?? null,
                        'preparation_time' => $stepData['preparation_time'] ?? null,
                    ]
                );
            }

            // 5. Zutaten aktualisieren oder neu anlegen
            foreach ($ingredients as $ingredientData) {
                $recipe->ingredients()->updateOrCreate(
                    ['id' => $ingredientData['id'] ?? null],
                    [
                        'name' => $ingredientData['name'] ?? null,
                        'amount' => $ingredientData['amount'] ?? null,
                    ]
                );
            }

            // 6. Einheiten aktualisieren oder neu anlegen
            foreach ($units as $unitData) {
                $recipe->units()->updateOrCreate(
                    ['id' => $unitData['id'] ?? null],
                    [
                        'name' => $unitData['name'] ?? null,
                        'abbreviation' => $unitData['abbreviation'] ?? null,
                    ]
                );
            }

            return $recipe;
        });
    }
}
