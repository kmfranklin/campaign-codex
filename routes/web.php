<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NpcController;
use App\Http\Controllers\CampaignController;


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

    Route::redirect('/characters', '/compendium/npcs');

    Route::resource('compendium/npcs', NpcController::class)->names('compendium.npcs');
});

Route::resource('campaigns', CampaignController::class);

// Member management routes
Route::post('campaigns/{campaign}/members', [CampaignController::class, 'addMember'])
    ->name('campaigns.members.add');

Route::delete('campaigns/{campaign}/members', [CampaignController::class, 'removeMember'])
    ->name('campaigns.members.remove');


require __DIR__.'/auth.php';
