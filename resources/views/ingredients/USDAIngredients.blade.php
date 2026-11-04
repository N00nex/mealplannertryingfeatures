<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>USDA Ingredients</title>
</head>
<body class="min-h-screen bg-gray-100">
<main class="mx-auto max-w-7xl p-6">
    <h1 class="mb-6 text-2xl font-bold text-gray-900">USDA Ingredients</h1>

    <div class="overflow-x-auto rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-gray-700">
            <thead class="border-b border-gray-200 bg-gray-100 text-xs uppercase tracking-wide">
            <tr>
                <th class="px-4 py-3">FDC ID</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Energy</th>
                <th class="px-4 py-3">Protein</th>
                <th class="px-4 py-3">Fat</th>
                <th class="px-4 py-3">Carbohydrates</th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
            @forelse ($ingredients as $ingredient)
                @php
                    $name = $ingredient->names['en'] ?? 'Unnamed food';
                    $nutriments = $ingredient->nutriments ?? [];
                @endphp
                <tr>
                    <td class="whitespace-nowrap px-4 py-3">{{ $ingredient->fdc_id }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $name }}</td>
                    <td class="px-4 py-3">
                        {{ $nutriments['energy_kcal'] ?? 'N/A' }} kcal
                    </td>
                    <td class="px-4 py-3">
                        {{ $nutriments['protein_g'] ?? 'N/A' }} g
                    </td>
                    <td class="px-4 py-3">
                        {{ $nutriments['fat_g'] ?? 'N/A' }} g
                    </td>
                    <td class="px-4 py-3">
                        {{ $nutriments['carbohydrates_g'] ?? 'N/A' }} g
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center">
                        No USDA ingredients found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $ingredients->links() }}
    </div>
</main>
</body>
</html>