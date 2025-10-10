@if($campaign->quests->count())
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-gray-500 uppercase tracking-wider">
                        Title
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium  text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs     font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($campaign->quests as $quest)
                    <tr>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            {{ $quest->title }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ ucfirst($quest->status) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-right">
                            <a href="{{ route('campaigns.quests.edit', [$campaign,  $quest]) }}"
                               class="text-purple-600 hover:text-purple-900     mr-3">Edit</a>
                            <form action="{{ route('campaigns.quests.destroy',  [$campaign, $quest]) }}"
                                  method="POST" class="inline"
                                  onsubmit="return confirm('Delete this quest?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600   hover:text-red-900">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
