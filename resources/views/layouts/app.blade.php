<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html-element">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- FAVICON LINK --}}
    <link rel="icon" href="{{ asset('blogging.png') }}">
    
    {{-- Page title - defaults to "Blog Platform" --}}
    <title>{{ $title ?? 'Blog Platform' }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    

    {{-- Vite compiles and includes Tailwind CSS and app.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script>
        // Check localStorage and system preference to set initial dark mode
        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.getElementById('html-element').classList.add('dark');
        }
    </script>
</head>
<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        {{-- Navigation Bar --}}
        @include('layouts.navigation')

        {{-- Page Header (optional) --}}
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-gray-900 dark:text-gray-100">
                    {{ $header }}
                </div>
            </header>
        @endisset

        {{-- Flash Messages (success/error) --}}
        @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-100 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 dark:bg-red-900 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-100 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif

        {{-- Main Content Area --}}
        <main>
            {{ $slot }}
        </main>
    </div>
</body>
</html>