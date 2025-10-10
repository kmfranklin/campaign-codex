{{-- NPCs involved --}}
<div>
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Involved NPCs</h2>

    @if($quest->npcs->count())
        <div class="hidden sm:block overflow-x-auto mb-6">
            <div class="min-w-full bg-white border border-gray-200 shadow-sm sm:rounded-lg">
                <table class="min-w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quest->npcs as $npc)
                            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    <a href="{{ route('compendium.npcs.show', $npc) }}"
                                       class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
                                        {{ $npc->name }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $npc->pivot->role ?? '—' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @can('update', $campaign)
                                        <form action="{{ route('campaigns.quests.npcs.detach', [$campaign, $quest, $npc]) }}"
                                              method="POST" class="inline"
                                              onsubmit="return confirm('Detach this NPC from the quest?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-300 font-medium">
                                                Detach
                                            </button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <p class="text-sm text-gray-700 mb-6">No NPCs attached to this quest.</p>
    @endif

    @can('update', $campaign)
        <form action="{{ route('campaigns.quests.npcs.attach', [$campaign, $quest]) }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label for="npc_id" class="block text-sm font-medium text-gray-700">NPC</label>
                    <select name="npc_id" id="npc_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm" required>
                        @foreach($availableNpcs as $npc)
                            <option value="{{ $npc->id }}">{{ $npc->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label for="role" class="block text-sm font-medium text-gray-700">Role (optional)</label>
                    <input type="text" name="role" id="role"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                           placeholder="quest_giver, ally, enemy">
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button type="submit"
                        class="px-6 py-2 bg-purple-800 text-white font-semibold rounded hover:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                    Attach NPC
                </button>
            </div>
        </form>
    @endcan
</div>
