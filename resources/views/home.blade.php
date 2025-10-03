@extends('layouts.frontend')

@section('title', 'TechBuy - Premium Electronics Store')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-black via-gray-900 to-black text-            <div class=" text-center group">
    <div class="w-16 h-16 bg-gradient-to-r from-accent-500 to-primary-500 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-glow group-hover:shadow-glow-lg transition-all duration-300 transform group-hover:scale-110">
        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M11,9H13V7H11M12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M11,17H13V11H11V17Z" />
        </svg>
    </div>
    <h3 class="text-lg font-semibold mb-2 text-white font-display">Easy Returns</h3>
    <p class="text-gray-400 font-mono">30-day return policy on all products</p>
    </div>verflow-hidden">
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
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM7 4h10v12H7V4zm2 14h6v2H9v-2z" />
                        </svg>
                        @elseif($category->slug === 'macbooks')
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z" />
                        </svg>
                        @elseif($category->slug === 'android-phones')
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM7 4h10v12H7V4zm2 14h6v2H9v-2z" />
                        </svg>
                        @elseif($category->slug === 'laptops')
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z" />
                        </svg>
                        @else
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z" />
                        </svg>
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
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM7 4h10v12H7V4zm2 14h6v2H9v-2z" />
                        </svg>
                        @elseif(str_contains(strtolower($product->name), 'macbook'))
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z" />
                        </svg>
                        @elseif(str_contains(strtolower($product->name), 'samsung') || str_contains(strtolower($product->name), 'pixel'))
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM7 4h10v12H7V4zm2 14h6v2H9v-2z" />
                        </svg>
                        @else
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z" />
                        </svg>
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
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM7 4h10v12H7V4zm2 14h6v2H9v-2z" />
                        </svg>
                        @elseif(str_contains(strtolower($product->name), 'macbook'))
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z" />
                        </svg>
                        @elseif(str_contains(strtolower($product->name), 'samsung') || str_contains(strtolower($product->name), 'pixel'))
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17 2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM7 4h10v12H7V4zm2 14h6v2H9v-2z" />
                        </svg>
                        @else
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20 18c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2H0v2h24v-2h-4zM4 6h16v10H4V6z" />
                        </svg>
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
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19,7H16V6A4,4 0 0,0 12,2A4,4 0 0,0 8,6V7H5A1,1 0 0,0 4,8V19A3,3 0 0,0 7,22H17A3,3 0 0,0 20,19V8A1,1 0 0,0 19,7M10,6A2,2 0 0,1 12,4A2,2 0 0,1 14,6V7H10V6M18,19A1,1 0 0,1 17,20H7A1,1 0 0,1 6,19V9H8V10A1,1 0 0,0 9,11A1,1 0 0,0 10,10V9H14V10A1,1 0 0,0 15,11A1,1 0 0,0 16,10V9H18V19M12,12A3,3 0 0,0 9,15A3,3 0 0,0 12,18A3,3 0 0,0 15,15A3,3 0 0,0 12,12M12,16A1,1 0 0,1 11,15A1,1 0 0,1 12,14A1,1 0 0,1 13,15A1,1 0 0,1 12,16Z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold mb-2 text-white font-display">Free Shipping</h3>
                <p class="text-gray-400 font-mono">Free shipping on orders over $100</p>
            </div>
            <div class="text-center group">
                <div class="w-16 h-16 bg-gradient-to-r from-secondary-500 to-secondary-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-glow group-hover:shadow-glow-lg transition-all duration-300 transform group-hover:scale-110">
                    <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18,8A6,6 0 0,0 12,2A6,6 0 0,0 6,8A6,6 0 0,0 12,14A6,6 0 0,0 18,8M12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12M21,19V20H3V19L5,17V11C5,7.9 7.03,5.17 10,4.29C10,4.19 10,4.1 10,4A2,2 0 0,1 12,2A2,2 0 0,1 14,4C14,4.1 14,4.19 14,4.29C16.97,5.17 19,7.9 19,11V17L21,19M7,18H17V11A5,5 0 0,0 12,6A5,5 0 0,0 7,11V18Z" />
                    </svg>
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