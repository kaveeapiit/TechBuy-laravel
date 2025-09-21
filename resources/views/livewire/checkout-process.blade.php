<div>
    @if(session()->has('error'))
    <div class="mb-4 bg-accent-500/20 border border-accent-400/30 text-accent-300 px-4 py-3 rounded backdrop-blur-sm">
        {{ session('error') }}
    </div>
    @endif

    @if(empty($cartItems))
    <div class="text-center py-16">
        <div class="text-8xl mb-6">🛒</div>
        <h2 class="text-2xl font-semibold text-white mb-4 font-orbitron">Your cart is empty</h2>
        <p class="text-gray-400 mb-8">Add items to your cart before checking out</p>
        <a href="{{ route('home') }}"
            class="tech-button inline-block group">
            <span class="group-hover:scale-105 transition-transform duration-300">
                Continue Shopping
            </span>
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <form wire:submit.prevent="placeOrder" class="space-y-8">

                <!-- Shipping Information -->
                <div class="tech-card p-6">
                    <h3 class="text-lg font-semibold text-white mb-6 font-orbitron">Shipping Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">First Name</label>
                            <input type="text" wire:model="firstName"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('firstName') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Last Name</label>
                            <input type="text" wire:model="lastName"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('lastName') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                            <input type="email" wire:model="email"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('email') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Phone</label>
                            <input type="tel" wire:model="phone"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('phone') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Address</label>
                            <input type="text" wire:model="address"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('address') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">City</label>
                            <input type="text" wire:model="city"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('city') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">State</label>
                            <input type="text" wire:model="state"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('state') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">ZIP Code</label>
                            <input type="text" wire:model="zipCode"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('zipCode') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Country</label>
                            <select wire:model="country"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="tech-card p-6">
                    <h3 class="text-lg font-semibold text-white mb-6 font-orbitron">Payment Information</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-300 mb-4">Payment Method</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" wire:model="paymentMethod" value="card" class="text-primary-500 focus:ring-primary-500 bg-gray-800/50 border-primary-700/30">
                                <span class="ml-2 text-sm text-gray-300">Credit/Debit Card</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model="paymentMethod" value="paypal" class="text-primary-500 focus:ring-primary-500 bg-gray-800/50 border-primary-700/30">
                                <span class="ml-2 text-sm text-gray-300">PayPal</span>
                            </label>
                        </div>
                    </div>

                    @if($paymentMethod === 'card')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Card Number</label>
                            <input type="text" wire:model="cardNumber" placeholder="1234 5678 9012 3456"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('cardNumber') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Expiry Date</label>
                            <input type="text" wire:model="expiryDate" placeholder="MM/YY"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('expiryDate') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">CVV</label>
                            <input type="text" wire:model="cvv" placeholder="123"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('cvv') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-300 mb-2">Cardholder Name</label>
                            <input type="text" wire:model="cardName"
                                class="w-full px-4 py-3 bg-gray-800/50 border border-primary-700/30 rounded-lg text-white placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200 backdrop-blur-sm">
                            @error('cardName') <span class="text-accent-400 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Place Order Button -->
                <div class="tech-card p-6">
                    <button type="submit"
                        class="tech-button w-full group">
                        <span class="group-hover:scale-105 transition-transform duration-300">
                            Place Order - ${{ number_format($grandTotal, 2) }}
                        </span>
                    </button>

                    <p class="text-sm text-gray-400 text-center mt-4">
                        Your payment information is secure and encrypted
                    </p>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="tech-card p-6 sticky top-8">
                <h3 class="text-lg font-semibold text-white mb-6 font-orbitron">Order Summary</h3>

                <!-- Cart Items -->
                <div class="space-y-4 mb-6">
                    @foreach($cartItems as $item)
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center text-lg border border-primary-700/30">
                            @if(str_contains(strtolower($item['product']['name']), 'iphone'))
                            📱
                            @else
                            💻
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-white">{{ $item['product']['name'] }}</p>
                            <p class="text-xs text-gray-400">Qty: {{ $item['quantity'] }}</p>
                        </div>
                        <div class="text-sm font-semibold text-primary-400 font-jetbrains">
                            ${{ number_format($item['quantity'] * $item['price'], 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Totals -->
                <div class="space-y-2 border-t border-primary-700/30 pt-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="font-medium text-white font-jetbrains">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Shipping</span>
                        <span class="font-medium text-secondary-400">Free</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">Tax</span>
                        <span class="font-medium text-white font-jetbrains">${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="border-t border-primary-700/30 pt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-white font-orbitron">Total</span>
                            <span class="text-lg font-semibold text-primary-400 font-jetbrains">${{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>