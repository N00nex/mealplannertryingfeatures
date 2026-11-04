<?php

namespace App\Http\Controllers;

use App\Models\Lebensmittel;
use Illuminate\View\View;

class LebensmittelController extends Controller
{
    public function index(): View
    {
        $lebensmittel = Lebensmittel::orderBy('name')->paginate(25);

        return view('ingredients.CHIndex', compact('lebensmittel'));
    }
}
