{{-- Desktop Table --}}
<div class="hidden sm:block overflow-x-auto">
    <div class="min-w-full bg-white border border-gray-200 shadow-sm sm:rounded-lg">
        <table class="min-w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($campaigns as $campaign)
                    <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $campaign->name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ Str::limit($campaign->description, 80) ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            {{-- View is always visible --}}
                            <a href="{{ route('campaigns.show', $campaign) }}"
                               class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300                       font-medium">
                                View
                            </a>

                            {{-- Only show Edit if authorized --}}
                            @can('update', $campaign)
                                <a href="{{ route('campaigns.edit', $campaign) }}"
                                   class="ml-4 text-yellow-600 hover:text-yellow-900 focus:outline-none focus:ring-2                        focus:ring-yellow-300 font-medium">
                                    Edit
                                </a>
                            @endcan

                            {{-- Only show Delete if authorized --}}
                            @can('delete', $campaign)
                                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="inline ml-4"
                                      onsubmit="return confirm('Delete this campaign?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-300                       font-medium">
                                        Delete
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3"
                            class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-700">
                            No campaigns found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Mobile Cards --}}
<div class="sm:hidden space-y-4">
    @forelse($campaigns as $campaign)
        <div class="bg-white border border-gray-200 shadow p-4 rounded-lg">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-lg font-medium text-gray-900">{{ $campaign->name }}</h2>
                    @if($campaign->description)
                        <p class="text-sm text-gray-700">
                            {{ Str::limit($campaign->description, 80) }}
                        </p>
                    @endif
                </div>
                <a href="{{ route('campaigns.show', $campaign) }}"
                   class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
                    View
                </a>
            </div>
        </div>
    @empty
        <p class="text-center text-gray-700">No campaigns found.</p>
    @endforelse
</div>

{{-- Pagination Links --}}
@if ($campaigns->hasPages())
    <div id="pagination-links" class="mt-4">
        {{ $campaigns->links() }}
    </div>
@endif
