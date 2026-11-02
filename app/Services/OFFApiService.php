<?php
// LARAVEL OPENFOODFACTS PACKAGE DOESNT REALLY WORK (USES OLD DEPRECATED API)
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OFFApiService
{
    protected string $userAgent;

    public function __construct()
    {
        $this->userAgent = config(
            'services.openfoodfacts.user_agent',
            'Mealpanner/1.0 (stefano.milone06@gmail.com)'
        );
    }

    public function searchProducts(string $query): array
    {
        try {
            $response = Http::withUserAgent($this->userAgent)
                ->get('https://world.openfoodfacts.org/cgi/search.pl', [
                    'search_terms' => $query,
                    'search_simple' => 1,
                    'action' => 'process',
                    'json' => 1,
                    'page_size' => 15, // Fetch a few more items so we have options after filtering
                ]);

            if ($response->successful()) {
                $products = $response->json('products', []);

                return collect($products)
                    ->map(function ($product) {
                        return [
                            'code' => $product['code'] ?? null,
                            'name_en' => $product['product_name_en'] ?? $product['product_name'] ?? 'Unknown',
                            'name_de' => $product['product_name_de'] ?? $product['product_name'] ?? 'Unbekannt',
                            'nutriments' => [
                                'calories_100g' => $product['nutriments']['energy-kcal_100g'] ?? 0,
                                'proteins_100g' => $product['nutriments']['proteins_100g'] ?? 0,
                                'fat_100g' => $product['nutriments']['fat_100g'] ?? 0,
                                'carbs_100g' => $product['nutriments']['carbohydrates_100g'] ?? 0,
                            ],
                        ];
                    })
                // 1. Remove duplicates based on the German name (case-insensitive)
                    ->unique(function ($item) {
                        return strtolower(trim($item['name']));
                    })
                // 2. Reset the array keys so it returns a clean JSON list instead of a mixed object
                    ->values()
                // 3. Limit the final output to e.g., 5 unique options for the dropdown
                    ->take(5)
                    ->toArray();
            }

            return [];
        } catch (\Exception $e) {
            Log::error('OFF Search Error: '.$e->getMessage());

            return [];
        }
    }
}
