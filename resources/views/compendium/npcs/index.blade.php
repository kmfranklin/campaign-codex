@extends('layouts.app')

@section('content')
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between py-6">
      <h1 class="text-2xl font-semibold text-gray-900">Character Compendium</h1>
      <a href="{{ route('compendium.npcs.create') }}"
         class="inline-flex items-center px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-300">
        + New NPC
      </a>
    </div>

    {{-- Desktop Table --}}
    <div class="hidden sm:block overflow-x-auto">
      <div class="min-w-full bg-white border border-gray-200 shadow-sm sm:rounded-lg">
        <table class="min-w-full">
          <thead class="bg-gray-100">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Type</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Class / Archetype</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Race</th>
              <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($npcs as $npc)
              <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $npc->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">NPC</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $npc['class'] ?? '—' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $npc->race ?? '—' }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <a href="{{ route('compendium.npcs.show', $npc) }}"
                     class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-300">
                    View
                  </a>
                  <a href="{{ route('compendium.npcs.edit', $npc) }}"
                     class="ml-4 text-yellow-600 hover:text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    Edit
                  </a>
                  <form action="{{ route('compendium.npcs.destroy', $npc) }}" method="POST" class="inline ml-4"
                        onsubmit="return confirm('Delete this NPC?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="text-red-600 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-300">
                      Delete
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5"
                    class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
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
          <div class="flex justify-between items-center">
            <div>
              <h2 class="text-lg font-medium text-gray-900">{{ $npc->name }}</h2>
              <p class="text-sm text-gray-700">
                {{ $npc['class'] ?? '—' }} &middot; {{ $npc->race ?? '—' }}
              </p>
            </div>
            <a href="{{ route('compendium.npcs.show', $npc) }}"
               class="text-indigo-600 hover:text-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-300">
              View
            </a>
          </div>
        </div>
      @empty
        <p class="text-center text-gray-700">No NPCs found.</p>
      @endforelse
    </div>
  </div>
@endsection
