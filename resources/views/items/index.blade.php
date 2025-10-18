@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Item Index</h1>
        {{-- Add button for creating custom items later --}}
        {{-- <a href="{{ route('items.create') }}"
           class="inline-flex items-center px-4 py-2 bg-purple-800 hover:bg-purple-900 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-300">
            + New Item
        </a> --}}
    </div>

    <div
        x-data="{
            q: @js(request('q')),
            categoryFilter: @js(request('category')),
            rarityFilter: @js(request('rarity')),
            loading: false,
            async applyFilters() {
                this.loading = true;

                const params = new URLSearchParams();
                if (this.q) params.append('q', this.q);
                if (this.categoryFilter) params.append('category', this.categoryFilter);
                if (this.rarityFilter) params.append('rarity', this.rarityFilter);

                const url = `{{ route('items.index') }}?${params.toString()}`;

                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();

                document.querySelector('#item-results').innerHTML = html;

                this.loading = false;
            }
        }"
        class="space-y-4"
    >
        <!-- Filters -->
        <form class="mb-4 flex gap-4 flex-wrap flex-col sm:flex-row items-stretch sm:items-center">
            <input
                name="q"
                x-model="q"
                type="text"
                placeholder="Search by name…"
                @input.debounce.500ms="applyFilters"
                class="border rounded px-3 py-2 flex-1"
            />

            <select name="category" x-model="categoryFilter" @change="applyFilters" class="custom-select">
                <option value="">All Categories</option>
                @foreach(\App\Models\ItemCategory::all() as $c)
                    <option value="{{ $c->slug }}">{{ $c->name }}</option>
                @endforeach
            </select>

            <select name="rarity" x-model="rarityFilter" @change="applyFilters" class="custom-select">
                <option value="">All Rarities</option>
                @foreach(\App\Models\ItemRarity::all() as $r)
                    <option value="{{ $r->slug }}">{{ $r->name }}</option>
                @endforeach
            </select>

            <button type="button"
                    @click="applyFilters"
                    class="bg-purple-800 text-white px-4 py-2 rounded hover:bg-purple-900 font-medium">
                Search
            </button>

            <a href="{{ route('items.index') }}"
               class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-center font-medium">
                Reset
            </a>
        </form>

        <!-- Results + Overlay -->
        <div class="relative">
            <!-- Overlay -->
            <div
                x-show="loading"
                x-cloak
                x-transition.opacity
                class="absolute inset-0 bg-white/70 flex items-center justify-center z-10"
            >
                <svg class="animate-spin h-10 w-10 text-purple-800" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                    <circle class="opacity-75" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"
                            stroke-linecap="round"
                            stroke-dasharray="80"
                            stroke-dashoffset="60" />
                </svg>
            </div>

            <!-- Results container -->
            <div id="item-results">
                @include('items.partials.results', ['items' => $items])
            </div>
        </div>
    </div>
</div>
@endsection
