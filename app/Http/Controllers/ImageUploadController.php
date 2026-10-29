<?php

namespace App\Http\Controllers;

use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5120'], // Max 5MB
        ]);

        $path = $request->file('image')->store('uploads', 's3');

        ImageUpload::create([
            'image' => $path,
        ]);

        return back()->with('success', 'Bild erfolgreich in RustFS gespeichert!');
    }

    public function update(Request $request, ImageUpload $imageUpload)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:5120'],
        ]);

        if (Storage::disk('s3')->exists($imageUpload->image)) {
            Storage::disk('s3')->delete($imageUpload->image);
        }

        $path = $request->file('image')->store('uploads', 's3');

        $imageUpload->update([
            'image' => $path,
        ]);

        return back()->with('success', 'Bild erfolgreich aktualisiert!');
    }
}
