@if($campaign->members->count())
    <ul class="space-y-2">
        @foreach($campaign->members as $member)
            <li class="flex items-center justify-between">
                <span class="text-gray-800">{{ $member->name }}</span>
                @php
                    $role = $member->pivot->role === 'dm' ? 'DM' : ucfirst($member->pivot->role);
                @endphp
                <span class="text-xs text-gray-500">{{ $role }}</span>
            </li>
        @endforeach
    </ul>
@else
    <x-empty-state
        icon="👥"
        title="No members yet"
        message="Invite players to join your campaign."
    />
@endif
