<?php

namespace App\Http\Controllers;

use App\Services\OpenFoodFactsService;
use Illuminate\Http\JsonResponse;

class IngredientsController extends Controller
{
    protected OpenFoodFactsService $offService;

    // Laravel übergibt den Service automatisch
    public function __construct(OpenFoodFactsService $offService)
    {
        $this->offService = $offService;
    }

    public function show(string $name): JsonResponse
    {
        $product = $this->offService->getProduct($name);

        if (! $product) {
            return response()->json([
                'success' => false,
                'message' => 'Produkt nicht gefunden.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'name' => $product['product_name'] ?? 'Unbekannt',
                'calories' => $product['nutriments']['energy-kcal_100g'] ?? 0,
            ],
        ]);
    }
}
