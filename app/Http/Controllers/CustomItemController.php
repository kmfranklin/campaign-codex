<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomItemRequest;
use App\Http\Requests\UpdateCustomItemRequest;
use App\Models\DamageType;
use App\Models\ItemCategory;
use App\Models\ItemRarity;

class CustomItemController extends Controller
{
    public function __construct()
    {
        // Automatically apply ItemPolicy to resource routes
        $this->authorizeResource(Item::class, 'item');
    }

    public function index()
    {
        // TODO: list SRD + custom items with filter toggle
        return view('items.custom.index');
    }

    public function create(Request $request)
    {
        $prefill = session('prefill', []);
        $categories = ItemCategory::orderBy('name')->get();
        $rarities = ItemRarity::orderBy('name')->get();
        $damageTypes = DamageType::orderBy('name')->get();

        return view('items.custom.create', compact('prefill', 'categories', 'rarities', 'damageTypes'));
    }

    public function store(StoreCustomItemRequest $request)
    {
        $data = $request->validated();

        // Create the base Item
        $item = Item::create($data + [
            'is_srd' => false,
            'user_id' => auth()->id(),
        ]);

        // Conditionally create related record
        if ($data['type'] === 'Weapon') {
            $item->weapon()->create($request->only([
                'damage_dice', 'damage_type_id', 'range', 'long_range',
                'distance_unit', 'is_improvised', 'is_simple'
            ]));
        }

        if ($data['type'] === 'Armor') {
            $item->armor()->create($request->only([
                'base_ac', 'adds_dex_mod', 'dex_mod_cap',
                'imposes_stealth_disadvantage', 'strength_requirement'
            ]));
        }

        return redirect()
            ->route('items.custom.show', $item)
            ->with('status', 'Custom item created.');
    }

    public function show(Item $item)
    {
        // TODO: show custom item detail page
        return view('items.custom.show', compact('item'));
    }

    public function edit(Item $item)
    {
        // TODO: show edit form for owner
        return view('items.custom.edit', compact('item'));
    }

    public function update(UpdateCustomItemRequest $request, Item $item)
    {
        $data = $request->validated();

        $item->update($data);

        if ($data['type'] === 'Weapon') {
            $item->weapon()->updateOrCreate(
                ['item_id' => $item->id],
                $request->only([
                    'damage_dice', 'damage_type_id', 'range', 'long_range',
                    'distance_unit', 'is_improvised', 'is_simple'
                ])
            );
        }

        if ($data['type'] === 'Armor') {
            $item->armor()->updateOrCreate(
                ['item_id' => $item->id],
                $request->only([
                    'base_ac', 'adds_dex_mod', 'dex_mod_cap',
                    'imposes_stealth_disadvantage', 'strength_requirement'
                ])
            );
        }

        return redirect()->route('items.custom.show', $item)
            ->with('status', 'Custom item updated.');
    }

    public function destroy(Item $item)
    {
        // TODO: soft delete custom item
        return redirect()->route('items.custom.index');
    }

    public function clone(Item $srdItem)
    {
        abort_unless($srdItem->is_srd, 404);

        $prefill = [
            'name' => $srdItem->name,
            'category' => $srdItem->item_category_id,
            'rarity' => $srdItem->item_rarity_id,
            'type' => $srdItem->type,
            'description' => $srdItem->description,
            'weapon_key' => $srdItem->weapon_key,
            'armor_key' => $srdItem->armor_key,
            'item_key' => $srdItem->item_key,
            'base_item_id' => $srdItem->id,
        ];

        return redirect()->route('items.custom.create')->with('prefill', $prefill);
    }
}
