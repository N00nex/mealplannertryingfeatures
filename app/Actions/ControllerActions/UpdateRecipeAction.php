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
                // 'name' => $validated['name'],
                'difficulty' => $validated['difficulty'],
                'cooking_time' => $validated['cooking_time'],
                'servings' => $validated['servings'],
            ]);

            if (array_key_exists('lebensmittel', $validated)) {
                $recipe->lebensmittel()->sync(
                    collect($validated['lebensmittel'])
                        ->mapWithKeys(fn (array $lebensmittel): array => [
                            $lebensmittel['lebensmittel_id'] => [
                                'unit_id' => $lebensmittel['unit_id'],
                                'quantity' => $lebensmittel['quantity'],
                            ],
                        ])
                        ->all()
                );
            }

            if (! array_key_exists('cooking_steps', $validated)) {
                return $recipe;
            }

            $steps = collect($validated['cooking_steps']);
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

            return $recipe;
        });
    }
}
