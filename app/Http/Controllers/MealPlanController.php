<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // todo Das ist das modal mit den filter
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // todo wenn user einen neuen plan im verlauf des Kalenders erstellt
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // todo wenn ein rezept ausgetauscht wird
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
