<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TechBuy') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body>
    <div class="min-h-screen bg-dark-gradient matrix-bg font-sans text-white antialiased relative overflow-hidden">
        <!-- Animated background elements -->
        <div class="absolute inset-0 tech-grid-bg opacity-30"></div>
        
        <!-- Floating tech elements -->
        <div class="absolute top-10 left-10 w-20 h-20 bg-primary-500/20 rounded-full blur-xl floating-element"></div>
        <div class="absolute top-32 right-20 w-16 h-16 bg-accent-500/20 rounded-full blur-xl floating-element" style="animation-delay: -1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-24 h-24 bg-tech-500/20 rounded-full blur-xl floating-element" style="animation-delay: -2s;"></div>
        <div class="absolute bottom-32 right-1/3 w-12 h-12 bg-neon-500/20 rounded-full blur-xl floating-element" style="animation-delay: -3s;"></div>
        
        <!-- Main content -->
        <div class="relative z-10 flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-6 py-8 glass-panel shadow-tech overflow-hidden">
                {{ $slot }}
            </div>
        </div>
    </div>

    @livewireScripts
</body>

</html>