<div>
    <!-- Filters and Search -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" wire:model.live="search" placeholder="Search products..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select wire:model.live="category" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Price Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" wire:model.live="priceMin" placeholder="Min"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <input type="number" wire:model.live="priceMax" placeholder="Max"
                        class="px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                <select wire:model.live="sortBy" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    <option value="name">Name</option>
                    <option value="price">Price</option>
                    <option value="created_at">Newest</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Results Info -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-600">
            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
        </p>
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-600">Sort:</span>
            <button wire:click="sortBy('name')" class="text-sm {{ $sortBy === 'name' ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                Name {{ $sortBy === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
            </button>
            <button wire:click="sortBy('price')" class="text-sm {{ $sortBy === 'price' ? 'text-blue-600 font-semibold' : 'text-gray-600' }}">
                Price {{ $sortBy === 'price' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @foreach($products as $product)
        <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition duration-300 overflow-hidden">
            <div class="aspect-w-1 aspect-h-1 bg-gray-200 relative">
                @if($product->isOnSale())
                <span class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 text-xs rounded z-10">
                    -{{ $product->getDiscountPercentage() }}%
                </span>
                @endif
                <div class="flex items-center justify-center h-48 bg-gray-100 text-4xl">
                    @if(str_contains(strtolower($product->name), 'iphone'))
                    📱
                    @elseif(str_contains(strtolower($product->name), 'macbook'))
                    💻
                    @elseif(str_contains(strtolower($product->name), 'samsung') || str_contains(strtolower($product->name), 'pixel'))
                    📱
                    @else
                    💻
                    @endif
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 mb-1">{{ $product->name }}</h3>
                <p class="text-sm text-gray-500 mb-2">{{ $product->category->name }}</p>
                <p class="text-gray-600 text-sm mb-3">{{ Str::limit($product->short_description, 80) }}</p>

                <!-- Price -->
                <div class="mb-3">
                    @if($product->isOnSale())
                    <span class="text-lg font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-sm text-gray-500 line-through ml-1">${{ number_format($product->price, 2) }}</span>
                    @else
                    <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="mb-3">
                    @if($product->stock_quantity > 0)
                    <span class="text-sm text-green-600">✓ In Stock ({{ $product->stock_quantity }})</span>
                    @else
                    <span class="text-sm text-red-600">✗ Out of Stock</span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex space-x-2">
                    <a href="{{ route('product', $product->slug) }}"
                        class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-md hover:bg-blue-700 transition duration-300 text-sm font-medium">
                        View Details
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="flex justify-center">
        {{ $products->links() }}
    </div>

    @if($products->isEmpty())
    <div class="text-center py-12">
        <div class="text-6xl mb-4">🔍</div>
        <h3 class="text-xl font-semibold text-gray-900 mb-2">No products found</h3>
        <p class="text-gray-600">Try adjusting your search or filter criteria</p>
    </div>
    @endif
</div>