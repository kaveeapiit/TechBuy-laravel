<div>
    @if(count($cartItems) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-secondary-100">
                <div class="p-6 border-b border-secondary-200">
                    <h2 class="text-lg font-semibold text-secondary-900">Cart Items ({{ count($cartItems) }})</h2>
                </div>

                <div class="divide-y divide-secondary-200">
                    @foreach($cartItems as $item)
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 bg-secondary-100 rounded-lg flex items-center justify-center text-2xl">
                                    @if(isset($item['product']) && str_contains(strtolower($item['product']['name']), 'iphone'))
                                    📱
                                    @elseif(isset($item['product']) && str_contains(strtolower($item['product']['name']), 'macbook'))
                                    💻
                                    @elseif(isset($item['product']) && (str_contains(strtolower($item['product']['name']), 'samsung') || str_contains(strtolower($item['product']['name']), 'pixel')))
                                    📱
                                    @else
                                    💻
                                    @endif
                                </div>
                            </div>

                            <!-- Product Info -->
                            <div class="flex-1">
                                <h3 class="font-medium text-secondary-900">
                                    {{ $item['product']['name'] ?? 'Product' }}
                                </h3>
                                <p class="text-sm text-secondary-500">
                                    SKU: {{ $item['product']['sku'] ?? 'N/A' }}
                                </p>
                                <p class="text-lg font-semibold text-secondary-900">
                                    ${{ number_format($item['price'], 2) }}
                                </p>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="flex items-center space-x-2">
                                <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                    class="p-1 text-secondary-400 hover:text-primary-600 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span class="w-12 text-center">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                    class="p-1 text-secondary-400 hover:text-primary-600 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-right">
                                <p class="font-semibold text-secondary-900">
                                    ${{ number_format($item['quantity'] * $item['price'], 2) }}
                                </p>
                                <button wire:click="removeItem({{ $item['id'] }})"
                                    class="text-sm text-danger-600 hover:text-danger-800 mt-1 transition duration-200">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="p-6 border-t border-secondary-200">
                    <button wire:click="clearCart"
                        class="text-danger-600 hover:text-danger-800 text-sm font-medium transition duration-200">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                <h2 class="text-lg font-semibold text-secondary-900 mb-6">Order Summary</h2>

                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-secondary-600">Subtotal</span>
                        <span class="font-medium text-secondary-900">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary-600">Shipping</span>
                        <span class="font-medium text-success-600">Free</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-secondary-600">Tax</span>
                        <span class="font-medium text-secondary-900">${{ number_format($total * 0.08, 2) }}</span>
                    </div>
                    <div class="border-t border-secondary-200 pt-4">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-secondary-900">Total</span>
                            <span class="text-lg font-semibold text-secondary-900">${{ number_format($total * 1.08, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    <a href="{{ route('checkout') }}"
                        class="block w-full text-center bg-gradient-to-r from-primary-600 to-accent-600 text-white py-3 px-4 rounded-lg font-semibold hover:from-primary-700 hover:to-accent-700 transition duration-300 transform hover:scale-[1.02]">
                        Proceed to Checkout
                    </a>
                    <a href="{{ route('products') }}"
                        class="block w-full text-center bg-secondary-100 text-secondary-800 py-3 px-4 rounded-lg font-medium hover:bg-secondary-200 transition duration-300">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    </div>
    @else
    <!-- Empty Cart -->
    <div class="text-center py-16">
        <div class="text-8xl mb-6">🛒</div>
        <h2 class="text-2xl font-semibold text-secondary-900 mb-4">Your cart is empty</h2>
        <p class="text-secondary-600 mb-8">Start shopping to add items to your cart</p>
        <a href="{{ route('products') }}"
            class="inline-block bg-gradient-to-r from-primary-600 to-accent-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-primary-700 hover:to-accent-700 transition duration-300 transform hover:scale-[1.02]">
            Start Shopping
        </a>
    </div>
    @endif
</div>