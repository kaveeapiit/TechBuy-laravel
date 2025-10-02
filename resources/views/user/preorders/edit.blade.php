<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900 py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-8">
                <a href="{{ route('user.preorders.index') }}"
                    class="inline-flex items-center text-accent-400 hover:text-accent-300 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Pre-Orders
                </a>
            </div>

            <!-- Edit Form -->
            <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-white mb-2">Edit Pre-Order</h1>
                    <p class="text-gray-300">Update your pre-order information</p>
                </div>

                <!-- Success/Error Messages -->
                @if(session('error'))
                <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-400 px-6 py-4 rounded-lg backdrop-blur-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
                @endif

                <form action="{{ route('user.preorders.update', $preorder->_id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Full Name</label>
                        <input type="text" name="name" id="name" required
                            value="{{ old('name', $preorder->name) }}"
                            class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                            placeholder="Your full name">
                        @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <input type="email" name="email" id="email" required
                            value="{{ old('email', $preorder->email) }}"
                            class="w-full bg-gray-700/50 border border-gray-600/50 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:ring-2 focus:ring-accent-500 focus:border-transparent transition-all duration-200"
                            placeholder="your@email.com">
                        @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="mobile_number" class="block text-sm font-medium text-gray-300 mb-2">Mobile Number</label>
                        <input type="tel" name="mobile_number" id="mobile_number" required
                            value="{{ old('mobile_number', $preorder->mobile_number) }}"
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
                            placeholder="Describe the product you want to pre-order">{{ old('preorder_item', $preorder->preorder_item) }}</textarea>
                        @error('preorder_item')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Current Status Display -->
                    <div class="bg-gray-700/30 rounded-lg p-4">
                        <label class="block text-sm font-medium text-gray-300 mb-2">Current Status</label>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $preorder->status_color }}">
                            {{ $preorder->formatted_status }}
                        </span>
                    </div>

                    <div class="flex space-x-4">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-accent-500 to-accent-600 text-white font-bold py-3 px-6 rounded-lg hover:from-accent-600 hover:to-accent-700 transition-all duration-200 transform hover:scale-105">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Pre-Order
                            </span>
                        </button>

                        <a href="{{ route('user.preorders.show', $preorder->_id) }}"
                            class="flex-1 bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                            <span class="flex items-center justify-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Cancel
                            </span>
                        </a>
                    </div>
                </form>

                <!-- Help Text -->
                <div class="mt-8 p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <svg class="w-5 h-5 text-blue-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <h4 class="text-blue-200 font-medium mb-1">Note</h4>
                            <p class="text-blue-200 text-sm">
                                You can only edit pre-orders that are in "pending" status. Once confirmed or processed, changes are not allowed.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>