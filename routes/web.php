<?php

use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\LebensmittelController;
use App\Http\Controllers\OffController;
use App\Http\Controllers\USDAIngredientController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', fn () => Inertia::render('Home'))->name('home');

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

Route::get('/ingredients', [OffController::class, 'index'])
    ->name('ingredients.index');

Route::get('/lebensmittel', [LebensmittelController::class, 'index'])
    ->name('lebensmittel.index');

Route::get('/USDAIngredients', [USDAIngredientController::class, 'index'])->name('foods.index');
