<?php
use App\Models\ImageUpload;
?>

<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Image Upload</title>
</head>
<body>

<h1>Probiere ein bild hochzuladen</h1>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

@if($image)
    <img
        src="{{ route('image-upload.show', $image) }}"
        alt="Gespeichertes Bild"
        style="max-width: 500px; height: auto;"
    >
@else
    <p>Noch kein Bild hochgeladen.</p>
@endif

<div>
    <form action="{{ route('image-upload.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
</div>

{{-- Erst prüfen, ob $image existiert. Wenn ja, wird erst der Code darin ausgeführt --}}
@if(isset($image) && $image)
    <form action="{{ route('image-upload.destroy', $image->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Bild löschen</button>
    </form>
@endif

</body>
</html>
