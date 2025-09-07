@extends('layouts.frontend')

@section('title', $product->name . ' - TechBuy')
@section('description', $product->short_description)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-8">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('home') }}" class="hover:text-blue-600">Home</a></li>
            <li>/</li>
            <li><a href="{{ route('category', $product->category->slug) }}" class="hover:text-blue-600">{{ $product->category->name }}</a></li>
            <li>/</li>
            <li class="text-gray-900">{{ $product->name }}</li>
        </ol>
    </nav>

    @livewire('product-detail', ['product' => $product])

    <!-- Related Products -->
    <section class="mt-16">
        <h2 class="text-2xl font-bold mb-8">Related Products</h2>
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
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
                <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                    <div class="flex items-center justify-center h-48 bg-gray-100 text-4xl">
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
                    <h3 class="font-semibold text-gray-900 mb-2">{{ $relatedProduct->name }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ Str::limit($relatedProduct->short_description, 60) }}</p>
                    <div class="flex items-center justify-between">
                        <div>
                            @if($relatedProduct->isOnSale())
                            <span class="text-lg font-bold text-red-600">${{ number_format($relatedProduct->sale_price, 2) }}</span>
                            <span class="text-sm text-gray-500 line-through ml-1">${{ number_format($relatedProduct->price, 2) }}</span>
                            @else
                            <span class="text-lg font-bold text-gray-900">${{ number_format($relatedProduct->price, 2) }}</span>
                            @endif
                        </div>
                        <a href="{{ route('product', $relatedProduct->slug) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
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