<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                Product Management
            </h2>
            <a href="{{ route('admin.products.create') }}"
                class="bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300 shadow-glow hover:shadow-glow-lg">
                Add New Product
            </a>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-7xl mx-auto">

            <!-- Success Message -->
            @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            <!-- Error Message -->
            @if (session('error'))
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
            @endif

            <!-- Search and Filter -->
            <div class="tech-card p-6 mb-6">
                <form method="GET" action="{{ route('admin.products.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div>
                        <input type="text"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search products..."
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300">
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <select name="category"
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <select name="status"
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <button type="submit"
                            class="flex-1 bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300 shadow-glow hover:shadow-glow-lg">
                            Filter
                        </button>
                        @if(request()->hasAny(['search', 'category', 'status']))
                        <a href="{{ route('admin.products.index') }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg font-semibold transition-all duration-300">
                            Clear
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Products Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @forelse($products as $product)
                <div class="tech-card p-6 glow-on-hover group">
                    <!-- Product Image -->
                    <div class="aspect-w-1 aspect-h-1 mb-4">
                        @if($product->image)
                        <img src="{{ Storage::url($product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-48 object-cover rounded-lg">
                        @else
                        <div class="w-full h-48 bg-gradient-to-br from-gray-700 to-gray-800 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-lg font-semibold text-white truncate">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-400">SKU: {{ $product->sku }}</p>
                        </div>

                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-primary-400">${{ number_format($product->price, 2) }}</span>
                            @if($product->is_active)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                            @else
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                Inactive
                            </span>
                            @endif
                        </div>

                        <div class="text-sm text-gray-300">
                            <p><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</p>
                            <p><strong>Stock:</strong> {{ $product->stock_quantity }}</p>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2 pt-3 border-t border-white/10">
                            <a href="{{ route('admin.products.show', $product) }}"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-2 rounded font-semibold transition-all duration-300 text-center">
                                View
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white text-xs px-3 py-2 rounded font-semibold transition-all duration-300 text-center">
                                Edit
                            </a>
                            <button onclick="confirmDelete('{{ $product->slug }}')"
                                class="flex-1 bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-2 rounded font-semibold transition-all duration-300">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full">
                    <div class="tech-card p-12 text-center">
                        <div class="text-gray-400">
                            <svg class="mx-auto h-16 w-16 text-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <h3 class="mt-2 text-xl font-medium text-gray-300">No products found</h3>
                            <p class="mt-1 text-sm text-gray-500">Get started by creating your first product.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.products.create') }}"
                                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600">
                                    <svg class="-ml-1 mr-2 h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Add Product
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($products->hasPages())
            <div class="mt-8">
                <div class="tech-card p-4">
                    {{ $products->links() }}
                </div>
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
                    <p class="text-sm text-gray-300">Are you sure you want to delete this product? This action cannot be undone.</p>
                </div>
                <div class="items-center px-4 py-3">
                    <form id="deleteForm" method="POST" class="inline">
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
        function confirmDelete(productSlug) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/products/${productSlug}`;
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
