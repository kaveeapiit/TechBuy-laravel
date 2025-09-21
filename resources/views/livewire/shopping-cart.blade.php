<div>
    @if(count($cartItems) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2">
            <div class="tech-card">
                <div class="p-6 border-b border-primary-700/30">
                    <h2 class="text-lg font-semibold text-white font-orbitron">Cart Items ({{ count($cartItems) }})</h2>
                </div>

                <div class="divide-y divide-primary-700/30">
                    @foreach($cartItems as $item)
                    <div class="p-6">
                        <div class="flex items-center space-x-4">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center text-2xl border border-primary-700/30">
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
                                <h3 class="font-medium text-white">
                                    {{ $item['product']['name'] ?? 'Product' }}
                                </h3>
                                <p class="text-sm text-gray-400">
                                    SKU: {{ $item['product']['sku'] ?? 'N/A' }}
                                </p>
                                <p class="text-lg font-semibold text-primary-400 font-jetbrains">
                                    ${{ number_format($item['price'], 2) }}
                                </p>
                            </div>

                            <!-- Quantity Controls -->
                            <div class="flex items-center space-x-2">
                                <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] - 1 }})"
                                    class="p-1 text-gray-400 hover:text-primary-400 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                    </svg>
                                </button>
                                <span class="w-12 text-center text-white font-jetbrains">{{ $item['quantity'] }}</span>
                                <button wire:click="updateQuantity({{ $item['id'] }}, {{ $item['quantity'] + 1 }})"
                                    class="p-1 text-gray-400 hover:text-primary-400 transition duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Subtotal -->
                            <div class="text-right">
                                <p class="font-semibold text-white font-jetbrains">
                                    ${{ number_format($item['quantity'] * $item['price'], 2) }}
                                </p>
                                <button wire:click="removeItem({{ $item['id'] }})"
                                    class="text-sm text-accent-400 hover:text-accent-300 mt-1 transition duration-200">
                                    Remove
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="p-6 border-t border-primary-700/30">
                    <button wire:click="clearCart"
                        class="text-accent-400 hover:text-accent-300 text-sm font-medium transition duration-200">
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="lg:col-span-1">
            <div class="tech-card p-6">
                <h2 class="text-lg font-semibold text-white mb-6 font-orbitron">Order Summary</h2>

                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="font-medium text-white font-jetbrains">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Shipping</span>
                        <span class="font-medium text-secondary-400">Free</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Tax</span>
                        <span class="font-medium text-white font-jetbrains">${{ number_format($total * 0.08, 2) }}</span>
                    </div>
                    <div class="border-t border-primary-700/30 pt-4">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-white font-orbitron">Total</span>
                            <span class="text-lg font-semibold text-primary-400 font-jetbrains">${{ number_format($total * 1.08, 2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-6 space-y-3">
                    <a href="{{ route('checkout') }}"
                        class="tech-button block w-full text-center group">
                        <span class="group-hover:scale-105 transition-transform duration-300">
                            Proceed to Checkout
                        </span>
                    </a>
                    <a href="{{ route('products') }}"
                        class="block w-full text-center bg-gray-800/50 text-gray-300 py-3 px-4 rounded-lg font-medium hover:bg-gray-700/50 hover:text-white transition duration-300 backdrop-blur-sm border border-primary-700/30">
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
        <h2 class="text-2xl font-semibold text-white mb-4 font-orbitron">Your cart is empty</h2>
        <p class="text-gray-400 mb-8">Start shopping to add items to your cart</p>
        <a href="{{ route('products') }}"
            class="tech-button inline-block group">
            <span class="group-hover:scale-105 transition-transform duration-300">
                Start Shopping
            </span>
        </a>
    </div>
    @endif
</div>