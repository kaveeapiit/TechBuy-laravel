<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-dark">
    <div class="min-h-screen bg-gradient-to-br from-secondary-900 via-primary-900 to-accent-900">
        <!-- Admin Navigation -->
        @auth('admin')
        <nav class="glass-panel backdrop-blur-xl border-white/10 shadow-tech relative z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="shrink-0 flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                                <div class="w-10 h-10 bg-gradient-to-r from-red-500 to-orange-500 rounded-xl flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                                    <span class="text-white font-bold text-lg font-display">A</span>
                                </div>
                                <span class="text-2xl font-bold font-display neon-text">Admin Panel</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                            <a href="{{ route('admin.dashboard') }}"
                                class="nav-link {{ request()->routeIs('admin.dashboard') ? 'border-primary-400 text-primary-400' : 'border-transparent text-gray-300 hover:text-primary-400 hover:border-primary-400' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300">
                                {{ __('Dashboard') }}
                            </a>
                            <a href="{{ route('admin.users.index') }}"
                                class="nav-link {{ request()->routeIs('admin.users.*') ? 'border-primary-400 text-primary-400' : 'border-transparent text-gray-300 hover:text-primary-400 hover:border-primary-400' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300">
                                {{ __('Manage Users') }}
                            </a>
                            <a href="{{ route('admin.products.index') }}"
                                class="nav-link {{ request()->routeIs('admin.products.*') ? 'border-primary-400 text-primary-400' : 'border-transparent text-gray-300 hover:text-primary-400 hover:border-primary-400' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition-all duration-300">
                                {{ __('Manage Products') }}
                            </a>
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <!-- Admin Dropdown -->
                        <div class="ms-3 relative">
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = ! open" class="flex items-center text-sm text-gray-300 hover:text-white transition-colors">
                                    <div class="w-8 h-8 bg-gradient-to-r from-red-500 to-orange-500 rounded-lg flex items-center justify-center mr-3">
                                        <span class="text-white font-semibold text-sm">{{ substr(Auth::guard('admin')->user()->name, 0, 1) }}</span>
                                    </div>
                                    <span class="font-medium">{{ Auth::guard('admin')->user()->name }}</span>
                                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                                    <div class="py-1">
                                        <div class="px-4 py-2 text-xs text-gray-400 border-b">
                                            {{ Auth::guard('admin')->user()->role }}
                                        </div>
                                        <form method="POST" action="{{ route('admin.logout') }}">
                                            @csrf
                                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                                Logout
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @endauth

        <!-- Page Heading -->
        @isset($header)
        <header class="bg-white/5 backdrop-blur-sm shadow border-b border-white/10">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('scripts')
</body>

</html>
