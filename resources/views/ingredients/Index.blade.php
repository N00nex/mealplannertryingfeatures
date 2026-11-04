
<?php
use App\Models\OffIngredient;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Meal Planner</title>
</head>
<body class="min-h-screen bg-gray-100">
<main>
    <div class="max-w-6xl mx-auto p-6">
        <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
            <div class="max-w-6xl mx-auto p-6">
                <h1 class="mb-6 text-2xl font-bold">Ingredients</h1>

                <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
                    <table class="w-full text-left">
                        <thead class="border-b bg-gray-100">
                        <tr>
                            <th class="px-4 py-3">Barcode</th>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Energy</th>
                            <th class="px-4 py-3">Protein</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse ($ingredients as $ingredient)
                            <tr class="border-b">
                                <td class="px-4 py-3">{{ $ingredient->barcode }}</td>
                                <td class="px-4 py-3">
                                    {{ $ingredient->names['en'] ?: $ingredient->names['de'] ?: 'Unnamed product' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $ingredient->nutriments['energy_kcal'] ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3">
                                    {{ $ingredient->nutriments['proteins'] ?? 'N/A' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center">
                                    No ingredients found.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $ingredients->links() }}
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
