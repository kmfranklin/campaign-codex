@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Character Compendium</h1>
        <a href="{{ route('compendium.npcs.create') }}"
           class="inline-flex items-center px-4 py-2 bg-purple-800 hover:bg-purple-900 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-300">
            + New NPC
        </a>
    </div>

    <form
        x-data="{
            q: @js(request('q')),
            classFilter: @js(request('class')),
            alignmentFilter: @js(request('alignment')),
            roleFilter: @js(request('role')),
            async applyFilters() {
                const params = new URLSearchParams();
                if (this.q) params.append('q', this.q);
                if (this.classFilter) params.append('class', this.classFilter);
                if (this.alignmentFilter) params.append('alignment', this.  alignmentFilter);
                if (this.roleFilter) params.append('role', this.roleFilter);

                const url = `{{ route('compendium.npcs.index') }}?${params.toString ()}`;

                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();

                // Since your partial has no wrapper, just drop it in
                document.querySelector('#npc-results').innerHTML = html;
            }
        }"

        class="mb-4 flex gap-4 flex-wrap flex-col sm:flex-row items-stretch sm:items-center"
    >
        <!-- Name search -->
        <input
            name="q"
            x-model="q"
            type="text"
            placeholder="Search by name…"
            @input.debounce.500ms="applyFilters"
            class="border rounded px-3 py-2 flex-1"
        />

        <!-- Class filter -->
        <select name="class" x-model="classFilter" @change="applyFilters" class="custom-select">
            <option value="">All Classes</option>
            @foreach(\App\Models\Npc::CLASSES as $c)
                <option value="{{ $c }}">{{ $c }}</option>
            @endforeach
        </select>

        <!-- Alignment filter -->
        <select name="alignment" x-model="alignmentFilter" @change="applyFilters" class="custom-select">
            <option value="">All Alignments</option>
            @foreach(\App\Models\Npc::ALIGNMENTS as $a)
                <option value="{{ $a }}">{{ $a }}</option>
            @endforeach
        </select>

        <!-- Roles filter -->
        <select name="role" x-model="roleFilter" @change="applyFilters" class="custom-select">
            <option value="">All Roles</option>
            @foreach(\App\Models\Npc::SOCIAL_ROLES as $r)
                <option value="{{ $r }}">{{ $r }}</option>
            @endforeach
        </select>

        <button type="button"
                @click="applyFilters"
                class="bg-purple-800 text-white px-4 py-2 rounded hover:bg-purple-900 font-medium">
            Search
        </button>

        <a href="{{ route('compendium.npcs.index') }}"
           class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 text-center font-medium">
            Reset
        </a>
    </form>

    <!-- Results container -->
    <div id="npc-results">
        @include('compendium.npcs.partials.results', ['npcs' => $npcs])
    </div>
</div>
@endsection
