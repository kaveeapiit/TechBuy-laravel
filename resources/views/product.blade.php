@extends('layouts.frontend')

@section('title', $product->name . ' - TechBuy')
@section('description', $product->short_description)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-400 font-mono">
            <li><a href="{{ route('home') }}" class="hover:text-primary-400 transition-colors duration-300">Home</a></li>
            <li class="text-gray-600">/</li>
            <li><a href="{{ route('category', $product->category->slug) }}" class="hover:text-primary-400 transition-colors duration-300">{{ $product->category->name }}</a></li>
            <li class="text-gray-600">/</li>
            <li class="text-white font-display">{{ $product->name }}</li>
        </ol>
    </nav>

    @livewire('product-detail', ['product' => $product])

    <!-- Related Products -->
    <section class="mt-16">
        <h2 class="text-2xl font-bold mb-8 text-white font-display">Related Products</h2>
        @php
        $relatedProducts = App\Models\Product::where('category_id', $product->category_id)
        ->where('id', '!=', $product->id)
        ->where('is_active', true)
        ->limit(4)
        ->get();
        @endphp

        @if($relatedProducts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($relatedProducts as $relatedProduct)
            <div class="tech-card overflow-hidden hover:shadow-glow transition-all duration-300 transform hover:scale-105 group">
                <div class="aspect-w-1 aspect-h-1 relative">
                    @if($relatedProduct->isOnSale())
                    <span class="absolute top-3 left-3 bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-3 py-1 text-xs rounded-full z-10 font-mono font-bold">
                        -{{ $relatedProduct->getDiscountPercentage() }}%
                    </span>
                    @endif
                    <div class="flex items-center justify-center h-48 bg-gradient-to-br from-gray-800 to-gray-900 text-4xl group-hover:from-gray-700 group-hover:to-gray-800 transition-all duration-300">
                        @if(str_contains(strtolower($relatedProduct->name), 'iphone'))
                        📱
                        @elseif(str_contains(strtolower($relatedProduct->name), 'macbook'))
                        💻
                        @elseif(str_contains(strtolower($relatedProduct->name), 'samsung') || str_contains(strtolower($relatedProduct->name), 'pixel'))
                        📱
                        @else
                        💻
                        @endif
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-white mb-2 font-display group-hover:text-primary-400 transition-colors duration-300">{{ $relatedProduct->name }}</h3>
                    <p class="text-gray-400 text-sm mb-3 font-mono">{{ Str::limit($relatedProduct->short_description, 60) }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($relatedProduct->isOnSale())
                            <span class="text-lg font-bold text-secondary-400 font-mono">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                            <span class="text-sm text-gray-500 line-through ml-1 font-mono">${{ number_format($relatedProduct->price, 2) }}</span>
                            @else
                            <span class="text-lg font-bold text-white font-mono">${{ number_format($relatedProduct->price, 2) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product', $relatedProduct->slug) }}" class="text-primary-400 hover:text-primary-300 text-sm font-medium transition-colors duration-300 font-display">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </section>
</div>
@endsection