<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                Product Details: {{ $product->name }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.products.edit', $product) }}"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                    Edit Product
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                    Back to Products
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-6xl mx-auto">

            <!-- Success Message -->
            @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Product Images -->
                <div class="tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 font-display">Product Images</h3>

                    @php
                    $images = json_decode($product->images, true) ?? [];
                    @endphp

                    @if(count($images) > 0)
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($images as $index => $image)
                        <div class="aspect-w-1 aspect-h-1">
                            <img src="{{ Storage::url($image) }}"
                                alt="{{ $product->name }} - Image {{ $index + 1 }}"
                                class="w-full h-64 object-cover rounded-lg">
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="w-full h-64 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center">
                        <div class="text-center">
                            <svg class="w-16 h-16 text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-gray-400">No images uploaded</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Product Information -->
                <div class="space-y-6">
                    <!-- Basic Info -->
                    <div class="tech-card p-6">
                        <h3 class="text-xl font-semibold text-white mb-4 font-display">Basic Information</h3>
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-400">Product Name</p>
                                    <p class="text-white font-semibold">{{ $product->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">SKU</p>
                                    <p class="text-white font-mono">{{ $product->sku }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-400">Price</p>
                                    <p class="text-2xl font-bold text-primary-400">${{ number_format($product->price, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Stock Quantity</p>
                                    <p class="text-white font-semibold">{{ number_format($product->stock_quantity) }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-400">Category</p>
                                    <p class="text-white">{{ $product->category->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-400">Status</p>
                                    @if($product->is_active)
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    @else
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <p class="text-sm text-gray-400">Slug</p>
                                <p class="text-white font-mono text-sm">{{ $product->slug }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Actions -->
                    <div class="tech-card p-6">
                        <h3 class="text-xl font-semibold text-white mb-4 font-display">Quick Actions</h3>
                        <div class="flex space-x-4">
                            <form method="POST" action="{{ route('admin.products.toggle-status', $product) }}">
                                @csrf
                                @if($product->is_active)
                                <button type="submit"
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300">
                                    Deactivate Product
                                </button>
                                @else
                                <button type="submit"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300">
                                    Activate Product
                                </button>
                                @endif
                            </form>

                            <button onclick="confirmDelete()"
                                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold transition-all duration-300">
                                Delete Product
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description & Details -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Description -->
                <div class="lg:col-span-2 tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 font-display">Description</h3>
                    <div class="text-gray-300 whitespace-pre-line">{{ $product->description }}</div>
                </div>

                <!-- Metadata -->
                <div class="tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 font-display">Metadata</h3>
                    <div class="space-y-3 text-sm">
                        <div>
                            <p class="text-gray-400">Created</p>
                            <p class="text-white">{{ $product->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Last Updated</p>
                            <p class="text-white">{{ $product->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-400">Days Since Created</p>
                            <p class="text-white">{{ $product->created_at->diffInDays() }} days</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Specifications & Features -->
            @if($product->specifications || $product->features)
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                @if($product->specifications)
                <div class="tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 font-display">Specifications</h3>
                    <div class="text-gray-300 whitespace-pre-line">{{ $product->specifications }}</div>
                </div>
                @endif

                @if($product->features)
                <div class="tech-card p-6">
                    <h3 class="text-xl font-semibold text-white mb-4 font-display">Features</h3>
                    <div class="text-gray-300 whitespace-pre-line">{{ $product->features }}</div>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-white">Confirm Delete</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-300">Are you sure you want to delete this product? This action cannot be undone and will remove all associated images.</p>
                </div>
                <div class="items-center px-4 py-3">
                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 mr-2">
                            Delete
                        </button>
                    </form>
                    <button onclick="closeModal()"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-auto shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('deleteModal');
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>
</x-admin-layout>
