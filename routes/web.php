<?php

use App\Http\Controllers\MealDetailsController;
use App\Http\Controllers\MealPlanController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/Mealplanner')->name('home');

Route::middleware(['auth'])->group(function () {

    Route::get('/Mealplanner', [MealPlanController::class, 'index'])
        ->name('mealplanner.index');

    Route::get('/mealplanner/{recipe}', [MealPlanController::class, 'show'])
        ->name('mealplanner.show');

    Route::delete('/mealplanner/{recipe}', [MealPlanController::class, 'destroy'])
        ->name('mealplanner.destroy');

    Route::get('/mealplanner/{recipe}/edit', [MealPlanController::class, 'edit'])
        ->name('mealplanner.edit');

    Route::get('/meal-details/{recipe}', [MealDetailsController::class, 'show'])
        ->name('meal-details.show');

    Route::get('/meal-details/{recipe}/edit', [MealDetailsController::class, 'edit'])
        ->name('meal-details.edit');

    Route::post('/meal', [MealPlanController::class, 'edit'])
        ->name('mealplan.edit');

    Route::patch('/meal-details/{recipe}', [MealDetailsController::class, 'update'])
        ->name('meal-details.update');

    Route::post('/meal-details', [MealDetailsController::class, 'store'])
        ->name('meal-details.store');
});

require __DIR__.'/settings.php';
