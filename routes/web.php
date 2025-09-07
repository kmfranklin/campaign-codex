<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NpcController;
use App\Http\Controllers\CharacterCompendiumController;

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

    // Character Compendium
    Route::get('/characters', [CharacterCompendiumController::class, 'index'])->name('characters.index');

    // NPC CRUD
    Route::resource('npcs', NpcController::class);
});

require __DIR__.'/auth.php';
