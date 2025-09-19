@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Campaigns</h1>

        @if ($campaigns->count())
            <ul>
                @foreach ($campaigns as $campaign)
                    <li>
                        <a href="{{ route('campaigns.show', $campaign) }}">
                            {{ $campaign->name }}
                        </a>
                    </li>
                @endforeach
            </ul>

            {{ $campaigns->links() }}
        @else
            <p>No campaigns found.</p>
        @endif
    </div>
@endsection
