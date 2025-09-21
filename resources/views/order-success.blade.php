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
        <div class="w-20 h-20 bg-success-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-10 h-10 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-secondary-900 mb-2">Order Placed Successfully!</h1>
        <p class="text-secondary-600 mb-4">Thank you for your purchase. Your order has been confirmed and is being processed.</p>
        <div class="bg-primary-50 border border-primary-200 rounded-lg p-4 inline-block">
            <p class="text-sm text-secondary-600">Order Number</p>
            <p class="text-xl font-bold text-primary-600">{{ $order->order_number }}</p>
        </div>
    </div>

    <!-- Order Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Order Summary -->
        <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
            <h3 class="text-lg font-semibold text-secondary-900 mb-4">Order Summary</h3>

            <!-- Order Items -->
            <div class="space-y-4 mb-6">
                @foreach($order->items as $item)
                <div class="flex items-center space-x-3 pb-4 border-b border-secondary-100">
                    <div class="w-12 h-12 bg-secondary-100 rounded-lg flex items-center justify-center text-lg">
                        @if(str_contains(strtolower($item->product_name), 'iphone'))
                        📱
                        @else
                        💻
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-secondary-900">{{ $item->product_name }}</p>
                        <p class="text-sm text-secondary-600">SKU: {{ $item->product_sku }} | Qty: {{ $item->quantity }} × ${{ number_format($item->price, 2) }}</p>
                    </div>
                    <div class="text-sm font-semibold text-secondary-900">
                        ${{ number_format($item->total, 2) }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Totals -->
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-secondary-600">Subtotal</span>
                    <span class="font-medium">${{ number_format($order->total_amount - $order->tax_amount, 2) }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-secondary-600">Shipping</span>
                    <span class="font-medium text-success-600">Free</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-secondary-600">Tax</span>
                    <span class="font-medium">${{ number_format($order->tax_amount, 2) }}</span>
                </div>
                <div class="border-t border-secondary-200 pt-2">
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold text-secondary-900">Total</span>
                        <span class="text-lg font-semibold text-secondary-900">${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping & Payment Info -->
        <div class="space-y-6">
            <!-- Shipping Address -->
            <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                <h3 class="text-lg font-semibold text-secondary-900 mb-4">Shipping Address</h3>
                <div class="text-secondary-700">
                    <p class="font-medium">{{ $order->shipping_address['first_name'] }} {{ $order->shipping_address['last_name'] }}</p>
                    <p>{{ $order->shipping_address['address'] }}</p>
                    <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['zip_code'] }}</p>
                    <p>{{ $order->shipping_address['country'] }}</p>
                    <p class="mt-2">{{ $order->shipping_address['phone'] }}</p>
                    <p>{{ $order->shipping_address['email'] }}</p>
                </div>
            </div>

            <!-- Order Status -->
            <div class="bg-white rounded-xl shadow-sm border border-secondary-100 p-6">
                <h3 class="text-lg font-semibold text-secondary-900 mb-4">Order Status</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-secondary-600">Order Status</span>
                        <span class="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-secondary-600">Payment Status</span>
                        <span class="px-3 py-1 bg-success-100 text-success-800 rounded-full text-sm font-medium">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-secondary-600">Payment Method</span>
                        <span class="text-secondary-900 font-medium">{{ ucfirst($order->payment_method) }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-secondary-600">Order Date</span>
                        <span class="text-secondary-900 font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- What's Next -->
            <div class="bg-primary-50 border border-primary-200 rounded-xl p-6">
                <h3 class="text-lg font-semibold text-primary-900 mb-4">What's Next?</h3>
                <div class="space-y-3 text-primary-800">
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                        <p class="text-sm">You'll receive an email confirmation shortly</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                        <p class="text-sm">Your order will be processed within 1-2 business days</p>
                    </div>
                    <div class="flex items-start space-x-3">
                        <div class="w-2 h-2 bg-primary-500 rounded-full mt-2"></div>
                        <p class="text-sm">You'll receive tracking information once shipped</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-8 text-center space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
        <a href="{{ route('dashboard') }}"
            class="inline-block bg-gradient-to-r from-primary-600 to-accent-600 text-white px-8 py-3 rounded-lg font-semibold hover:from-primary-700 hover:to-accent-700 transition duration-300 transform hover:scale-[1.02]">
            View Dashboard
        </a>
        <a href="{{ route('home') }}"
            class="inline-block bg-secondary-100 text-secondary-800 px-8 py-3 rounded-lg font-semibold hover:bg-secondary-200 transition duration-300">
            Continue Shopping
        </a>
    </div>
</div>
@endsection