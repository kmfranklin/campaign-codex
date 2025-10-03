@props([
    'title',
    'index' => null,
    'last' => false,
])

<div @class([
    'px-6 py-4',
    'border-b border-gray-200' => !$last,
])>
    <div class="flex items-center justify-between mb-3">
        <h2 class="text-lg font-semibold text-gray-800">
            {{ $title }}
        </h2>

        @isset($actions)
            <div>
                {{ $actions }}
            </div>
        @endisset
    </div>

    <div>
        {{ $slot }}
    </div>
</div>
