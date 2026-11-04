<?php
use App\Models\ImageUpload;
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Image Upload</title>

</head>
<body>
<div class="max-w-6xl mx-auto p-6">
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow-sm">
        <table class="w-full text-left border-collapse text-sm">

            <!-- Table Header -->
            <thead class="bg-gray-100 border-b border-gray-200 text-gray-700 uppercase font-semibold tracking-wider">
            <tr>
                <th class="py-3 px-4">Day / Time</th>
                <th class="py-3 px-4">Monday</th>
                <th class="py-3 px-4">Tuesday</th>
                <th class="py-3 px-4">Wednesday</th>
                <th class="py-3 px-4">Thursday</th>
                <th class="py-3 px-4">Friday</th>
                <th class="py-3 px-4">Saturday</th>
            </tr>
            </thead>

            <tbody class="divide-y divide-gray-200 text-gray-700">

            <!-- ================= LUNCH SECTION ================= -->
            <tr class="bg-amber-500/10 font-bold text-amber-900">
                <td colspan="7" class="py-3 px-4 text-base tracking-wide bg-amber-100">
                    ☀️ LUNCH
                </td>
            </tr>
            <tr class="hover:bg-amber-50/50 transition-colors">
                <td class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Appetizer</td>
                <td class="py-3 px-4"></td>
                <td class="py-3 px-4"></td>
                <td class="py-3 px-4"></td>
                <td class="py-3 px-4"></td>
                <td class="py-3 px-4"></td>
                <td class="py-3 px-4"></td>
            </tr>
            <tr class="hover:bg-amber-50/50 transition-colors">
                <td class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Main Dish</td>
                <td class="py-3 px-4">Grilled Chicken</td>
                <td class="py-3 px-4">Pasta Bowl</td>
                <td class="py-3 px-4">Veggie Wrap</td>
                <td class="py-3 px-4">Fish & Chips</td>
                <td class="py-3 px-4">Rice Bowl</td>
                <td class="py-3 px-4">Burger & Fries</td>
            </tr>
            <tr class="hover:bg-amber-50/50 transition-colors">
                <td class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Drink / Side</td>
                <td class="py-3 px-4">Iced Tea</td>
                <td class="py-3 px-4">Sparkling Water</td>
                <td class="py-3 px-4">Fresh Juice</td>
                <td class="py-3 px-4">Lemonade</td>
                <td class="py-3 px-4">Green Tea</td>
                <td class="py-3 px-4">Soda</td>
            </tr>

            <!-- ================= DINNER SECTION ================= -->
            <tr class="bg-indigo-500/10 font-bold text-indigo-900">
                <td colspan="7" class="py-3 px-4 text-base tracking-wide bg-indigo-100">
                    🌙 DINNER
                </td>
            </tr>
            <tr class="hover:bg-indigo-50/50 transition-colors">
                <td class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Starter</td>
                <td class="py-3 px-4">French Onion Soup</td>
                <td class="py-3 px-4">Stuffed Mushrooms</td>
                <td class="py-3 px-4">Shrimp Cocktail</td>
                <td class="py-3 px-4">Calaimari</td>
                <td class="py-3 px-4">Cheese Board</td>
                <td class="py-3 px-4">Tapas Selection</td>
            </tr>
            <tr class="hover:bg-indigo-50/50 transition-colors">
                <td class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Main Dish</td>
                <td class="py-3 px-4">Ribeye Steak</td>
                <td class="py-3 px-4">Baked Salmon</td>
                <td class="py-3 px-4">Mushroom Risotto</td>
                <td class="py-3 px-4">Roast Lamb</td>
                <td class="py-3 px-4">Seafood Paella</td>
                <td class="py-3 px-4">Chef's Special</td>
            </tr>
            <tr class="hover:bg-indigo-50/50 transition-colors">
                <td class="py-3 px-4 font-semibold text-gray-900 bg-gray-50/50">Dessert</td>
                <td class="py-3 px-4">Tiramisu</td>
                <td class="py-3 px-4">Cheesecake</td>
                <td class="py-3 px-4">Chocolate Lava Cake</td>
                <td class="py-3 px-4">Fruit Tart</td>
                <td class="py-3 px-4">Crème Brûlée</td>
                <td class="py-3 px-4">Ice Cream Sundae</td>
            </tr>

            </tbody>
        </table>
    </div>
</div>
<h1>Probiere ein bild hochzuladen</h1>

<div class="container">
    <h2>Select a Date</h2>
    <!-- Datepicker input -->
    <input type="date" id="dateInput">

    <!-- Text that changes -->
    <p>You selected: <span id="dateOutput" class="output">None</span></p>
</div>

<script>
    const dateInput = document.getElementById('dateInput');
    const dateOutput = document.getElementById('dateOutput');

    // Helper function to format dates nicely
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        // Adjust for local timezone offset issues with simple date strings
        const [year, month, day] = dateString.split('-');
        const localDate = new Date(year, month - 1, day);
        return localDate.toLocaleDateString('en-US', options);
    }

    // 1. Get today's date in YYYY-MM-DD format
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${year}-${month}-${day}`;

    // 2. Set the default value of the input and the text display
    dateInput.value = formattedToday;
    dateOutput.textContent = formatDate(formattedToday);

    // 3. Listen for changes when the user picks a new date
    dateInput.addEventListener('change', function() {
        const selectedDate = this.value;

        if (selectedDate) {
            dateOutput.textContent = formatDate(selectedDate);
        } else {
            dateOutput.textContent = 'None';
        }
    });
</script>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

@forelse($imageCollection as $imageUpload)
    @foreach($imageUpload->imageArray as $image)
        <div>
            <img
                src="{{ route('image-upload.show', $image) }}"
                alt="Gespeichertes Bild"
                style="max-width: 500px; height: auto;"
            >

            <form action="{{ route('image-upload.destroy', $image) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit">Bild löschen</button>
            </form>
        </div>
    @endforeach
@empty
    <p>Keine Bilder gefunden.</p>
@endforelse

<div>
    <form action="{{ route('image-upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="imageCollection[]" accept="image/*" required multiple>
        <button type="submit">Upload</button>
    </form>
</div>

</body>
</html>
