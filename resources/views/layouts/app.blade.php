<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Campaign Codex') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-gray-50 text-gray-900">
    <header class="bg-white border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="text-lg font-bold">
                        Campaign Codex
                    </a>
                </div>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="hover:text-indigo-600">Dashboard</a>
                    <a href="#" class="hover:text-indigo-600">Compendium</a>
                    <a href="#" class="hover:text-indigo-600">Settings</a>
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="hover:text-red-600">Logout</button>
                        </form>
                    @endauth
                </nav>

                <!-- Mobile Menu Button -->
                <div class="flex items-center md:hidden" x-data="{ open: false }">
                    <button @click="open = !open" type="button" class="p-2 rounded-md text-gray-500 hover:text-gray-700 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Mobile Nav -->
                    <div x-show="open" class="absolute top-16 left-0 w-full bg-white border-t md:hidden">
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Dashboard</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Compendium</a>
                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">Settings</a>
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="px-4 py-2">
                                @csrf
                                <button type="submit" class="w-full text-left hover:text-red-600">Logout</button>
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6">
        {{ $slot ?? '' }}
    </main>

    <footer class="bg-white border-t py-4 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} Campaign Codex. All rights reserved.
    </footer>
</body>
</html>
