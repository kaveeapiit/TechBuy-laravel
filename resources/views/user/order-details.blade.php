<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                Order #{{ $order->order_number }}
            </h2>
            <a href="{{ route('user.orders') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                Back to Orders
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Summary -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Summary</h3>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Order Number</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->order_number }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Order Date</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->created_at->format('F j, Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Order Status</p>
                                    <div>
                                        @if($order->status === 'confirmed')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                                            Confirmed
                                        </span>
                                        @elseif($order->status === 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-full">
                                            Pending
                                        </span>
                                        @elseif($order->status === 'cancelled')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                                            Cancelled
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <p class="text-gray-600 dark:text-gray-400">Payment Status</p>
                                    <div>
                                        @if($order->payment_status === 'completed')
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                            Paid
                                        </span>
                                        @elseif($order->payment_status === 'pending')
                                        <span class="px-2 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded-full">
                                            Payment Pending
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Items</h3>
                            <div class="space-y-4">
                                @foreach($order->items as $item)
                                <div class="flex items-center space-x-4 py-4 border-b border-gray-200 dark:border-gray-700 last:border-b-0">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 dark:text-gray-100">{{ $item->product_name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Quantity: {{ $item->quantity }}
                                        </p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            Unit Price: ${{ number_format($item->price, 2) }}
                                        </p>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">
                                            ${{ number_format($item->price * $item->quantity, 2) }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Totals & Actions -->
                <div class="space-y-6">
                    <!-- Order Totals -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Total</h3>
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Subtotal</span>
                                    <span class="text-gray-900 dark:text-gray-100">${{ number_format($order->items->sum(function($item) { return $item->price * $item->quantity; }), 2) }}</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Shipping</span>
                                    <span class="text-gray-900 dark:text-gray-100">Free</span>
                                </div>
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600 dark:text-gray-400">Tax</span>
                                    <span class="text-gray-900 dark:text-gray-100">$0.00</span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-2">
                                    <div class="flex justify-between font-semibold text-lg">
                                        <span class="text-gray-900 dark:text-gray-100">Total</span>
                                        <span class="text-gray-900 dark:text-gray-100">${{ number_format($order->total_amount, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Customer Information</h3>
                            <div class="space-y-2">
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Name</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->user_name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Email</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $order->user_email }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    @if($order->shipping_address)
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Shipping Address</h3>
                            <div class="text-sm text-gray-900 dark:text-gray-100">
                                {!! nl2br(e($order->shipping_address)) !!}
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Actions -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Actions</h3>
                            <div class="space-y-3">
                                @if($order->status !== 'cancelled' && $order->payment_status === 'pending')
                                <button class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Complete Payment
                                </button>
                                @endif

                                @if($order->status === 'confirmed')
                                <button class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Track Order
                                </button>
                                @endif

                                <button onclick="window.print()" class="w-full px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                                    Print Order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
