<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                Order History
            </h2>
            <a href="{{ route('user.profile') }}"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition-colors">
                Back to Profile
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($orders->count() > 0)
            <div class="space-y-6">
                @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    Order #{{ $order->order_number }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center space-x-2 mb-2">
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
                                <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    ${{ number_format($order->total_amount, 2) }}
                                </p>
                            </div>
                        </div>

                        <!-- Order Items Preview -->
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @foreach($order->items->take(3) as $item)
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center">
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                            {{ $item->product_name }}
                                        </p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach

                                @if($order->items->count() > 3)
                                <div class="flex items-center justify-center">
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        +{{ $order->items->count() - 3 }} more items
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-end mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('user.order-details', $order->order_number) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $orders->links() }}
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-12 text-center">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">No Orders Yet</h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        You haven't placed any orders yet. Start shopping to see your order history here.
                    </p>
                    <a href="{{ route('products') }}"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                        Start Shopping
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
