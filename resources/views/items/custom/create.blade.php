{{-- resources/views/items/custom/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
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

    <form method="POST" action="{{ route('items.custom.store') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input id="name" name="name" type="text" class="mt-1 block w-full border rounded"
                   value="{{ old('name', $prefill['name'] ?? '') }}" required>
        </div>

        <!-- Category -->
        <div>
            <label for="category" class="block text-sm font-medium      text-gray-700">Category</label>
            <select id="category" name="category" class="mt-1 block w-full border       rounded" required>
                <option value="">Choose item category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}"
                        @selected(old('category', $prefill['category'] ?? '') ===       $category->slug)>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>

        <!-- Type -->
        <div>
            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
            <select id="type" name="type" class="mt-1 block w-full border rounded">
                <option value="">Choose item type</option>
                @foreach (['Gear','Weapon','Armor'] as $type)
                    <option value="{{ $type }}" @selected(old('type', $prefill['type'] ?? '') === $type)>
                        {{ $type }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Rarity -->
        <div>
            <label for="item_rarity_id" class="block text-sm font-medium        text-gray-700">Rarity</label>
            <select id="item_rarity_id" name="item_rarity_id" class="mt-1 block w-full      border rounded">
                <option value="">Choose item rarity</option>
                @foreach ($rarities as $rarity)
                    <option value="{{ $rarity->id }}"
                        @selected(old('item_rarity_id', $prefill['item_rarity_id'] ??       '') == $rarity->id)>
                        {{ $rarity->name }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('item_rarity_id')" class="mt-2" />
        </div>

        <!-- Description -->
        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" class="mt-1 block w-full border rounded">{{ old('description', $prefill['description'] ?? '') }}</textarea>
        </div>

        @if(!empty($prefill['base_item_id']))
            <input type="hidden" name="base_item_id" value="{{ $prefill['base_item_id'] }}">
        @endif

        <div class="pt-4 border-t flex justify-end">
            <button type="submit" class="px-6 py-2 bg-purple-800 text-white font-semibold rounded hover:bg-purple-900">
                Create Item
            </button>
        </div>
    </form>
</div>
@endsection
