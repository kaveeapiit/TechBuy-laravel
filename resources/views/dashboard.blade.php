<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
                Welcome back, {{ Auth::user()->name }}!
            </h2>
            <div class="text-sm text-secondary-600">
                {{ now()->format('l, F j, Y') }}
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-primary-500 to-accent-500 rounded-2xl p-8 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-2xl font-bold mb-2">TechBuy Dashboard</h3>
                        <p class="text-primary-100">Discover the latest technology and manage your orders</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-24 h-24 bg-white/20 rounded-2xl flex items-center justify-center">
                            <span class="text-3xl font-bold">TB</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl p-6 shadow-sm border border-secondary-100">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Total Orders</p>
                            <p class="text-2xl font-bold text-secondary-900">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-secondary-100">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-accent-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Wishlist</p>
                            <p class="text-2xl font-bold text-secondary-900">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-secondary-100">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-success-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Completed</p>
                            <p class="text-2xl font-bold text-secondary-900">0</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-6 shadow-sm border border-secondary-100">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-warning-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Total Spent</p>
                            <p class="text-2xl font-bold text-secondary-900">$0</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Recent Orders -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-secondary-900">Recent Orders</h3>
                            <a href="#" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View all</a>
                        </div>

                        <div class="text-center py-12">
                            <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-secondary-900 mb-2">No orders yet</h4>
                            <p class="text-secondary-600 mb-6">Start shopping to see your orders here</p>
                            <a href="#" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-accent-600 text-white font-medium rounded-lg hover:from-primary-700 hover:to-accent-700 transition duration-200">
                                Browse Products
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions & Profile -->
                <div class="space-y-6">

                    <!-- Profile Summary -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                        <h3 class="text-lg font-semibold text-secondary-900 mb-4">Account Summary</h3>
                        <div class="space-y-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-accent-500 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-secondary-900">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-secondary-600">{{ Auth::user()->email }}</p>
                                </div>
                            </div>
                            <div class="border-t border-secondary-100 pt-4">
                                <p class="text-xs text-secondary-600">Member since</p>
                                <p class="text-sm font-medium text-secondary-900">{{ Auth::user()->created_at->format('F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                        <h3 class="text-lg font-semibold text-secondary-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-secondary-50 transition duration-200">
                                <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-secondary-700">Browse Products</span>
                            </a>

                            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-secondary-50 transition duration-200">
                                <div class="w-8 h-8 bg-accent-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-secondary-700">My Wishlist</span>
                            </a>

                            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-secondary-50 transition duration-200">
                                <div class="w-8 h-8 bg-success-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-secondary-700">Account Settings</span>
                            </a>

                            <a href="#" class="flex items-center p-3 rounded-lg hover:bg-secondary-50 transition duration-200">
                                <div class="w-8 h-8 bg-warning-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <span class="ml-3 text-sm font-medium text-secondary-700">Help & Support</span>
                            </a>
                        </div>
                    </div>

                    <!-- Featured Products -->
                    <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                        <h3 class="text-lg font-semibold text-secondary-900 mb-4">Featured Products</h3>
                        <div class="space-y-4">
                            <div class="text-center py-8">
                                <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    </svg>
                                </div>
                                <p class="text-sm text-secondary-600">Discover amazing tech products</p>
                                <a href="#" class="inline-block mt-3 text-primary-600 hover:text-primary-700 text-sm font-medium">
                                    View all products
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>