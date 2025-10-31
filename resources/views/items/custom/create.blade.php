{{-- resources/views/items/custom/create.blade.php --}}
@extends('layouts.app')

@php
    $origin = request('from');

    $backRoute = match($origin) {
        'custom' => route('customItems.index'),
        'srd' => route('srdItems.index'),
        default => route('items.index'),
    };
@endphp

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
    {{-- Back link --}}
    <a href="{{ $backRoute }}"
       class="inline-flex items-center text-sm text-purple-800 hover:text-purple-900 mb-4 font-medium">
        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Items
    </a>


    <h1 class="text-2xl font-bold mb-6">Create Custom Item</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('items.custom.store') }}">
        @csrf

        <!-- Name -->
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input id="name" name="name" type="text"
                   value="{{ old('name', $prefill['name'] ?? '') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                          focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                   required>
        </div>

        <!-- Cost / Weight -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="cost" class="block text-sm font-medium text-gray-700">Cost (gp)</label>
                <input id="cost" name="cost" type="number" step="0.01"
                       value="{{ old('cost', $prefill['cost'] ?? '') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                              focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            </div>
            <div>
                <label for="weight" class="block text-sm font-medium text-gray-700">Weight (lb)</label>
                <input id="weight" name="weight" type="number" step="0.01"
                       value="{{ old('weight', $prefill['weight'] ?? '') }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                              focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
            </div>
        </div>

        <!-- Category / Rarity -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="item_category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select id="item_category_id" name="item_category_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" required>
                    <option value="">Choose item category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            @selected(old('item_category_id', $prefill      ['item_category_id'] ?? '') == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="item_rarity_id" class="block text-sm font-medium text-gray-700">Rarity</label>
                <select id="item_rarity_id" name="item_rarity_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                    <option value="">Choose item rarity</option>
                    @foreach ($rarities as $rarity)
                        <option value="{{ $rarity->id }}"
                            @selected(old('item_rarity_id', $prefill        ['item_rarity_id'] ?? '') == $rarity->id)>
                            {{ $rarity->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                             focus:border-purple-500 focus:ring-purple-500 sm:text-sm">{{ old('description', $prefill['description'] ?? '') }}</textarea>
        </div>

        <!-- Magic / Attunement -->
        <div class="flex items-center space-x-6 mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_magic_item" value="1"
                       @checked(old('is_magic_item', $prefill['is_magic_item'] ?? false))
                       class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="ml-2">Magic Item</span>
            </label>

            <label class="inline-flex items-center">
                <input type="checkbox" id="requires_attunement" name="requires_attunement" value="1"
                       @checked(old('requires_attunement', $prefill['requires_attunement'] ?? false))
                       class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                <span class="ml-2">Requires Attunement</span>
            </label>
        </div>

        <!-- Attunement Requirements (hidden unless checkbox is checked) -->
        <div id="attunement-requirements-wrapper" class="mt-2 hidden">
            <label for="attunement_requirements" class="block text-sm font-medium text-gray-700">
                Attunement Requirements
            </label>
            <input id="attunement_requirements" name="attunement_requirements" type="text"
                   value="{{ old('attunement_requirements', $prefill['attunement_requirements'] ?? '') }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                          focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
        </div>


        <!-- Weapon-specific fields -->
        <div id="weapon-fields" class="space-y-4 hidden">
            <h2 class="text-lg font-semibold">Weapon Details</h2>

            <!-- Damage Dice + Damage Type -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="damage_dice" class="block text-sm font-medium text-gray-700">Damage Dice</label>
                    <input id="damage_dice" name="damage_dice" type="text"
                           value="{{ old('damage_dice', $prefill['damage_dice'] ?? '') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                  focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="damage_type_id" class="block text-sm font-medium text-gray-700">Damage Type</label>
                    <select id="damage_type_id" name="damage_type_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                   focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                        <option value="">Choose damage type</option>
                        @foreach ($damageTypes as $dt)
                            <option value="{{ $dt->id }}" @selected(old('damage_type_id', $prefill['damage_type_id'] ?? '') == $dt->id)>
                                {{ $dt->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Range + Long Range + Distance Unit -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="range" class="block text-sm font-medium text-gray-700">Normal Range</label>
                    <input id="range" name="range" type="number" step="1"
                           value="{{ old('range', $prefill['range'] ?? '') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                  focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="long_range" class="block text-sm font-medium text-gray-700">Long Range</label>
                    <input id="long_range" name="long_range" type="number" step="1"
                           value="{{ old('long_range', $prefill['long_range'] ?? '') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                  focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="distance_unit" class="block text-sm font-medium text-gray-700">Distance Unit</label>
                    <input id="distance_unit" name="distance_unit" type="text"
                           value="{{ old('distance_unit', $prefill['distance_unit'] ?? 'ft') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                  focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
            </div>

            <!-- Flags -->
            <div class="flex items-center space-x-6 mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_improvised" value="1"
                           @checked(old('is_improvised', $prefill['is_improvised'] ?? false))
                           class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="ml-2">Improvised</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_simple" value="1"
                           @checked(old('is_simple', $prefill['is_simple'] ?? false))
                           class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="ml-2">Simple</span>
                </label>
            </div>
        </div>

        <!-- Armor-specific fields -->
        <div id="armor-fields" class="space-y-4 hidden">
            <h2 class="text-lg font-semibold">Armor Details</h2>

            <!-- Base AC, Dex Mod Cap, Strength Requirement -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label for="base_ac" class="block text-sm font-medium text-gray-700">Base AC</label>
                    <input id="base_ac" name="base_ac" type="number"
                           value="{{ old('base_ac', $prefill['base_ac'] ?? '') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                  focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="dex_mod_cap" class="block text-sm font-medium text-gray-700">Dex Mod Cap</label>
                    <input id="dex_mod_cap" name="dex_mod_cap" type="number"
                           value="{{ old('dex_mod_cap', $prefill['dex_mod_cap'] ?? '') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                  focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
                <div>
                    <label for="strength_requirement" class="block text-sm font-medium text-gray-700">Strength Requirement</label>
                    <input id="strength_requirement" name="strength_requirement" type="number"
                           value="{{ old('strength_requirement', $prefill['strength_requirement'] ?? '') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                                  focus:border-purple-500 focus:ring-purple-500 sm:text-sm">
                </div>
            </div>

            <!-- Flags -->
            <div class="flex items-center space-x-6 mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="adds_dex_mod" value="1"
                           @checked(old('adds_dex_mod', $prefill['adds_dex_mod'] ?? true))
                           class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="ml-2">Adds Dex Modifier</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="imposes_stealth_disadvantage" value="1"
                           @checked(old('imposes_stealth_disadvantage', $prefill['imposes_stealth_disadvantage'] ?? false))
                           class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                    <span class="ml-2">Stealth Disadvantage</span>
                </label>
            </div>
        </div>

        {{-- Variant link (when cloning) --}}
        @if(!empty($prefill['base_item_id']))
            <input type="hidden" name="base_item_id" value="{{ $prefill['base_item_id'] }}">
        @endif

        <div class="pt-4 border-t flex justify-between">
    {{-- Cancel button --}}
    <a href="{{ $backRoute }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
        Cancel
    </a>

            <button type="submit"
                    class="px-6 py-2 bg-purple-800 text-white font-semibold rounded hover:bg-purple-900
                           focus:outline-none focus:ring-2 focus:ring-purple-500">
                Create Item
            </button>
        </div>
    </form>
</div>
@endsection
