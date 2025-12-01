<!-- layouts/app.blade.php -->
<html class="dark">
<head>
    <title>Campaign Compendium</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 font-sans flex flex-col min-h-screen">
    @include('layouts.navigation')

    @hasSection('hero')
        @yield('hero')
    @endif

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <footer class="bg-white border-t mt-12 py-6 text-center text-gray-500">
        © {{ date('Y') }} Campaign Compendium. All rights reserved.
    </footer>
</body>
</html>
