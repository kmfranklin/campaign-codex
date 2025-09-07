{{-- resources/views/npcs/show.blade.php --}}
@extends('layouts.app')

@section('content')
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    {{-- Back link --}}
    <a href="{{ route('compendium.npcs.index') }}"
       class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900 mb-4">
      <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7"/>
      </svg>
      Back to Compendium
    </a>

<div class="max-w-4xl mx-auto bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">

    {{-- HEADER --}}
    <div
        @class([
            'flex flex-col sm:flex-row items-start bg-white p-6 border-b border-gray-200',
            'sm:items-center' => empty($npc->portrait_path),
        ])
    >
        {{-- Portrait (only if set) --}}
        @if($npc->portrait_path)
            <img
                src="{{ $npc->portrait_path }}"
                alt="{{ $npc->name }} portrait"
                class="w-32 h-32 sm:w-48 sm:h-48 rounded-full object-cover border-4 border-white shadow-sm"
            >
        @endif

        <div
            @class([
                'mt-4 sm:mt-0 flex-1',
                'sm:ml-6' => $npc->portrait_path,
            ])
        >
            <div class="flex items-start">
                {{-- Name & Tags --}}
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $npc->name }}</h1>
                    @if($npc->alias)
                        <p class="text-gray-600 italic">“{{ $npc->alias }}”</p>
                    @endif

                    {{-- tags --}}
                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="bg-indigo-50 text-indigo-700 text-xs font-medium px-2 py-1 rounded">NPC</span>
                        @if($npc->race)
                            <span class="bg-green-50 text-green-700 text-xs font-medium px-2 py-1 rounded">
                                {{ $npc->race }}
                            </span>
                        @endif
                        @if($npc['class'])
                            <span class="bg-yellow-50 text-yellow-700 text-xs font-medium px-2 py-1 rounded">
                                {{ $npc['class'] }}
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Top-right actions --}}
                <div class="ml-auto flex gap-2">
                    <a
                        href="{{ route('compendium.npcs.edit', $npc) }}"
                        class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded"
                    >
                        Edit
                    </a>
                    <form
                        action="{{ route('compendium.npcs.destroy', $npc) }}"
                        method="POST"
                        onsubmit="return confirm('Delete this NPC?')"
                    >
                        @csrf
                        @method('DELETE')
                        <button
                            type="submit"
                            class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded"
                        >
                            Delete
                        </button>
                    </form>
                </div>
            </div>

            {{-- Quick-stats (only if any exist) --}}
            @php
                $quick = [
                    'Hit Points'    => $npc->hit_points,
                    'Armor Class'    => $npc->armor_class,
                    'Speed' => $npc->speed,
                    'Challenge Rating'    => $npc->challenge_rating,
                    'Proficiency Bonus'    => $npc->proficiency_bonus,
                ];
                $quick = array_filter($quick, fn($v) => !is_null($v) && $v !== '');
            @endphp

            @if(count($quick))
                <div class="mt-4 grid
                            grid-cols-2
                            sm:grid-cols-3
                            md:grid-cols-4
                            lg:grid-cols-5
                            gap-4">
                    @foreach($quick as $label => $value)
                        <div class="bg-white border border-gray-200 rounded-lg p-3 text-center">
                            <div class="text-xs font-medium text-gray-600 uppercase">{{ $label }}</div>
                            <div class="mt-1 text-xl font-bold text-gray-900">{{ $value }}</div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    {{-- /HEADER --}}

    {{-- CORE IDENTITY --}}
    @php
        $core = [
            'Alignment' => $npc->alignment,
            'Location'  => $npc->location,
            'Status'    => $npc->status,
            'Role'      => $npc->role,
        ];
        $core = array_filter($core, fn($v) => !is_null($v) && $v !== '');
    @endphp

    @if(count($core))
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Core Identity</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                @foreach($core as $label => $value)
                    <div>
                        <dt class="font-medium text-gray-600">{{ $label }}</dt>
                        <dd class="text-gray-800">{{ $value }}</dd>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    {{-- /CORE IDENTITY --}}

    {{-- DESCRIPTIVE --}}
    @if($npc->description || $npc->personality || $npc->quirks)
        <div class="p-6 bg-white border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Description</h2>
            @if($npc->description)
                <p class="mb-4 text-gray-800">{{ $npc->description }}</p>
            @endif
            @if($npc->personality)
                <p class="mb-4 italic text-gray-700">
                    Personality: {{ $npc->personality }}
                </p>
            @endif
            @if($npc->quirks)
                <p class="text-gray-700">Quirks: {{ $npc->quirks }}</p>
            @endif
        </div>
    @endif
    {{-- /DESCRIPTIVE --}}

    {{-- COMBAT STATS --}}
    @php
        $stats = [
            'strength','dexterity','constitution',
            'intelligence','wisdom','charisma',
        ];
        $hasStat = collect($stats)->some(fn($s) => !is_null($npc->$s));
    @endphp

    @if($hasStat)
        <div class="p-6 bg-gray-50 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Abilities + Stats</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
                @foreach($stats as $stat)
                    @if(!is_null($npc->$stat))
                        <div class="bg-white border border-gray-200 rounded-lg p-3 text-center">
                            <div class="text-xs font-medium text-gray-600 uppercase">
                                {{ ucfirst($stat) }}
                            </div>
                            <div class="mt-1 text-xl font-bold text-gray-900">{{ $npc->$stat }}</div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    @endif
    {{-- /COMBAT STATS --}}

</div>
@endsection
