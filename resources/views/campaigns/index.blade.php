@extends('layouts.app')

@section('content')
<div class="px-4 sm:px-6 lg:px-8">
    <div class="sm:flex sm:items-center sm:justify-between py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Campaigns</h1>
        <a href="{{ route('campaigns.create') }}"
           class="inline-flex items-center px-4 py-2 bg-purple-800 hover:bg-purple-900 text-white text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-300">
            + New Campaign
        </a>
    </div>

    {{-- Results Table + Mobile Cards --}}
    @include('campaigns.partials.results', ['campaigns' => $campaigns])
</div>
@endsection
