@if($campaign->quests->count())
    <ul class="space-y-2">
        @foreach($campaign->quests as $quest)
            <li class="flex items-center justify-between">
                <span class="text-gray-800">{{ $quest->title }}</span>
                <span class="text-xs text-gray-500">{{ ucfirst($quest->status) }}</span>
            </li>
        @endforeach
    </ul>
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
