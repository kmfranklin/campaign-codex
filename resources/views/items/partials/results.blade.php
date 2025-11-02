{{-- resources/views/items/partials/results.blade.php --}}
<div id="item-results" class="space-y-6" role="region" aria-live="polite" aria-atomic="true">
  {{-- Desktop Table --}}
  <div class="hidden sm:block">
    <div class="overflow-x-auto bg-white border border-gray-200 shadow-sm sm:rounded-lg">
      <table class="min-w-full table-auto">
        <thead class="bg-gray-100">
          <tr>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Category</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Rarity</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Details</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($items as $item)
            <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
              <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-normal break-words max-w-xs">
                {{ $item->name }}
                @if($item->baseItem)
                  <div class="text-xs text-gray-500">
                    Variant of <a href="{{ route('items.show', $item->baseItem) }}" class="underline">{{ $item->baseItem->name }}</a>
                  </div>
                @endif
              </td>
              <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">{{ $item->category?->name ?? '—' }}</td>
              <td class="px-6 py-4 text-sm text-gray-700 whitespace-nowrap">{{ $item->rarity?->name ?? '—' }}</td>
              <td class="px-6 py-4 text-sm text-gray-700 whitespace-normal break-words max-w-md">
                @if($item->weapon)
                  {{ $item->weapon->damage_dice }} {{ $item->weapon->damageType?->name }}
                @elseif($item->armor)
                  AC {{ $item->armor->base_ac }}
                  @if($item->armor->adds_dex_mod)
                    + Dex (cap {{ $item->armor->dex_mod_cap ?? '∞' }})
                  @endif
                @else
                  {{ $item->description ? Str::limit(strip_tags(Str::markdown($item->description)), 120) : '—' }}
                @endif
              </td>
              <td class="px-6 py-4 text-sm whitespace-nowrap">
                <a href="{{ route('items.show', $item) }}"
                   class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
                  View
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-6 py-4 text-sm text-center text-gray-700">
                No items found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Mobile Cards --}}
  <div class="sm:hidden space-y-4">
    @forelse($items as $item)
      <div class="bg-white border border-gray-200 shadow p-4 rounded-lg">
        <div class="flex justify-between items-center">
          <div>
            <h2 class="text-lg font-medium text-gray-900">{{ $item->name }}</h2>
            <p class="text-sm text-gray-700">
              {{ $item->category?->name ?? '—' }} &middot; {{ $item->rarity?->name ?? '—' }}
            </p>
            @if($item->baseItem)
              <p class="text-xs text-gray-500">
                Variant of <a href="{{ route('items.show', $item->baseItem) }}" class="underline">{{ $item->baseItem->name }}</a>
              </p>
            @endif
          </div>
          <a href="{{ route('items.show', $item) }}"
             class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
            View
          </a>
        </div>
      </div>
    @empty
      <p class="text-center text-gray-700">No items found.</p>
    @endforelse
  </div>

  {{-- Pagination Links --}}
  @if ($items->hasPages())
    <div id="pagination-links" class="mt-4" aria-label="Pagination">
      {{-- withQueryString() ensures current filters remain in links as an extra safeguard --}}
      {!! $items->withQueryString()->links('pagination::tailwind') !!}
    </div>
  @endif
</div>
