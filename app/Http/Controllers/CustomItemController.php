<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

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

    public function create()
    {
        // TODO: show create form (blank or prefilled for clone)
        return view('items.custom.create');
    }

    public function store(Request $request)
    {
        // TODO: validate and persist new custom item
        return redirect()->route('items.custom.index');
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

    public function update(Request $request, Item $item)
    {
        // TODO: validate and update custom item
        return redirect()->route('items.custom.show', $item);
    }

    public function destroy(Item $item)
    {
        // TODO: soft delete custom item
        return redirect()->route('items.custom.index');
    }

    public function clone(Item $srdItem)
    {
        // TODO: prefill create form with SRD item data
        return redirect()->route('items.custom.create')
            ->with('prefill', $srdItem->toArray());
    }
}
