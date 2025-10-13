@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    {{-- Back link --}}
    <a href="{{ route('campaigns.index') }}"
       class="inline-flex items-center text-sm text-purple-800 hover:text-purple-900 mb-4 font-medium">
      <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7"/>
      </svg>
      Back to Campaigns
    </a>

    <div x-data="{ tab: 'overview' }" class="bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
        {{-- HEADER --}}
        <div class="flex flex-col sm:flex-row items-start bg-white p-6 border-b border-gray-200 sm:items-center">
            <div class="flex-1">
                <div class="flex items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $campaign->name }}</h1>
                        <p class="text-gray-600 mt-1">Dungeon Master: {{ $campaign->dm->name ?? 'Unknown' }}</p>

                        {{-- tags --}}
                        <div class="mt-3 flex flex-wrap gap-2">
                            <span class="bg-purple-50 text-purple-700 text-xs font-medium px-2 py-1 rounded">Campaign</span>
                        </div>
                    </div>

                    {{-- Top-right actions --}}
                    <div class="ml-auto flex gap-2">
                        @can('update', $campaign)
                            <a href="{{ route('campaigns.edit', $campaign) }}"
                               class="px-4 py-2 bg-yellow-400 hover:bg-yellow-500 text-white rounded">
                                Edit
                            </a>
                        @endcan
                        @can('delete', $campaign)
                            <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST"
                                  onsubmit="return confirm('Delete this campaign?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                                    Delete
                                </button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
        {{-- /HEADER --}}

        {{-- Tabs --}}
        <nav class="flex border-b text-sm font-medium text-gray-600">
            <button @click="tab = 'overview'"
                    :class="{ 'border-purple-600 text-purple-800': tab === 'overview' }"
                    class="px-4 py-2 border-b-2 hover:text-purple-700 focus:outline-none">
                Overview
            </button>
            <button @click="tab = 'quests'"
                    :class="{ 'border-purple-600 text-purple-800': tab === 'quests' }"
                    class="px-4 py-2 border-b-2 hover:text-purple-700 focus:outline-none">
                Quests
            </button>
            <button @click="tab = 'npcs'"
                    :class="{ 'border-purple-600 text-purple-800': tab === 'npcs' }"
                    class="px-4 py-2 border-b-2 hover:text-purple-700 focus:outline-none">
                NPCs
            </button>
        </nav>

        {{-- Tab content --}}
        <div class="p-6">
            {{-- Overview tab --}}
            <div x-show="tab === 'overview'" x-cloak>
                @if($campaign->description)
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold text-gray-700 mb-2">Description</h2>
                        <p class="text-gray-800">{{ $campaign->description }}</p>
                    </div>
                @endif

                @include('campaigns.partials.members')
            </div>

            {{-- Quests tab --}}
            <div x-show="tab === 'quests'" x-cloak>
                <div class="flex justify-end mb-4">
                    <a href="{{ route('campaigns.quests.create', $campaign) }}"
                       class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded">
                        + Add quest
                    </a>
                </div>

                @include('campaigns.partials.quests')
            </div>

            {{-- NPCs tab --}}
            <div x-show="tab === 'npcs'" x-cloak>
                @include('campaigns.partials.npcs')
            </div>
        </div>
    </div>
</div>
@endsection
