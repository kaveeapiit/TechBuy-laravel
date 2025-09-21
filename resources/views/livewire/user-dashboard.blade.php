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
                        <p class="text-2xl font-bold text-secondary-900">{{ $totalOrders }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-secondary-100">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-accent-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 9.5M15 7l-1.5 9.5"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-secondary-600">Cart Items</p>
                        <p class="text-2xl font-bold text-secondary-900">{{ $cartItemCount }}</p>
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
                        <p class="text-2xl font-bold text-secondary-900">{{ $completedOrders }}</p>
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
                        <p class="text-2xl font-bold text-secondary-900">${{ number_format($totalSpent, 2) }}</p>
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
                        @if(count($recentOrders) > 0)
                        <a href="#" class="text-primary-600 hover:text-primary-700 text-sm font-medium">View all</a>
                        @endif
                    </div>

                    @if(count($recentOrders) > 0)
                    <div class="space-y-4">
                        @foreach($recentOrders as $order)
                        <div class="border border-secondary-200 rounded-lg p-4 hover:bg-secondary-50 transition duration-200">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-primary-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-medium text-secondary-900">{{ $order['order_number'] }}</p>
                                        <p class="text-sm text-secondary-600">{{ \Carbon\Carbon::parse($order['created_at'])->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-semibold text-secondary-900">${{ number_format($order['total_amount'], 2) }}</p>
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                                @if($order['status'] === 'confirmed') bg-success-100 text-success-800
                                                @elseif($order['status'] === 'pending') bg-warning-100 text-warning-800
                                                @else bg-secondary-100 text-secondary-800 @endif">
                                        {{ ucfirst($order['status']) }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-sm text-secondary-600">
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
                        <div class="w-16 h-16 bg-secondary-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <h4 class="text-lg font-medium text-secondary-900 mb-2">No orders yet</h4>
                        <p class="text-secondary-600 mb-6">Start shopping to see your orders here</p>
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-accent-600 text-white font-medium rounded-lg hover:from-primary-700 hover:to-accent-700 transition duration-200">
                            Browse Products
                        </a>
                    </div>
                    @endif
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
                        <a href="{{ route('home') }}" class="flex items-center p-3 rounded-lg hover:bg-secondary-50 transition duration-200">
                            <div class="w-8 h-8 bg-primary-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <span class="ml-3 text-sm font-medium text-secondary-700">Browse Products</span>
                        </a>

                        <a href="{{ route('cart') }}" class="flex items-center p-3 rounded-lg hover:bg-secondary-50 transition duration-200">
                            <div class="w-8 h-8 bg-accent-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-accent-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 9.5M15 7l-1.5 9.5"></path>
                                </svg>
                            </div>
                            <span class="ml-3 text-sm font-medium text-secondary-700">My Cart ({{ $cartItemCount }})</span>
                        </a>

                        <a href="{{ route('profile.show') }}" class="flex items-center p-3 rounded-lg hover:bg-secondary-50 transition duration-200">
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