<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CharacterCompendiumController extends Controller
{
    /**
     * Display the Character Compendium index page.
     */
    public function index()
    {
        return view('characters.index');
    }
}
