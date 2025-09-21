<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'TechBuy - Premium Electronics Store')</title>
    <meta name="description" content="@yield('description', 'Shop the latest iPhones, MacBooks, Android phones, laptops and more at TechBuy. Premium electronics with great prices.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gradient-to-br from-black via-gray-900 to-black text-white min-h-screen">
    <!-- Tech Grid Background -->
    <div class="fixed inset-0 opacity-5 pointer-events-none">
        <div class="tech-grid"></div>
    </div>

    <!-- Header -->
    <header class="glass-panel border-primary-800/30 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Top bar -->
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="text-2xl font-bold font-display">
                        <span class="neon-text bg-gradient-to-r from-primary-400 to-accent-400 bg-clip-text text-transparent">Tech</span><span class="text-white">Buy</span>
                    </a>
                </div>

                <!-- Search -->
                <div class="flex-1 max-w-lg mx-8">
                    <div class="relative">
                        <input type="text" class="w-full px-4 py-2 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 backdrop-blur-sm text-white placeholder-gray-400 font-mono" placeholder="Search products...">
                        <button class="absolute right-3 top-2.5 text-gray-400 hover:text-primary-400 transition-colors duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Right side -->
                <div class="flex items-center space-x-4">
                    @auth
                    <!-- Cart -->
                    <a href="{{ route('cart') }}" class="relative p-2 text-gray-300 hover:text-primary-400 transition-colors duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 4M7 13v6a2 2 0 002 2h6a2 2 0 002-2v-6"></path>
                        </svg>
                        @livewire('cart-count')
                    </a>

                    <!-- User menu -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-gray-300 hover:text-primary-400 transition-colors duration-300 font-display">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-primary-400 transition-colors duration-300 font-display">Sign In</a>
                    <a href="{{ route('register') }}" class="tech-button">Sign Up</a>
                    @endauth
                </div>
            </div>

            <!-- Navigation -->
            <nav class="border-t border-primary-800/30 py-4">
                <div class="flex space-x-8">
                    <a href="{{ route('home') }}" class="text-white hover:text-primary-400 font-medium transition-colors duration-300 font-display">Home</a>
                    <a href="{{ route('products') }}" class="text-gray-300 hover:text-primary-400 transition-colors duration-300 font-display">All Products</a>
                    <a href="{{ route('category', 'iphones') }}" class="text-gray-300 hover:text-primary-400 transition-colors duration-300 font-display">iPhones</a>
                    <a href="{{ route('category', 'macbooks') }}" class="text-gray-300 hover:text-primary-400 transition-colors duration-300 font-display">MacBooks</a>
                    <a href="{{ route('category', 'android-phones') }}" class="text-gray-300 hover:text-primary-400 transition-colors duration-300 font-display">Android</a>
                    <a href="{{ route('category', 'laptops') }}" class="text-gray-300 hover:text-primary-400 transition-colors duration-300 font-display">Laptops</a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="relative z-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-t from-black to-gray-900 text-white mt-16 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4 font-display">
                        <span class="neon-text bg-gradient-to-r from-primary-400 to-accent-400 bg-clip-text text-transparent">Tech</span>Buy
                    </h3>
                    <p class="text-gray-400 font-mono">Your trusted partner for premium electronics and cutting-edge technology.</p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 font-display">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400 font-mono">
                        <li><a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors duration-300">Home</a></li>
                        <li><a href="{{ route('products') }}" class="hover:text-primary-400 transition-colors duration-300">Products</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors duration-300">About Us</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors duration-300">Contact</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 font-display">Categories</h4>
                    <ul class="space-y-2 text-gray-400 font-mono">
                        <li><a href="{{ route('category', 'iphones') }}" class="hover:text-primary-400 transition-colors duration-300">iPhones</a></li>
                        <li><a href="{{ route('category', 'macbooks') }}" class="hover:text-primary-400 transition-colors duration-300">MacBooks</a></li>
                        <li><a href="{{ route('category', 'android-phones') }}" class="hover:text-primary-400 transition-colors duration-300">Android Phones</a></li>
                        <li><a href="{{ route('category', 'laptops') }}" class="hover:text-primary-400 transition-colors duration-300">Laptops</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-lg font-semibold mb-4 font-display">Contact Info</h4>
                    <ul class="space-y-2 text-gray-400 font-mono">
                        <li class="flex items-center space-x-2">
                            <span class="text-primary-400">📧</span>
                            <span>info@techbuy.com</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-accent-400">📞</span>
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <span class="text-secondary-400">📍</span>
                            <span>123 Tech Street, Silicon Valley</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-primary-800/30 mt-8 pt-8 text-center text-gray-400">
                <p class="font-mono">&copy; {{ date('Y') }} TechBuy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>

</html>