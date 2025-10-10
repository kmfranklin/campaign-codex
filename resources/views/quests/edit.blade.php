@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded-lg p-6">
    <a href="{{ route('campaigns.show', $campaign) }}"
       class="inline-flex items-center text-sm text-purple-800 hover:text-purple-900 mb-4 font-medium">
      <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none"
           viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 19l-7-7 7-7"/>
      </svg>
      Back to Campaign
    </a>

    <h1 class="text-2xl font-bold mb-6">Edit Quest</h1>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-300 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('campaigns.quests.update', [$campaign, $quest]) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Title --}}
        <div class="mb-4">
            <label for="title" class="block text-sm font-medium text-gray-700">Quest Title</label>
            <input type="text" name="title" id="title"
                   value="{{ old('title', $quest->title) }}"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                          focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                   required>
        </div>

        {{-- Description --}}
        <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="description" rows="4"
                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                             focus:border-purple-500 focus:ring-purple-500 sm:text-sm">{{ old('description', $quest->description) }}</textarea>
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm
                           focus:border-purple-500 focus:ring-purple-500 sm:text-sm"
                    required>
                <option value="planned" @selected(old('status', $quest->status) === 'planned')>Planned</option>
                <option value="active" @selected(old('status', $quest->status) === 'active')>Active</option>
                <option value="completed" @selected(old('status', $quest->status) === 'completed')>Completed</option>
            </select>
        </div>

        {{-- Actions --}}
        <div class="pt-4 border-t flex justify-between">
            <a href="{{ route('campaigns.quests.show', [$campaign, $quest]) }}"
               class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">
                Cancel
            </a>
            <button type="submit"
                    class="px-6 py-2 bg-purple-800 text-white font-semibold rounded
                           hover:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-purple-500">
                Update Quest
            </button>
        </div>
    </form>
</div>
@endsection
