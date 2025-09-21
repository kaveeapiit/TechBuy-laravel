<div class="py-8 px-4">
    <div class="max-w-7xl mx-auto">

        <!-- Welcome Section -->
        <div class="bg-tech-gradient rounded-3xl p-8 mb-8 text-white relative overflow-hidden shadow-tech">
            <!-- Animated background -->
            <div class="absolute inset-0 bg-gradient-to-r from-primary-600/20 to-accent-600/20 animate-pulse-slow"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold font-display mb-3 text-glow">TechBuy Dashboard</h3>
                        <p class="text-white/80 font-medium">Explore cutting-edge technology and manage your digital lifestyle</p>
                    </div>
                    <div class="hidden md:block">
                        <div class="w-28 h-28 glass-panel rounded-3xl flex items-center justify-center floating-element">
                            <span class="text-4xl font-bold font-display neon-text">TB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="tech-card p-6 glow-on-hover">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-gradient-to-br from-primary-500 to-primary-600 rounded-2xl flex items-center justify-center shadow-glow">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Total Orders</p>
                        <p class="text-3xl font-bold text-white font-mono">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="tech-card p-6 glow-on-hover">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center shadow-glow">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 9.5M15 7l-1.5 9.5"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Cart Items</p>
                        <p class="text-3xl font-bold text-white font-mono">{{ $cartItemCount }}</p>
                    </div>
                </div>
            </div>

            <div class="tech-card p-6 glow-on-hover">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-gradient-to-br from-tech-500 to-tech-600 rounded-2xl flex items-center justify-center shadow-glow">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Completed</p>
                        <p class="text-3xl font-bold text-white font-mono">{{ $completedOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="tech-card p-6 glow-on-hover">
                <div class="flex items-center">
                    <div class="w-14 h-14 bg-gradient-to-br from-neon-500 to-neon-600 rounded-2xl flex items-center justify-center shadow-glow">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Total Spent</p>
                        <p class="text-3xl font-bold text-white font-mono">${{ number_format($totalSpent, 2) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Recent Orders -->
            <div class="lg:col-span-2">
                <div class="tech-card p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-white font-display">Recent Orders</h3>
                        @if(count($recentOrders) > 0)
                        <a href="#" class="text-primary-400 hover:text-primary-300 text-sm font-medium glow-on-hover">View all</a>
                        @endif
                    </div>

                    @if(count($recentOrders) > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                        <div class="glass-panel border border-white/10 rounded-2xl p-4 hover:bg-white/5 transition-all duration-300 glow-on-hover">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-glow">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-white font-mono">{{ $order['order_number'] }}</p>
                                        <p class="text-sm text-gray-400">{{ \Carbon\Carbon::parse($order['created_at'])->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-white font-mono">${{ number_format($order['total_amount'], 2) }}</p>
                                    <span class="status-badge
                                                @if($order['status'] === 'confirmed') status-confirmed
                                                @elseif($order['status'] === 'pending') status-pending
                                                @else status-failed @endif">
                                        {{ ucfirst($order['status']) }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-sm text-gray-400">
                                {{ count($order['items']) }} {{ count($order['items']) == 1 ? 'item' : 'items' }}
                                @if(count($order['items']) > 0)
                                - {{ $order['items'][0]['product_name'] }}@if(count($order['items']) > 1) and {{ count($order['items']) - 1 }} more @endif
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-20 h-20 glass-panel rounded-full flex items-center justify-center mx-auto mb-4 floating-element">
                            <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-medium text-white mb-2 font-display">No orders yet</h4>
                        <p class="text-gray-400 mb-6">Start shopping to see your orders here</p>
                        <a href="{{ route('home') }}" class="tech-button">
                            Browse Products
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions & Profile -->
            <div class="space-y-6">

                <!-- Profile Summary -->
                <div class="tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 font-display">Account Summary</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-r from-primary-500 to-accent-500 rounded-xl flex items-center justify-center shadow-glow">
                                <span class="text-white font-bold text-lg font-display">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-4">
                                <p class="text-base font-medium text-white">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-400">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <div class="border-t border-white/10 pt-4">
                            <p class="text-xs text-gray-500 uppercase tracking-wider">Member since</p>
                            <p class="text-sm font-medium text-white font-mono">{{ Auth::user()->created_at->format('F Y') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 font-display">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('home') }}" class="flex items-center p-3 rounded-xl hover:bg-white/5 transition-all duration-300 glow-on-hover group">
                            <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-300 group-hover:text-white transition-colors duration-300">Browse Products</span>
                        </a>

                        <a href="{{ route('cart') }}" class="flex items-center p-3 rounded-xl hover:bg-white/5 transition-all duration-300 glow-on-hover group">
                            <div class="w-10 h-10 bg-gradient-to-br from-accent-500 to-accent-600 rounded-xl flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 9.5M15 7l-1.5 9.5"></path>
                                </svg>
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-300 group-hover:text-white transition-colors duration-300">My Cart ({{ $cartItemCount }})</span>
                        </a>

                        <a href="{{ route('profile.show') }}" class="flex items-center p-3 rounded-xl hover:bg-white/5 transition-all duration-300 glow-on-hover group">
                            <div class="w-10 h-10 bg-gradient-to-br from-tech-500 to-tech-600 rounded-xl flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <span class="ml-3 text-sm font-medium text-gray-300 group-hover:text-white transition-colors duration-300">Account Settings</span>
                        </a> <!-- Featured Products -->
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
                                    <a href="{{ route('products') }}" class="inline-block mt-3 text-primary-600 hover:text-primary-700 text-sm font-medium">
                                        View all products
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>