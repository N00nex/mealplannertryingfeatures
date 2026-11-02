<?php

namespace App\Http\Controllers;

use App\Models\ImageArray;
use App\Models\ImageUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function index()
    {

        $imageCollection = ImageUpload::with('imageArray')->get();

        // übergibt imageCollection als Collection weiter
        return view('image_upload.index', compact('imageCollection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'imageCollection' => ['required', 'array', 'min:1'],
            'imageCollection.*' => ['required', 'image', 'max:5120'],
        ]);
        // erstelle einen datensatz in der tabelle (ohne daten)
        $imageUpload = ImageUpload::create();

        // imageCollection[] name im Form besagt dass mehrere files hochgeladen werden können.
        // die schleife geht durch die images und speichert sie im s3
        foreach ($request->file('imageCollection') as $image) {
            $imageUpload->ImageArray()->create([
                'image_path' => $image->store('uploads', 's3'),
            ]);
        }

        return back()->with('success', 'Bilder erfolgreich hochgeladen!');
    }

    public function show(ImageArray $imageArray)
    {
        return Storage::disk('s3')->response($imageArray->image_path);
    }

    public function destroy(ImageArray $imageArray)
    {
        Storage::disk('s3')->delete($imageArray->image_path);

        $imageArray->delete();

        return back()->with('success', 'Bild gelöscht!');
    }
}
