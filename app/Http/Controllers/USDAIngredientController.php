<?php

namespace App\Http\Controllers;

use App\Models\USDAIngredients;
use Illuminate\Contracts\View\View;

class USDAIngredientController extends Controller
{
    public function index(): View
    {
        $ingredients = USDAIngredients::latest('id')->paginate(10);

        return view('ingredients.USDAIngredients', [
            'ingredients' => $ingredients,
        ]);
    }
}
