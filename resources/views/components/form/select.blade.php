@props([
    'name',
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => null,
])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $name }}"
        {{ $attributes->merge(['class' => 'mt-1 block w-full border-gray-300 rounded-md shadow-sm']) }}
    >
        @if($placeholder)
            <option value="" disabled {{ old($name, $selected) === null ? 'selected' : '' }}>
                {{ $placeholder }}
            </option>
        @endif

        @foreach($options as $option)
            <option value="{{ $option }}" @selected(old($name, $selected) === $option)>
                {{ $option }}
            </option>
        @endforeach
    </select>
</div>
