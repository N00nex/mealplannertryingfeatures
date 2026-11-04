<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lebensmittel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 p-6">
    <h1 class="text-2xl font-semibold mb-4">Lebensmittel</h1>

    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-3 py-2">ID</th>
                    <th class="px-3 py-2">Name</th>
                    <th class="px-3 py-2">Synonyme</th>
                    <th class="px-3 py-2">Kategorie</th>
                    <th class="px-3 py-2 text-right">kcal</th>
                    <th class="px-3 py-2 text-right">kJ</th>
                    <th class="px-3 py-2 text-right">Fett (g)</th>
                    <th class="px-3 py-2 text-right">davon ges. (g)</th>
                    <th class="px-3 py-2 text-right">Kohlenhydr. (g)</th>
                    <th class="px-3 py-2 text-right">davon Zucker (g)</th>
                    <th class="px-3 py-2 text-right">Fasern (g)</th>
                    <th class="px-3 py-2 text-right">Protein (g)</th>
                    <th class="px-3 py-2 text-right">Salz (g)</th>
                </tr>
            </thead>
            <tbody class="divide-y">
@forelse ($lebensmittel as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-2">{{ $item->id }}</td>
                        <td class="px-3 py-2 font-medium">{{ $item->name }}</td>
                        <td class="px-3 py-2">{{ $item->synonyme ?? '–' }}</td>
                        <td class="px-3 py-2">{{ $item->kategorie ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->energie_kilokalorien_kcal ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->energie_kilojoule_kj ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->fett_total_g ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->fettsaeuren_gesaettigt_g ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->kohlenhydrate_verfuegbar_g ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->zucker_g ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->nahrungsfasern_g ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->protein_g ?? '–' }}</td>
                        <td class="px-3 py-2 text-right">{{ $item->salz_nacl_g ?? '–' }}</td>
                    </tr>
@empty
                    <tr><td colspan="13" class="px-3 py-6 text-center">Keine Einträge vorhanden.</td></tr>
@endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $lebensmittel->links() }}
    </div>
</body>
</html>
