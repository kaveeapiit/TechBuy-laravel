@extends('layouts.frontend')

@section('title', 'Contact Us - TechBuy')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900">
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-r from-accent-600 to-accent-800 py-16">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                    Contact <span class="text-accent-300">TechBuy</span>
                </h1>
                <p class="text-xl text-accent-100 max-w-2xl mx-auto">
                    Get in touch with us for support, inquiries, or to place a pre-order for the latest tech products.
                </p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Success/Error Messages -->
        @if(session('success'))
        <div class="mb-8 bg-green-500/10 border border-green-500/20 text-green-400 px-6 py-4 rounded-lg backdrop-blur-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-8 bg-red-500/10 border border-red-500/20 text-red-400 px-6 py-4 rounded-lg backdrop-blur-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Information -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Get in Touch</h2>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="bg-accent-500/20 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Address</h3>
                                <p class="text-gray-300">123 Tech Street, Digital City, TC 12345</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-accent-500/20 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Phone</h3>
                                <p class="text-gray-300">+1 (555) 123-4567</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-accent-500/20 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Email</h3>
                                <p class="text-gray-300">support@techbuy.com</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="bg-accent-500/20 p-3 rounded-lg">
                                <svg class="w-6 h-6 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Business Hours</h3>
                                <p class="text-gray-300">Mon - Fri: 9:00 AM - 6:00 PM</p>
                                <p class="text-gray-300">Sat: 10:00 AM - 4:00 PM</p>
                                <p class="text-gray-300">Sun: Closed</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8">
                    <h2 class="text-2xl font-bold text-white mb-6">Send Message</h2>

                    <form action="{{ route('contact.send-message') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Name</label>
                                <input type="text" name="name" id="name" required
                                    class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                                    placeholder="Your name">
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email</label>
                                <input type="email" name="email" id="email" required
                                    class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                                    placeholder="your@email.com">
                            </div>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-300 mb-2">Subject</label>
                            <input type="text" name="subject" id="subject" required
                                class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                                placeholder="Message subject">
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300 mb-2">Message</label>
                            <textarea name="message" id="message" rows="5" required
                                class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200 resize-none"
                                placeholder="Your message here..."></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-accent-500 to-accent-600 text-white font-bold py-3 px-6 rounded-lg hover:from-accent-600 hover:to-accent-700 transition-all duration-200 transform hover:scale-105">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Pre-Order Form -->
            <div class="space-y-8">
                <div class="bg-gradient-to-br from-accent-900/20 to-accent-800/20 backdrop-blur-sm border border-accent-500/30 rounded-2xl p-8">
                    <div class="text-center mb-8">
                        <div class="bg-accent-500/20 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-accent-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h2 class="text-3xl font-bold text-white mb-2">Pre-Order</h2>
                        <p class="text-accent-200">Reserve the latest tech products before they launch!</p>
                    </div>

                    @auth
                    <form action="{{ route('contact.preorder.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div>
                            <label for="preorder_name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                            <input type="text" name="name" id="preorder_name" required
                                value="{{ auth()->user()->name ?? old('name') }}"
                                class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                                placeholder="Your full name">
                            @error('name')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="preorder_email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                            <input type="email" name="email" id="preorder_email" required
                                value="{{ auth()->user()->email ?? old('email') }}"
                                class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                                placeholder="your@email.com">
                            @error('email')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="mobile_number" class="block text-sm font-medium text-gray-300 mb-2">Mobile Number</label>
                            <input type="tel" name="mobile_number" id="mobile_number" required
                                class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                                placeholder="+1 (555) 123-4567">
                            @error('mobile_number')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="preorder_item" class="block text-sm font-medium text-gray-300 mb-2">Pre-order Item</label>
                            <textarea name="preorder_item" id="preorder_item" rows="4" required
                                class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200 resize-none"
                                placeholder="Describe the product you want to pre-order (e.g., iPhone 15 Pro Max 256GB, MacBook Pro M3, etc.)"></textarea>
                            @error('preorder_item')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-accent-500 to-accent-600 text-white font-bold py-4 px-6 rounded-lg hover:from-accent-600 hover:to-accent-700 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Submit Pre-Order
                            </span>
                        </button>

                        <div class="text-center">
                            <a href="{{ route('user.preorders.index') }}" class="text-accent-400 hover:text-accent-300 transition-colors duration-200">
                                View My Pre-Orders →
                            </a>
                        </div>
                    </form>
                    @else
                    <div class="text-center py-8">
                        <div class="bg-gray-800/50 rounded-lg p-6 border border-gray-700/50">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <h3 class="text-lg font-semibold text-white mb-2">Login Required</h3>
                            <p class="text-gray-300 mb-4">Please log in to place a pre-order</p>
                            <a href="{{ route('login') }}"
                                class="inline-block bg-gradient-to-r from-accent-500 to-accent-600 text-white font-bold py-2 px-4 rounded-lg hover:from-accent-600 hover:to-accent-700 transition-all duration-200">
                                Login to Pre-Order
                            </a>
                        </div>
                    </div>
                    @endauth
                </div>

                <!-- Features -->
                <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8">
                    <h3 class="text-xl font-bold text-white mb-6">Why Pre-Order with TechBuy?</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-500/20 p-1.5 rounded-full mt-1">
                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">Priority Access</h4>
                                <p class="text-gray-300 text-sm">Be the first to get the latest tech products</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-500/20 p-1.5 rounded-full mt-1">
                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">No Upfront Payment</h4>
                                <p class="text-gray-300 text-sm">Reserve without immediate payment</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="bg-green-500/20 p-1.5 rounded-full mt-1">
                                <svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-white">Flexible Cancellation</h4>
                                <p class="text-gray-300 text-sm">Cancel anytime before confirmation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection