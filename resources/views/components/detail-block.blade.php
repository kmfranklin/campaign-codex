@props([
    'title',
    'index' => 0,
])

@php
    $bg = $index % 2 === 0 ? 'white' : 'gray-50';
@endphp

<div class="p-6 bg-{{ $bg }} border-b border-gray-200">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">{{ $title }}</h2>
    {{ $slot }}
</div>
