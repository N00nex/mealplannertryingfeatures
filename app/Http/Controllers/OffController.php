<?php

namespace App\Http\Controllers;

use App\Models\OffIngredient;
use Illuminate\Contracts\View\View;

class OffController extends Controller
{
    public function index(): View
    {
        $ingredients = OffIngredient::latest()->paginate(10);

        return view('ingredients.Index', [
            'ingredients' => $ingredients,
        ]);
    }
}
