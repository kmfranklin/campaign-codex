<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/example', function () {
    return view('example');
})->name('example');

// Character Compendium routes
Route::middleware(['auth'])->group(function () {
    Route::get('/characters', [\App\Http\Controllers\CharacterCompendiumController::class, 'index'])
        ->name('characters.index');
});

require __DIR__.'/auth.php';
