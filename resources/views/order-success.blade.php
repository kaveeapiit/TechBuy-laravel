@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
    Order Confirmation
</h2>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Success Message -->
    <div class="text-center mb-8">
        <div class="w-20 h-20 bg-secondary-500/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-secondary-400/30 backdrop-blur-sm">
            <svg class="w-10 h-10 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-white mb-2 font-orbitron">Order Placed Successfully!</h1>
        <p class="text-gray-300 mb-4">Thank you for your purchase. Your order has been confirmed and is being processed.</p>
        <div class="tech-card p-4 inline-block">
            <p class="text-sm text-gray-400">Order Number</p>
            <p class="text-xl font-bold text-primary-400 font-jetbrains">{{ $order->order_number }}</p>
        </div>
    </div>

    <!-- Order Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div class="tech-card p-6">
            <h3 class="text-lg font-semibold text-white mb-4 font-orbitron">Order Summary</h3>

            <!-- Order Items -->
            <div class="space-y-4 mb-6">
                @foreach($order->items as $item)
                <div class="flex items-center space-x-3 pb-4 border-b border-primary-700/30">
                    <div class="w-12 h-12 bg-gradient-to-br from-gray-800 to-gray-900 rounded-lg flex items-center justify-center text-lg border border-primary-700/30">
                        @if(str_contains(strtolower($item->product_name), 'iphone'))
                        📱
                        @else
                        💻
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-white">{{ $item->product_name }}</p>
                        <p class="text-sm text-gray-400">SKU: {{ $item->product_sku }} | Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                    </div>
                    <div class="text-sm font-semibold text-primary-400 font-jetbrains">
                        ${{ number_format($item->total, 2) }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Totals -->
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Subtotal</span>
                    <span class="font-medium text-white font-jetbrains">${{ number_format($order->total_amount - $order->tax_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Shipping</span>
                    <span class="font-medium text-secondary-400">Free</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Tax</span>
                    <span class="font-medium text-white font-jetbrains">${{ number_format($order->tax_amount, 2) }}</span>
                </div>
                <div class="border-t border-primary-700/30 pt-2">
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold text-white font-orbitron">Total</span>
                        <span class="text-lg font-semibold text-primary-400 font-jetbrains">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping & Payment Info -->
        <div class="space-y-6">
            <!-- Shipping Address -->
            <div class="tech-card p-6">
                <h3 class="text-lg font-semibold text-white mb-4 font-orbitron">Shipping Address</h3>
                <div class="text-gray-300">
                    <p class="font-medium text-white">{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</p>
                    <p>{{ $order->shipping_address['address'] }}</p>
                    <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['zip_code'] }}</p>
                    <p>{{ $order->shipping_address['country'] }}</p>
                    <p class="mt-2">{{ $order->shipping_address['phone'] }}</p>
                    <p>{{ $order->shipping_address['email'] }}</p>
                </div>
            </div>

            <!-- Order Status -->
            <div class="tech-card p-6">
                <h3 class="text-lg font-semibold text-white mb-4 font-orbitron">Order Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Order Status</span>
                        <span class="px-3 py-1 bg-primary-500/20 text-primary-300 rounded-full text-sm font-medium backdrop-blur-sm border border-primary-500/30">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Payment Status</span>
                        <span class="px-3 py-1 bg-secondary-500/20 text-secondary-300 rounded-full text-sm font-medium backdrop-blur-sm border border-secondary-500/30">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Payment Method</span>
                        <span class="text-white font-medium">{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400">Order Date</span>
                        <span class="text-white font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="tech-card p-6 border border-primary-500/30">
                <h3 class="text-lg font-semibold text-white mb-4 font-orbitron">What's Next?</h3>
                <div class="space-y-3 text-gray-300">
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-primary-400 rounded-full mt-2"></div>
                        <p class="text-sm">You'll receive an email confirmation shortly</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-primary-400 rounded-full mt-2"></div>
                        <p class="text-sm">Your order will be processed within 1-2 business days</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-primary-400 rounded-full mt-2"></div>
                        <p class="text-sm">You'll receive tracking information once shipped</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 text-center space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
        <a href="{{ route('dashboard') }}"
            class="tech-button inline-block group">
            <span class="group-hover:scale-105 transition-transform duration-300">
                View Dashboard
            </span>
        </a>
        <a href="{{ route('home') }}"
            class="inline-block bg-gray-800/50 text-gray-300 px-8 py-3 rounded-lg font-semibold hover:bg-gray-700/50 hover:text-white transition duration-300 backdrop-blur-sm border border-primary-700/30">
            Continue Shopping
        </a>
    </div>
</div>
@endsection