<?php

namespace App\Http\Controllers;

use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function index()
    {
        // first() gibt entweder ein Model-Objekt ODER null zurück, wenn die Tabelle leer ist
        $image = ImageUpload::query()->first();

        return view('image_upload.index', compact('image'));
    }

    public function show(ImageUpload $imageUpload)
    {
        return Storage::disk('s3')->response(
            $imageUpload->image,
            null,
            [
                'Content-Disposition' => 'inline',
            ]
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image'],
        ]);

        $imageUpload = ImageUpload::query()->first();
        $oldPath = $imageUpload?->image;

        // Neues Bild speichern
        $newPath = $request->file('image')->store('uploads', 's3');

        if ($imageUpload) {
            // Nur den einen vorhandenen Datenbankeintrag aktualisieren
            $imageUpload->update([
                'image' => $newPath,
            ]);
        } else {
            // Nur beim ersten Upload einen Eintrag erstellen
            ImageUpload::create([
                'image' => $newPath,
            ]);
        }

        // Nur die eine alte Datei löschen
        if ($oldPath && Storage::disk('s3')->exists($oldPath)) {
            Storage::disk('s3')->delete($oldPath);
        }

        return redirect()
            ->route('image-upload.index')
            ->with('success', 'Bild erfolgreich in RustFS gespeichert!');
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

    public function destroy(ImageUpload $imageUpload)
    {
        $path = $imageUpload->image;
        if (Storage::disk('s3')->exists($path)) {
            Storage::disk('s3')->delete($path);
        }
        $imageUpload->delete();

        return back()->with('success', 'Bild erfolgreich gelöscht!');
    }
}
