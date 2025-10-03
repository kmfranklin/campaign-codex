@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
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

    <div class="max-w-4xl mx-auto bg-white border border-gray-200 shadow-md rounded-lg overflow-hidden">
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

        {{-- DESCRIPTION --}}
        @if($campaign->description)
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-700 mb-4">Description</h2>
                <p class="text-gray-800">{{ $campaign->description }}</p>
            </div>
        @endif
        {{-- /DESCRIPTION --}}

        {{-- MEMBERS --}}
        <x-detail-block title="Members" :index="0">
            @if($campaign->members->count())
                <ul class="space-y-2">
                    @foreach($campaign->members as $member)
                        <li class="flex items-center justify-between">
                            <span class="text-gray-800">{{ $member->name }}</span>
                            @php
                                $role = $member->pivot->role === 'dm' ? 'DM' : ucfirst      ($member->pivot->role);
                            @endphp
                            <span class="text-xs text-gray-500">{{ $role }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state
                    icon="👥"
                    title="No members yet"
                    message="Invite players to join your campaign."
                />
            @endif
        </x-detail-block>
        {{-- /MEMBERS --}}

        {{-- QUESTS --}}
        <x-detail-block title="Quests" :index="1">
            @if(isset($campaign->quests) && $campaign->quests->count())
                <ul class="space-y-2">
                    @foreach($campaign->quests as $quest)
                        <li class="text-gray-800">{{ $quest->title }}</li>
                    @endforeach
                </ul>
            @else
                <x-empty-state
                    icon="🗺️"
                    title="No quests yet"
                    message="Start your adventure by creating the first quest."
                />
            @endif
        </x-detail-block>
        {{-- /QUESTS --}}

        {{-- NPCS --}}
        <x-detail-block title="NPCs" :index="2">
            @if(isset($campaign->npcs) && $campaign->npcs->count())
                <ul class="space-y-2">
                    @foreach($campaign->npcs as $npc)
                        <li class="text-gray-800">{{ $npc->name }}</li>
                    @endforeach
                </ul>
            @else
                <x-empty-state
                    icon="🧙"
                    title="No NPCs yet"
                    message="Bring your world to life by adding characters."
                />
            @endif
        </x-detail-block>
        {{-- /NPCS --}}

        {{-- FUTURE: Encounters will live under Quest detail pages --}}
    </div>
</div>
@endsection
