<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCustomItemRequest;
use App\Http\Requests\UpdateCustomItemRequest;
use App\Models\DamageType;
use App\Models\ItemCategory;
use App\Models\ItemRarity;
use Illuminate\Support\Str;

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
        $prefill = [];
        $baseId = $request->query('base_item_id');

        if ($baseId) {
            $source = Item::findOrFail($baseId);

            // Authorization:
            // - Any signed-in user can clone SRD items
            // - Only the owner can clone their custom items
            if (!$source->is_srd && $source->user_id !== auth()->id()) {
                abort(403);
            }

            $prefill = [
                'name'         => $source->name,
                'category'     => $source->item_category_id,
                'rarity'       => $source->item_rarity_id,
                'type'         => $source->type,
                'description'  => $source->description,
                'base_item_id' => $source->id,
            ];

            // Optional: prefill subtype details if present
            if ($source->weapon) {
                $prefill += [
                    'damage_dice'     => $source->weapon->damage_dice,
                    'damage_type_id'  => $source->weapon->damage_type_id,
                    'range'           => $source->weapon->range,
                    'long_range'      => $source->weapon->long_range,
                    'distance_unit'   => $source->weapon->distance_unit,
                    'is_improvised'   => (bool) $source->weapon->is_improvised,
                    'is_simple'       => (bool) $source->weapon->is_simple,
                ];
            }

            if ($source->armor) {
                $prefill += [
                    'base_ac'                      => $source->armor->base_ac,
                    'adds_dex_mod'                 => (bool)    $source->armor->adds_dex_mod,
                    'dex_mod_cap'                  => $source->armor->dex_mod_cap,
                    'imposes_stealth_disadvantage' => (bool)    $source->armor->imposes_stealth_disadvantage,
                    'strength_requirement'         =>   $source->armor->strength_requirement,
                ];
            }
        }

        $categories = ItemCategory::orderBy('name')->get();
        $rarities   = ItemRarity::orderBy('name')->get();
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
            'item_key' => Str::uuid()->toString(),
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
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        // TODO: show edit form for owner
        return view('items.custom.edit', compact('item'));
    }

    public function update(UpdateCustomItemRequest $request, Item $item)
    {
        $data = $request->validated();

        $item->update(collect($data)->except('item_key')->all());

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
}
