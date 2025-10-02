<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <!-- Pre-order Details -->
            <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8">
                <div class="flex items-start justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Pre-Order Details</h1>
                        <p class="text-gray-300">Order placed on {{ $preorder->created_at->format('F j, Y') }}</p>
                    </div>
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium {{ $preorder->status_color }}">
                        {{ $preorder->formatted_status }}
                    </span>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Order Information -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-bold text-white mb-4">Order Information</h2>
                            <div class="bg-gray-700/30 rounded-lg p-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Pre-order Item</label>
                                    <p class="text-white font-medium">{{ $preorder->preorder_item }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $preorder->status_color }}">
                                        {{ $preorder->formatted_status }}
                                    </span>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Order Date</label>
                                    <p class="text-white">{{ $preorder->created_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                                @if($preorder->updated_at != $preorder->created_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Last Updated</label>
                                    <p class="text-white">{{ $preorder->updated_at->format('F j, Y \a\t g:i A') }}</p>
                                </div>
                                @endif
                                @if($preorder->estimated_delivery)
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Estimated Delivery</label>
                                    <p class="text-white">{{ $preorder->estimated_delivery->format('F j, Y') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($preorder->notes)
                        <div>
                            <h3 class="text-lg font-bold text-white mb-3">Admin Notes</h3>
                            <div class="bg-blue-500/10 border border-blue-500/20 rounded-lg p-4">
                                <p class="text-blue-200">{{ $preorder->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Contact Information -->
                    <div class="space-y-6">
                        <div>
                            <h2 class="text-xl font-bold text-white mb-4">Contact Information</h2>
                            <div class="bg-gray-700/30 rounded-lg p-6 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Full Name</label>
                                    <p class="text-white">{{ $preorder->name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Email Address</label>
                                    <p class="text-white">{{ $preorder->email }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-300 mb-1">Mobile Number</label>
                                    <p class="text-white">{{ $preorder->mobile_number }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div>
                            <h3 class="text-lg font-bold text-white mb-3">Actions</h3>
                            <div class="space-y-3">
                                @if($preorder->status === 'pending')
                                <a href="{{ route('user.preorders.edit', $preorder->_id) }}"
                                    class="w-full inline-flex items-center justify-center bg-accent-600 hover:bg-accent-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                    Edit Pre-Order
                                </a>

                                <form action="{{ route('user.preorders.cancel', $preorder->_id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to cancel this pre-order?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        Cancel Pre-Order
                                    </button>
                                </form>
                                @endif

                                @if(in_array($preorder->status, ['pending', 'cancelled']))
                                <form action="{{ route('user.preorders.destroy', $preorder->_id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this pre-order? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-full inline-flex items-center justify-center bg-red-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Pre-Order
                                    </button>
                                </form>
                                @endif

                                @if(!in_array($preorder->status, ['pending', 'cancelled']))
                                <div class="bg-gray-700/30 rounded-lg p-4 text-center">
                                    <p class="text-gray-300 text-sm">
                                        This pre-order cannot be modified as it is {{ $preorder->status }}.
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline (Optional Enhancement) -->
                <div class="mt-8 pt-8 border-t border-gray-700/50">
                    <h3 class="text-lg font-bold text-white mb-4">Order Timeline</h3>
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <div class="w-4 h-4 bg-green-500 rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-300">Submitted</span>
                        </div>
                        <div class="flex-1 h-px bg-gray-600"></div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 {{ in_array($preorder->status, ['confirmed', 'processing', 'completed']) ? 'bg-green-500' : 'bg-gray-600' }} rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-300">Confirmed</span>
                        </div>
                        <div class="flex-1 h-px bg-gray-600"></div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 {{ in_array($preorder->status, ['processing', 'completed']) ? 'bg-green-500' : 'bg-gray-600' }} rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-300">Processing</span>
                        </div>
                        <div class="flex-1 h-px bg-gray-600"></div>
                        <div class="flex items-center">
                            <div class="w-4 h-4 {{ $preorder->status === 'completed' ? 'bg-green-500' : 'bg-gray-600' }} rounded-full"></div>
                            <span class="ml-2 text-sm text-gray-300">Completed</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>