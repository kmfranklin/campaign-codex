@foreach (['success' => 'green', 'error' => 'red', 'warning' => 'yellow', 'info' => 'blue'] as $type => $color)
    @if(session()->has($type))
        <div
            x-data="{ show: true }"
            x-show="show"
            x-transition
            class="mb-4 flex items-center justify-between rounded border border-{{ $color }}-300 bg-{{ $color }}-100 px-4 py-2 text-{{ $color }}-800"
        >
            <span>{{ session($type) }}</span>
            <button
                @click="show = false"
                class="ml-4 text-{{ $color }}-600 hover:text-{{ $color }}-900"
                aria-label="Dismiss"
            >
                &times;
            </button>
        </div>
    @endif
@endforeach
