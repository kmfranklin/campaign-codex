@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-900">Create quest</h1>
    <p class="text-sm text-gray-600 mt-1">Campaign: {{ $campaign->name }}</p>

    <form method="POST" action="{{ route('campaigns.quests.store', $campaign) }}" class="mt-6 space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
            <input
                type="text"
                name="title"
                id="title"
                value="{{ old('title') }}"
                class="mt-1 block w-full rounded border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                required
            >
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea
                name="description"
                id="description"
                rows="4"
                class="mt-1 block w-full rounded border-gray-300 focus:border-purple-500 focus:ring-purple-500"
            >{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select
                name="status"
                id="status"
                class="mt-1 block w-full rounded border-gray-300 focus:border-purple-500 focus:ring-purple-500"
                required
            >
                <option value="planned" @selected(old('status') === 'planned')>Planned</option>
                <option value="active" @selected(old('status', 'planned') === 'active')>Active</option>
                <option value="completed" @selected(old('status') === 'completed')>Completed</option>
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded">
                Save quest
            </button>
            <a href="{{ route('campaigns.show', $campaign) }}" class="text-sm text-gray-600 hover:text-gray-800">
                Cancel
            </a>
        </div>
    </form>
</div>
@endsection
