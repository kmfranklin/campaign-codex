@php
    $npcMap = collect();

    foreach ($quests as $quest) {
        foreach ($quest->npcs as $npc) {
            $npcMap[$npc->id] ??= [
                'npc' => $npc,
                'quests' => collect(),
            ];

            $npcMap[$npc->id]['quests']->push([
                'title' => $quest->title,
                'role' => $npc->pivot->role,
                'quest_id' => $quest->id,
            ]);
        }
    }
@endphp

@if($npcMap->isEmpty())
    <x-empty-state
        icon="🧙"
        title="No NPCs yet"
        message="Bring your world to life by adding characters."
    />
@else
    {{-- Add NPC button --}}
    <div class="flex justify-end mb-4">
        <a href="{{ route('compendium.npcs.create') }}"
           class="inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded">
            + Add NPC
        </a>
    </div>

    {{-- Supporting text --}}
    <p class="text-sm text-gray-600 mb-4">
        These NPCs are involved in one or more quests in this campaign. Click a name to view their roles and profile.
    </p>

    {{-- Collapsible NPC list --}}
    <ul class="divide-y divide-gray-200">
        @foreach($npcMap as $entry)
            @php $npc = $entry['npc']; @endphp
            <li x-data="{ open: false }" class="py-4">
                <button @click="open = !open"
                        class="w-full text-left flex justify-between items-center font-medium text-gray-800 hover:text-purple-700 focus:outline-none">
                    <span>{{ $npc->name }}</span>
                    <svg :class="{ 'rotate-180': open }"
                         class="h-5 w-5 transform transition-transform duration-200"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div x-show="open" x-cloak class="mt-3 pl-4 text-sm text-gray-700 space-y-2">
                    <ul class="space-y-1">
                        @foreach($entry['quests'] as $q)
                            <li>
                                <a href="{{ route('campaigns.quests.show', [$campaign, $q['quest_id']]) }}"
                                   class="text-purple-700 hover:underline">
                                    {{ $q['title'] }}
                                </a>
                                <span class="ml-2 text-gray-500">({{ Str::headline($q['role']) }})</span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ route('compendium.npcs.show', $npc) }}"
                       class="inline-block text-purple-600 hover:text-purple-800 hover:underline">
                        View full profile →
                    </a>
                </div>
            </li>
        @endforeach
    </ul>
@endif
