@extends('layouts.frontend')

@section('title', 'TechBuy - Premium Electronics Store')

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-purple-700 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6">
                Welcome to <span class="text-yellow-300">TechBuy</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-blue-100">
                Discover the latest in premium electronics and cutting-edge technology
            </p>
            <a href="{{ route('products') }}" class="inline-block bg-white text-blue-600 font-semibold px-8 py-3 rounded-lg hover:bg-gray-100 transition duration-300">
                Shop Now
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('category', $category->slug) }}" class="group">
                <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition duration-300 text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-blue-200 transition duration-300">
                        @if($category->slug === 'iphones')
                        📱
                        @elseif($category->slug === 'macbooks')
                        💻
                        @elseif($category->slug === 'android-phones')
                        📱
                        @elseif($category->slug === 'laptops')
                        💻
                        @else
                        🔧
                        @endif
                    </div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-blue-600">{{ $category->name }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200 relative">
                    @if($product->isOnSale())
                    <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded">
                        -{{ $product->getDiscountPercentage() }}%
                    </span>
                    @endif
                    <div class="flex items-center justify-center h-48 bg-gray-100 text-4xl">
                        @if(str_contains(strtolower($product->name), 'iphone'))
                        📱
                        @elseif(str_contains(strtolower($product->name), 'macbook'))
                        💻
                        @elseif(str_contains(strtolower($product->name), 'samsung') || str_contains(strtolower($product->name), 'pixel'))
                        📱
                        @else
                        💻
                        @endif
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->short_description, 60) }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->isOnSale())
                            <span class="text-lg font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-sm text-gray-500 line-through ml-1">${{ number_format($product->price, 2) }}</span>
                            @else
                            <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product', $product->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- New Products -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">New Arrivals</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($newProducts as $product)
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200 relative">
                    <span class="absolute top-2 left-2 bg-green-500 text-white px-2 py-1 text-xs rounded">
                        New
                    </span>
                    <div class="flex items-center justify-center h-48 bg-gray-100 text-4xl">
                        @if(str_contains(strtolower($product->name), 'iphone'))
                        📱
                        @elseif(str_contains(strtolower($product->name), 'macbook'))
                        💻
                        @elseif(str_contains(strtolower($product->name), 'samsung') || str_contains(strtolower($product->name), 'pixel'))
                        📱
                        @else
                        💻
                        @endif
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->short_description, 60) }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->isOnSale())
                            <span class="text-lg font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-sm text-gray-500 line-through ml-1">${{ number_format($product->price, 2) }}</span>
                            @else
                            <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product', $product->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    🚚
                </div>
                <h3 class="text-lg font-semibold mb-2">Free Shipping</h3>
                <p class="text-gray-600">Free shipping on orders over $100</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    🔒
                </div>
                <h3 class="text-lg font-semibold mb-2">Secure Payment</h3>
                <p class="text-gray-600">Your payment information is safe with us</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4">
                    ↩️
                </div>
                <h3 class="text-lg font-semibold mb-2">Easy Returns</h3>
                <p class="text-gray-600">30-day return policy on all products</p>
            </div>
        </div>
    </div>
</section>
@endsection