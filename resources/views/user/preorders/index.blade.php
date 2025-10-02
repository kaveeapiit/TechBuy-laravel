<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-dark-900 via-dark-800 to-dark-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-8 mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">My Pre-Orders</h1>
                        <p class="text-gray-300">Manage your product pre-orders and track their status</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <a href="{{ route('contact.index') }}"
                            class="inline-flex items-center bg-gradient-to-r from-accent-500 to-accent-600 text-white font-bold py-3 px-6 rounded-lg hover:from-accent-600 hover:to-accent-700 transition-all duration-200 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            New Pre-Order
                        </a>
                    </div>
                </div>
            </div>

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

            <!-- MongoDB Unavailable Warning -->
            @if(isset($mongodb_unavailable) && $mongodb_unavailable)
            <div class="mb-8 bg-yellow-500/10 border border-yellow-500/20 text-yellow-400 px-6 py-4 rounded-lg backdrop-blur-sm">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    MongoDB is currently unavailable. Pre-order functionality is temporarily disabled.
                </div>
            </div>
            @endif

            <!-- Pre-orders List -->
            @if($preorders->count() > 0)
            <div class="grid gap-6">
                @foreach($preorders as $preorder)
                <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-6 hover:border-accent-500/30 transition-all duration-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <h3 class="text-xl font-bold text-white mb-2">{{ $preorder->preorder_item }}</h3>
                                    <div class="flex items-center space-x-4 text-sm text-gray-300">
                                        <span>📧 {{ $preorder->email }}</span>
                                        <span>📱 {{ $preorder->mobile_number }}</span>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $preorder->status_color }}">
                                    {{ $preorder->formatted_status }}
                                </span>
                            </div>

                            <div class="flex items-center text-sm text-gray-400 mb-4">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Ordered {{ $preorder->created_at->format('M j, Y') }} at {{ $preorder->created_at->format('g:i A') }}
                            </div>

                            @if($preorder->notes)
                            <div class="bg-gray-700/30 rounded-lg p-3 mb-4">
                                <p class="text-sm text-gray-300">
                                    <strong>Notes:</strong> {{ $preorder->notes }}
                                </p>
                            </div>
                            @endif
                        </div>

                        <div class="flex items-center space-x-3 mt-4 lg:mt-0 lg:ml-6">
                            <a href="{{ route('user.preorders.show', $preorder->_id) }}"
                                class="inline-flex items-center bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                View
                            </a>

                            @if($preorder->status === 'pending')
                            <a href="{{ route('user.preorders.edit', $preorder->_id) }}"
                                class="inline-flex items-center bg-accent-600 hover:bg-accent-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>

                            <form action="{{ route('user.preorders.cancel', $preorder->_id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to cancel this pre-order?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="inline-flex items-center bg-yellow-600 hover:bg-yellow-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Cancel
                                </button>
                            </form>
                            @endif

                            @if(in_array($preorder->status, ['pending', 'cancelled']))
                            <form action="{{ route('user.preorders.destroy', $preorder->_id) }}" method="POST" class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this pre-order? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- Empty State -->
            <div class="bg-gradient-to-br from-gray-800/50 to-gray-900/50 backdrop-blur-sm border border-gray-700/50 rounded-2xl p-12 text-center">
                <div class="bg-gray-700/30 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">No Pre-Orders Yet</h3>
                <p class="text-gray-300 mb-8 max-w-md mx-auto">
                    You haven't placed any pre-orders yet. Reserve the latest tech products before they launch!
                </p>
                <a href="{{ route('contact.index') }}"
                    class="inline-flex items-center bg-gradient-to-r from-accent-500 to-accent-600 text-white font-bold py-3 px-6 rounded-lg hover:from-accent-600 hover:to-accent-700 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Place Your First Pre-Order
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>