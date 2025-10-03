@if(isset($campaign->npcs) && $campaign->npcs->count())
    <ul class="space-y-2">
        @foreach($campaign->npcs as $npc)
            <li class="text-gray-800">{{ $npc->name }}</li>
        @endforeach
    </ul>
@else
    <x-empty-state
        icon="🧙"
        title="No NPCs yet"
        message="Bring your world to life by adding characters."
    />
@endif
