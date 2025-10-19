{{-- Desktop Table --}}
<div class="hidden sm:block">
    <div class="overflow-x-auto bg-white border border-gray-200 shadow-sm sm:rounded-lg">
        <table class="min-w-full table-auto">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Race/Species</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Class / Archetype</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Alignment</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($npcs as $npc)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-normal break-words max-w-xs">
                            {{ $npc->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-normal break-words max-w-xs">
                            {{ $npc->race ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-normal break-words max-w-xs">
                            {{ $npc['class'] ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">
                            {{ $npc['alignment'] ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 whitespace-normal break-words max-w-sm">
                            {{ $npc['role'] ?? '—' }}
                        </td>
                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                            <a href="{{ route('compendium.npcs.show', $npc) }}"
                               class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
                                View
                            </a>
                            <a href="{{ route('compendium.npcs.edit', $npc) }}"
                               class="ml-4 text-yellow-600 hover:text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-300 font-medium">
                                Edit
                            </a>
                            <form action="{{ route('compendium.npcs.destroy', $npc) }}" method="POST" class="inline ml-4"
                                  onsubmit="return confirm('Delete this NPC?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-300 font-medium">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-sm text-center text-gray-700">
                            No NPCs found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Mobile Cards --}}
<div class="sm:hidden space-y-4">
    @forelse($npcs as $npc)
        <div class="bg-white border border-gray-200 shadow p-4 rounded-lg">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-lg font-medium text-gray-900 break-words">{{ $npc->name }}</h2>
                    <p class="text-sm text-gray-700">
                        {{ $npc['class'] ?? '—' }} &middot; {{ $npc->race ?? '—' }}
                    </p>
                    @if($npc['role'])
                        <p class="text-xs text-gray-500 break-words">{{ $npc['role'] }}</p>
                    @endif
                </div>
                <a href="{{ route('compendium.npcs.show', $npc) }}"
                   class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
                    View
                </a>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-700">No NPCs found.</p>
    @endforelse
</div>

{{-- Pagination Links --}}
@if ($npcs->hasPages())
    <div id="pagination-links" class="mt-4">
        {{ $npcs->links() }}
    </div>
@endif
