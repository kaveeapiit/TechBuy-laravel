<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin Panel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles

    <!-- Additional admin form styles -->
    <style>
        /* Ensure form inputs have proper contrast */
        .admin-form input,
        .admin-form select,
        .admin-form textarea {
            background: rgba(255, 255, 255, 0.05) !important;
            color: white !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        .admin-form select option {
            background: #1f2937 !important;
            color: white !important;
        }

        .admin-form label {
            color: #d1d5db !important;
        }
    </style>
</head>

<body class="font-sans antialiased bg-gradient-to-br from-gray-900 via-black to-gray-800 min-h-screen">
    <x-banner />

    <div class="min-h-screen bg-gradient-to-br from-gray-900 via-black to-gray-800">
        @auth('admin')
        <x-admin-navigation-menu />
        @endauth

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white/5 backdrop-blur-sm border-b border-white/10 shadow-glow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main class="flex-1">
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>
