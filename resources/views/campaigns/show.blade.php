@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $campaign->name }}</h1>

    @if ($campaign->description)
        <p>{{ $campaign->description }}</p>
    @endif

    <h3>Members</h3>
    @if ($campaign->members->count())
        <ul>
            @foreach ($campaign->members as $member)
                <li>
                    {{ $member->name }}
                    @if ($member->pivot && $member->pivot->role)
                        <small>({{ ucfirst($member->pivot->role) }})</small>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <p>No members yet.</p>
    @endif

    <a href="{{ route('campaigns.index') }}" class="btn btn-secondary mt-3">Back to Campaigns</a>
</div>
@endsection
