<div>
    @if(session()->has('error'))
    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
        {{ session('error') }}
    </div>
    @endif

    @if(empty($cartItems))
    <div class="text-center py-16">
        <div class="text-8xl mb-6">🛒</div>
        <h2 class="text-2xl font-semibold text-secondary-900 mb-4">Your cart is empty</h2>
        <p class="text-secondary-600 mb-8">Add items to your cart before checking out</p>
        <a href="{{ route('home') }}"
            class="inline-block bg-gradient-to-r from-primary-600 to-accent-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-primary-700 hover:to-accent-700 transition duration-300">
            Continue Shopping
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Checkout Form -->
        <div class="lg:col-span-2">
            <form wire:submit.prevent="placeOrder" class="space-y-8">

                <!-- Shipping Information -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-6">Shipping Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">First Name</label>
                            <input type="text" wire:model="firstName"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('firstName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">Last Name</label>
                            <input type="text" wire:model="lastName"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('lastName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">Email</label>
                            <input type="email" wire:model="email"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">Phone</label>
                            <input type="tel" wire:model="phone"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-secondary-700 mb-2">Address</label>
                            <input type="text" wire:model="address"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">City</label>
                            <input type="text" wire:model="city"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('city') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">State</label>
                            <input type="text" wire:model="state"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('state') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">ZIP Code</label>
                            <input type="text" wire:model="zipCode"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('zipCode') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">Country</label>
                            <select wire:model="country"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                                <option value="United States">United States</option>
                                <option value="Canada">Canada</option>
                                <option value="United Kingdom">United Kingdom</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Payment Information -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                    <h3 class="text-lg font-semibold text-secondary-900 mb-6">Payment Information</h3>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-secondary-700 mb-4">Payment Method</label>
                        <div class="space-y-2">
                            <label class="flex items-center">
                                <input type="radio" wire:model="paymentMethod" value="card" class="text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-secondary-700">Credit/Debit Card</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" wire:model="paymentMethod" value="paypal" class="text-primary-600 focus:ring-primary-500">
                                <span class="ml-2 text-sm text-secondary-700">PayPal</span>
                            </label>
                        </div>
                    </div>

                    @if($paymentMethod === 'card')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-secondary-700 mb-2">Card Number</label>
                            <input type="text" wire:model="cardNumber" placeholder="1234 5678 9012 3456"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('cardNumber') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">Expiry Date</label>
                            <input type="text" wire:model="expiryDate" placeholder="MM/YY"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('expiryDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-secondary-700 mb-2">CVV</label>
                            <input type="text" wire:model="cvv" placeholder="123"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('cvv') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-secondary-700 mb-2">Cardholder Name</label>
                            <input type="text" wire:model="cardName"
                                class="w-full px-4 py-3 border border-secondary-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition duration-200">
                            @error('cardName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Place Order Button -->
                <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-primary-600 to-accent-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:from-primary-700 hover:to-accent-700 transition duration-300 transform hover:scale-[1.02]">
                        Place Order - ${{ number_format($grandTotal, 2) }}
                    </button>

                    <p class="text-sm text-secondary-600 text-center mt-4">
                        Your payment information is secure and encrypted
                    </p>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6 sticky top-8">
                <h3 class="text-lg font-semibold text-secondary-900 mb-6">Order Summary</h3>

                <!-- Cart Items -->
                <div class="space-y-4 mb-6">
                    @foreach($cartItems as $item)
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-secondary-100 rounded-lg flex items-center justify-center text-lg">
                            @if(str_contains(strtolower($item['product']['name']), 'iphone'))
                            📱
                            @else
                            💻
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-secondary-900">{{ $item['product']['name'] }}</p>
                            <p class="text-xs text-secondary-600">Qty: {{ $item['quantity'] }}</p>
                        </div>
                        <div class="text-sm font-semibold text-secondary-900">
                            ${{ number_format($item['quantity'] * $item['price'], 2) }}
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Totals -->
                <div class="space-y-2 border-t border-secondary-200 pt-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-secondary-600">Subtotal</span>
                        <span class="font-medium">${{ number_format($total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-secondary-600">Shipping</span>
                        <span class="font-medium text-success-600">Free</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-secondary-600">Tax</span>
                        <span class="font-medium">${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="border-t border-secondary-200 pt-2">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-secondary-900">Total</span>
                            <span class="text-lg font-semibold text-secondary-900">${{ number_format($grandTotal, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>