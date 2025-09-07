<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Npc;

class CharacterCompendiumController extends Controller
{
    /**
     * Display the Character Compendium index page.
     */
    public function index()
    {
        $npcs = Npc::orderBy('name')->get();

        return view('characters.index', compact('npcs'));
    }
}
