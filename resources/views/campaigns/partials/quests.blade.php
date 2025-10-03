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
