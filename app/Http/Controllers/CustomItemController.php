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
            $source = Item::with(['weapon', 'armor'])->findOrFail($baseId);

            // Authorization:
            // - Any signed-in user can clone SRD items
            // - Only the owner can clone their custom items
            if (!$source->is_srd && $source->user_id !== auth()->id()) {
                abort(403);
            }

            $prefill = [
                'name'                 => $source->name,
                'item_category_id'     => $source->item_category_id,
                'item_rarity_id'       => $source->item_rarity_id,
                'description'          => $source->description,
                'base_item_id'         => $source->id,
            ];

            $weaponSource = $source->weapon ?? $source->baseItem?->weapon;
            $armorSource  = $source->armor ?? $source->baseItem?->armor;

            if ($weaponSource) {
                $prefill += [
                    'damage_dice'     => $weaponSource->damage_dice,
                    'damage_type_id'  => $weaponSource->damage_type_id,
                    'range'           => $weaponSource->range,
                    'long_range'      => $weaponSource->long_range,
                    'distance_unit'   => $weaponSource->distance_unit,
                    'is_improvised'   => (bool) $weaponSource->is_improvised,
                    'is_simple'       => (bool) $weaponSource->is_simple,
                ];
            }

            if ($armorSource) {
                $prefill += [
                    'base_ac'                      => $armorSource->base_ac,
                    'adds_dex_mod'                 => (bool) $armorSource->adds_dex_mod,
                    'dex_mod_cap'                  => $armorSource->dex_mod_cap,
                    'imposes_stealth_disadvantage' => (bool)            $armorSource->imposes_stealth_disadvantage,
                    'strength_requirement'         => $armorSource->strength_requirement,
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
