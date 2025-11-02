@extends('layouts.app')

@php
    $origin = request('from');

    $backRoute = match($origin) {
        'custom' => route('customItems.index'),
        'srd' => route('srdItems.index'),
        default => route('items.index'),
    };
@endphp

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
    {{-- Back link --}}
    <a href="{{ $backRoute }}"
       class="inline-flex items-center text-sm text-purple-800 hover:text-purple-900 mb-4 font-medium">
        <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 19l-7-7 7-7"/>
        </svg>
        Back to Items
    </a>

    <div class="flex items-start">
        <div>
            <h1 class="text-2xl font-bold mb-6">Edit Item</h1>
        </div>

        <div class="ml-auto flex">
            @can('delete', $item)
                <form action="{{ route('items.destroy', $item) }}" method="POST" onsubmit="return confirm('Delete this item? This action cannot be undone.');" class="inline ml-3">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="from" value="{{ $origin }}">
                    <button type="submit" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded">
                        Delete
                    </button>
                </form>
            @endcan
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('items.update', $item) }}">
        @csrf
        @method('PATCH')

        <input type="hidden" name="from" value="{{ $origin }}">

        @include('items.partials.form')

        <div class="pt-4 border-t flex justify-between">
            {{-- Cancel button --}}
            <a href="{{ $backRoute }}" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                Cancel
            </a>

            <div class="flex items-center">
                <button type="submit"
                        class="px-6 py-2 bg-purple-800 text-white font-semibold rounded hover:bg-purple-900
                               focus:outline-none focus:ring-2 focus:ring-purple-500">
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>
@endsection
