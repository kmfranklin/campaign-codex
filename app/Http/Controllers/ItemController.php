<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Item::with(['weapon.damageType', 'armor', 'category', 'rarity']);

        // Apply filters
        if ($search = request('q')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($category = request('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $category));
        }
        if ($rarity = request('rarity')) {
            $query->whereHas('rarity', fn($q) => $q->where('slug', $rarity));
        }

        $items = $query->paginate(15);

        // If AJAX request, return only the partial
        if (request()->ajax()) {
            return view('items.partials.results', compact('items'));
        }

        // Otherwise, return full page
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        $item->load(['weapon.damageType', 'armor', 'category', 'rarity', 'baseItem.weapon.damageType', 'baseItem.armor']);

        return view('items.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
