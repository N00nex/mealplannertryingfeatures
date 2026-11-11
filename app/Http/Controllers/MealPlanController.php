<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MealPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = auth()->user();

        return Inertia::render('MealPlanner/Index', [
            'user' => $user->only(['id', 'name']),
            'recipes' => $user->recipes()
                ->with(['cookingSteps', 'tags'])
                ->inRandomOrder()
                ->get(),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe): Response
    {
        abort_unless($recipe->user_id === auth()->id(), 403);

        return Inertia::render('MealDetails/Show', [
            'recipe' => $recipe->load(['cookingSteps', 'tags']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe): Response
    {
        abort_unless($recipe->user_id === auth()->id(), 403);

        return Inertia::render('MealDetails/Edit', [
            'recipe' => $recipe->load(['cookingSteps', 'tags']),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe): RedirectResponse
    {
        abort_unless($recipe->user_id === auth()->id(), 403);

        $recipe->delete();

        return redirect()->route('mealplanner.index');
    }
}
