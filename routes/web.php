<?php

use App\Http\Controllers\ImageUploadController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

Route::get('/image-upload', [ImageUploadController::class, 'index'])
    ->name('image-upload.index');

Route::post('/image-upload', [ImageUploadController::class, 'store'])
    ->name('image-upload.store');

Route::get('/image-upload/{imageArray}/file', [ImageUploadController::class, 'show'])
    ->name('image-upload.show');

Route::delete('/image-upload/{imageArray}', [ImageUploadController::class, 'destroy'])
    ->name('image-upload.destroy');
