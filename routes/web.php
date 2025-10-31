<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProfileController,
    NpcController,
    CampaignController,
    QuestController,
    ItemController,
    CustomItemController
};

// Public routes
Route::view('/', 'welcome');
Route::view('/dashboard', 'dashboard')->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated user routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Redirect legacy character route
    Route::redirect('/characters', '/compendium/npcs');

    // NPC Compendium
    Route::resource('compendium/npcs', NpcController::class)->names('compendium.npcs');

    // Custom Items (full CRUD)
    Route::resource('items/custom', CustomItemController::class)
        ->names('items.custom')
        ->parameters(['custom' => 'item']);
});

// Campaigns and Quests
Route::resource('campaigns', CampaignController::class);
Route::resource('campaigns.quests', QuestController::class);

// Item Index (read-only)
Route::resource('items', ItemController::class)->only(['index', 'show']);

// SRD and Custom Item Index Views (filtered)
Route::get('/srd-items', [ItemController::class, 'srdIndex'])->name('srdItems.index');
Route::get('/custom-items', [ItemController::class, 'customIndex'])->name('customItems.index');

// NPC–Quest relationships
Route::post('campaigns/{campaign}/quests/{quest}/npcs', [QuestController::class, 'attachNpc'])
    ->name('campaigns.quests.npcs.attach');
Route::delete('campaigns/{campaign}/quests/{quest}/npcs/{npc}', [QuestController::class, 'detachNpc'])
    ->name('campaigns.quests.npcs.detach');

// Campaign member management
Route::post('campaigns/{campaign}/members', [CampaignController::class, 'addMember'])
    ->name('campaigns.members.add');
Route::delete('campaigns/{campaign}/members', [CampaignController::class, 'removeMember'])
    ->name('campaigns.members.remove');

// Auth scaffolding
require __DIR__.'/auth.php';
