<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                Admin Dashboard
            </h2>
            <div class="text-sm text-gray-400 font-mono">
                Welcome back, {{ Auth::guard('admin')->user()->name }}!
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-7xl mx-auto">

            <!-- Success Message -->
            @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Users -->
                <div class="tech-card p-6 glow-on-hover">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-glow">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Total Users</p>
                            <p class="text-3xl font-bold text-white font-mono">{{ number_format($stats['total_users']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Products -->
                <div class="tech-card p-6 glow-on-hover">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center shadow-glow">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Total Products</p>
                            <p class="text-3xl font-bold text-white font-mono">{{ number_format($stats['total_products']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Orders -->
                <div class="tech-card p-6 glow-on-hover">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-glow">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Total Orders</p>
                            <p class="text-3xl font-bold text-white font-mono">{{ number_format($stats['total_orders']) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="tech-card p-6 glow-on-hover">
                    <div class="flex items-center">
                        <div class="w-14 h-14 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center shadow-glow">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-400 uppercase tracking-wider">Total Revenue</p>
                            <p class="text-3xl font-bold text-white font-mono">${{ number_format($stats['total_revenue'], 2) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Management Actions -->
                <div class="tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-6 font-display">Quick Actions</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('admin.users.index') }}"
                            class="flex items-center p-4 rounded-xl hover:bg-white/5 transition-all duration-300 glow-on-hover group border border-white/10">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-white">Manage Users</p>
                                <p class="text-xs text-gray-400">View and manage all users</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.products.index') }}"
                            class="flex items-center p-4 rounded-xl hover:bg-white/5 transition-all duration-300 glow-on-hover group border border-white/10">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-white">Manage Products</p>
                                <p class="text-xs text-gray-400">Add, edit, and manage products</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.users.create') }}"
                            class="flex items-center p-4 rounded-xl hover:bg-white/5 transition-all duration-300 glow-on-hover group border border-white/10">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-white">Add User</p>
                                <p class="text-xs text-gray-400">Create a new user account</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.products.create') }}"
                            class="flex items-center p-4 rounded-xl hover:bg-white/5 transition-all duration-300 glow-on-hover group border border-white/10">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-white">Add Product</p>
                                <p class="text-xs text-gray-400">Create a new product</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-6 font-display">Recent Activity</h3>
                    <div class="space-y-4">
                        @if($stats['recent_orders']->count() > 0)
                        @foreach($stats['recent_orders'] as $order)
                        <div class="flex items-center p-3 rounded-lg bg-white/5 border border-white/10">
                            <div class="w-10 h-10 bg-gradient-to-r from-primary-500 to-accent-500 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-sm font-medium text-white">Order #{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-400">{{ $order->user->name ?? 'Guest' }} • ${{ number_format($order->total_amount, 2) }}</p>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $order->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="text-center py-8">
                            <p class="text-gray-400">No recent activity</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Recent Users -->
            @if($stats['recent_users']->count() > 0)
            <div class="tech-card p-6">
                <h3 class="text-xl font-semibold text-white mb-6 font-display">Recent Users</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach($stats['recent_users'] as $user)
                    <div class="flex items-center p-4 rounded-lg bg-white/5 border border-white/10">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg flex items-center justify-center">
                            <span class="text-white font-semibold text-sm">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3 flex-1 min-w-0">
                            <p class="text-sm font-medium text-white truncate">{{ $user->name }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $user->email }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
