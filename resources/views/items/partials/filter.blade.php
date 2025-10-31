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

    <a href="{{ url()->current() }}"
       class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-center font-medium">
        Reset
    </a>
</form>
