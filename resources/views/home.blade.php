@extends('layouts.frontend')

@section('title', 'TechBuy - Premium Electronics Store')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-black text-white overflow-hidden">
    <!-- Tech Grid Background -->
    <div class="absolute inset-0 opacity-20">
        <div class="tech-grid"></div>
    </div>

    <!-- Floating Elements -->
    <div class="absolute inset-0">
        <div class="floating-element absolute top-20 left-10 w-2 h-2 bg-primary-400 rounded-full"></div>
        <div class="floating-element absolute top-32 right-20 w-3 h-3 bg-accent-400 rounded-full" style="animation-delay: 1s;"></div>
        <div class="floating-element absolute bottom-40 left-1/4 w-1 h-1 bg-secondary-400 rounded-full" style="animation-delay: 2s;"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 font-display">
                Welcome to <span class="neon-text bg-gradient-to-r from-primary-400 to-accent-400 bg-clip-text text-transparent">TechBuy</span>
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-gray-300 font-light">
                Discover the latest in premium electronics and cutting-edge technology
            </p>
            <a href="{{ route('products') }}" class="tech-button inline-block">
                <span class="relative z-10">Shop Now</span>
            </a>
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16 bg-gradient-to-b from-gray-900 to-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-white font-display">Shop by Category</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('category', $category->slug) }}" class="group">
                <div class="tech-card p-6 text-center hover:shadow-glow transition-all duration-300 transform hover:scale-105">
                    <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-glow group-hover:shadow-glow-lg transition-all duration-300">
                        @if($category->slug === 'iphones')
                        <span class="text-2xl">📱</span>
                        @elseif($category->slug === 'macbooks')
                        <span class="text-2xl">💻</span>
                        @elseif($category->slug === 'android-phones')
                        <span class="text-2xl">📱</span>
                        @elseif($category->slug === 'laptops')
                        <span class="text-2xl">💻</span>
                        @else
                        <span class="text-2xl">🔧</span>
                        @endif
                    </div>
                    <h3 class="font-semibold text-white group-hover:text-primary-400 transition-colors duration-300 font-display">{{ $category->name }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-16 bg-black">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-white font-display">Featured Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts as $product)
            <div class="tech-card overflow-hidden hover:shadow-glow transition-all duration-300 transform hover:scale-105 group">
                <div class="aspect-w-1 aspect-h-1 relative">
                    @if($product->isOnSale())
                    <span class="absolute top-3 left-3 bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-3 py-1 text-xs rounded-full z-10 font-mono font-bold">
                        -{{ $product->getDiscountPercentage() }}%
                    </span>
                    @endif
                    <div class="flex items-center justify-center h-48 bg-gradient-to-br from-gray-800 to-gray-900 text-4xl group-hover:from-gray-700 group-hover:to-gray-800 transition-all duration-300">
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
                    <h3 class="font-semibold text-white mb-2 font-display group-hover:text-primary-400 transition-colors duration-300">{{ $product->name }}</h3>
                    <p class="text-gray-400 text-sm mb-3 font-mono">{{ Str::limit($product->short_description, 60) }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->isOnSale())
                            <span class="text-lg font-bold text-secondary-400 font-mono">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-sm text-gray-500 line-through ml-1 font-mono">${{ number_format($product->price, 2) }}</span>
                            @else
                            <span class="text-lg font-bold text-white font-mono">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product', $product->slug) }}" class="text-primary-400 hover:text-primary-300 text-sm font-medium transition-colors duration-300 font-display">
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
<section class="py-16 bg-gradient-to-b from-black to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12 text-white font-display">New Arrivals</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($newProducts as $product)
            <div class="tech-card overflow-hidden hover:shadow-glow transition-all duration-300 transform hover:scale-105 group">
                <div class="aspect-w-1 aspect-h-1 relative">
                    <span class="absolute top-3 left-3 bg-gradient-to-r from-accent-500 to-accent-600 text-white px-3 py-1 text-xs rounded-full z-10 font-mono font-bold">
                        New
                    </span>
                    @if($product->images && is_array($product->images) && count($product->images) > 0)
                    <img src="{{ Storage::url($product->images[0]) }}"
                        alt="{{ $product->name }}"
                        class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                    @else
                    <div class="flex items-center justify-center h-48 bg-gradient-to-br from-gray-800 to-gray-900 text-4xl group-hover:from-gray-700 group-hover:to-gray-800 transition-all duration-300">
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
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-white mb-2 font-display group-hover:text-primary-400 transition-colors duration-300">{{ $product->name }}</h3>
                    <p class="text-gray-400 text-sm mb-3 font-mono">{{ Str::limit($product->short_description, 60) }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($product->isOnSale())
                            <span class="text-lg font-bold text-secondary-400 font-mono">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-sm text-gray-500 line-through ml-1 font-mono">${{ number_format($product->price, 2) }}</span>
                            @else
                            <span class="text-lg font-bold text-white font-mono">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product', $product->slug) }}" class="text-primary-400 hover:text-primary-300 text-sm font-medium transition-colors duration-300 font-display">
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
<section class="py-16 bg-gradient-to-br from-gray-900 via-black to-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-r from-primary-500 to-accent-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-glow group-hover:shadow-glow-lg transition-all duration-300 transform group-hover:scale-110">
                    <span class="text-2xl">🚚</span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-white font-display">Free Shipping</h3>
                <p class="text-gray-400 font-mono">Free shipping on orders over $100</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-r from-secondary-500 to-secondary-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-glow group-hover:shadow-glow-lg transition-all duration-300 transform group-hover:scale-110">
                    <span class="text-2xl">🔒</span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-white font-display">Secure Payment</h3>
                <p class="text-gray-400 font-mono">Your payment information is safe with us</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-r from-accent-500 to-primary-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-glow group-hover:shadow-glow-lg transition-all duration-300 transform group-hover:scale-110">
                    <span class="text-2xl">↩️</span>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-white font-display">Easy Returns</h3>
                <p class="text-gray-400 font-mono">30-day return policy on all products</p>
            </div>
        </div>
    </div>
</section>
@endsection