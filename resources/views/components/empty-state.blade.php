@props([
    'icon'        => '📄',
    'title'       => 'Nothing here yet',
    'message'     => null,
    'action'      => null,
    'actionLabel' => null,
])

<div class="flex flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-white py-10 px-6 text-center">
    <div class="text-4xl mb-3">{{ $icon }}</div>
    <h3 class="text-lg font-medium text-gray-900">{{ $title }}</h3>
    @if($message)
        <p class="mt-1 text-sm text-gray-500">{{ $message }}</p>
    @endif

    @if($action && $actionLabel)
        <div class="mt-4">
            <a href="{{ $action }}"
               class="inline-flex items-center rounded-md bg-purple-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                {{ $actionLabel }}
            </a>
        </div>
    @endif
</div>
