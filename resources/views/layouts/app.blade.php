<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechBuy') }} - Modern Tech E-Commerce</title>

    <!-- Meta tags for tech theme -->
    <meta name="description" content="TechBuy - Your destination for cutting-edge technology and gadgets">
    <meta name="theme-color" content="#0ea5e9">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-dark-gradient min-h-screen text-white">
    <div class="matrix-bg">
        <x-banner />

        <div class="min-h-screen bg-dark-gradient relative">
            <!-- Tech grid overlay -->
            <div class="absolute inset-0 tech-grid-bg opacity-20 pointer-events-none"></div>
            
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
            <header class="glass-panel backdrop-blur-xl shadow-tech border-white/10 relative z-10">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endif

            @hasSection('header')
            <header class="glass-panel backdrop-blur-xl shadow-tech border-white/10 relative z-10">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    @yield('header')
                </div>
            </header>
            @endif

            <!-- Page Content -->
            <main class="relative z-10">
                @if(isset($slot))
                {{ $slot }}
                @else
                @yield('content')
                @endif
            </main>
        </div>
    </div>

    @stack('modals')

    @livewireScripts
</body>

</html>