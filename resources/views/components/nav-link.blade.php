@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-1 border-b-2 h-24 border-purple-800 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-purple-900 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-1 border-b-2 h-24 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-100 hover:text-gray-700 dark:hover:text-amber-400 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-700 dark:focus:text-gray-200 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
