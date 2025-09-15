@extends('layouts.app')

@section('header')
<h2 class="font-semibold text-xl bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">
    Checkout
</h2>
@endsection

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    @livewire('checkout-process')
</div>
@endsection