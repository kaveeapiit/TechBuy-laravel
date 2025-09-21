@extends('layouts.frontend')

@section('title', 'Products - TechBuy')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white mb-4 font-display">
            @if(request('category'))
            {{ ucfirst(str_replace('-', ' ', request('category'))) }}
            @else
            All Products
            @endif
        </h1>
        <p class="text-gray-400 font-mono">Discover our premium collection of electronics</p>
    </div>

    @livewire('product-list', ['category' => request('category')])
</div>
@endsection