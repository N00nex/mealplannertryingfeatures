<?php

namespace App\Http\Controllers;

use App\Models\Lebensmittel;
use App\Models\Recipe;
use App\Models\Unit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class MealDetailsController extends Controller
{
    public function create()
    {
        // TODO return Inertia::render('MealDetails/Create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'difficulty' => 'required|string',
            'ingredients' => 'required|array',
            'ingredients.*.lebensmittel_id' => 'exists:lebensmittel_komplett,id',
            'ingredients.*.unit_id' => 'exists:units,id',
            'ingredients.*.quantity' => 'required|numeric',
        ]);

        $recipe = $request->user()->recipes()->create([
            'name' => $validated['name'],
            'difficulty' => $validated['difficulty'],
        ]);

        foreach ($validated['ingredients'] as $ingredient) {
            $recipe->ingredients()->create([
                'lebensmittel_id' => $ingredient['lebensmittel_id'],
                'unit_id' => $ingredient['unit_id'],
                'quantity' => $ingredient['quantity'],
            ]);
        }

        return redirect()->route('meal-details.show', $recipe);
    }

    public function show(Recipe $recipe): Response
    {
        abort_unless($recipe->user_id === auth()->id(), 403);

        return Inertia::render('MealDetails/Show', [
            'recipe' => $recipe->load([
                'cookingSteps',
                'tags',
                'ingredients.lebensmittel',
                'ingredients.unit',
            ]),
        ]);
    }

    public function edit(Recipe $recipe): Response
    {
        abort_unless($recipe->user_id === auth()->id(), 403);

        return Inertia::render('MealDetails/Edit', [
            'recipe' => $recipe->loadRecipeDetails(),
            'units' => Unit::query()->orderBy('name')->get(['id', 'name', 'symbol']),
            'allLebensmittel' => Lebensmittel::query()
                ->select('id', 'name')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function update(Request $request, Recipe $recipe): RedirectResponse
    {
        // 1. Berechtigung prüfen
        abort_unless($recipe->user_id === auth()->id(), 403);

        // 2. Validierung (Feldnamen entsprechen den Spalten der Migrationen und dem Edit.jsx-Formular)
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'difficulty' => 'sometimes|required|string',
            'cooking_time' => 'sometimes|nullable|integer|min:0',
            'servings' => 'sometimes|nullable|integer|min:1',

            // Edit.jsx sendet die Zutaten als "lebensmittel" mit Pivot-Daten
            'lebensmittel' => 'sometimes|array',
            'lebensmittel.*.id' => 'required|exists:lebensmittel_komplett,id',
            'lebensmittel.*.pivot.unit_id' => 'required|exists:units,id',
            'lebensmittel.*.pivot.quantity' => 'required|numeric|min:0',

            // Edit.jsx sendet Tag-IDs
            'tags' => 'sometimes|array',
            'tags.*' => 'integer|exists:tags,id',

            'cooking_steps' => 'sometimes|array',
            'cooking_steps.*.instructions' => 'nullable|string',
            'cooking_steps.*.preparation_time' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($validated, $recipe): void {
            // 3. Stammdaten des Rezepts
            $recipe->update(Arr::only($validated, ['name', 'difficulty', 'cooking_time', 'servings']));

            // 4. Zutaten (lebensmittel_recipes_units) ersetzen
            if (isset($validated['lebensmittel'])) {
                $recipe->ingredients()->delete();

                foreach ($validated['lebensmittel'] as $ingredient) {
                    $recipe->ingredients()->create([
                        'lebensmittel_id' => $ingredient['id'],
                        'unit_id' => $ingredient['pivot']['unit_id'],
                        'quantity' => $ingredient['pivot']['quantity'],
                    ]);
                }
            }

            // 5. Tags synchronisieren
            if (isset($validated['tags'])) {
                $recipe->tags()->sync($validated['tags']);
            }

            // 6. Zubereitungsschritte (cooking_steps: instructions, preparation_time) ersetzen
            if (isset($validated['cooking_steps'])) {
                $recipe->cookingSteps()->delete();

                foreach ($validated['cooking_steps'] as $step) {
                    $recipe->cookingSteps()->create([
                        'instructions' => $step['instructions'] ?? null,
                        'preparation_time' => $step['preparation_time'] ?? null,
                    ]);
                }
            }
        });

        // 7. WICHTIG: Nach einem Update immer einen Redirect (kein Inertia::render!) zurückgeben,
        // damit der Browser die frische Seite mit neuen Daten lädt.
        return redirect()->route('meal-details.show', $recipe);
    }

    public function destroy(Recipe $recipe): RedirectResponse
    {
        abort_unless($recipe->user_id === auth()->id(), 403);

        $recipe->delete();

        return redirect()->route('mealplanner.index'); // Adjust if you have an index route
    }
}
