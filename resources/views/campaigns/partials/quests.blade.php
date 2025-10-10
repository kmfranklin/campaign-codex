@if($campaign->quests->count())
    {{-- Desktop Table --}}
    <div class="hidden sm:block overflow-x-auto">
        <div class="min-w-full bg-white border border-gray-200 shadow-sm sm:rounded-lg">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Title</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaign->quests as $quest)
                        <tr class="odd:bg-white even:bg-gray-50 hover:bg-gray-100">
                            {{-- Title --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <a href="{{ route('campaigns.quests.show', [$campaign, $quest]) }}"
                                   class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
                                    {{ $quest->title }}
                                </a>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ ucfirst($quest->status) }}
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <a href="{{ route('campaigns.quests.show', [$campaign, $quest]) }}"
                                   class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
                                    View
                                </a>

                                <a href="{{ route('campaigns.quests.edit', [$campaign, $quest]) }}"
                                   class="ml-4 text-yellow-600 hover:text-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-300 font-medium">
                                    Edit
                                </a>

                                <form action="{{ route('campaigns.quests.destroy', [$campaign, $quest]) }}"
                                      method="POST" class="inline ml-4"
                                      onsubmit="return confirm('Delete this quest?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="text-red-600 hover:text-red-900 focus:outline-none focus:ring-2 focus:ring-red-300 font-medium">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- Mobile Cards --}}
    <div class="sm:hidden space-y-4">
        @foreach($campaign->quests as $quest)
            <div class="bg-white border border-gray-200 shadow p-4 rounded-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">{{ $quest->title }}</h2>
                        <p class="text-sm text-gray-700">Status: {{ ucfirst($quest->status) }}</p>
                    </div>
                    <a href="{{ route('campaigns.quests.show', [$campaign, $quest]) }}"
                       class="text-purple-600 hover:text-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-300 font-medium">
                        View
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@else
    <x-empty-state
        icon="🗺️"
        title="No quests yet"
        message="Start your adventure by creating the first quest."
    >
        <a href="{{ route('campaigns.quests.create', $campaign) }}"
           class="mt-3 inline-flex items-center px-3 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm rounded">
            Add quest
        </a>
    </x-empty-state>
@endif
