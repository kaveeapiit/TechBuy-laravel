<div>
    <!-- Filters and Search -->
    <div class="tech-card p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-white mb-2 font-display">Search</label>
                <input type="text" wire:model.live="search" placeholder="Search products..."
                    class="w-full px-3 py-2 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 backdrop-blur-sm text-white placeholder-gray-400 font-mono">
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium text-white mb-2 font-display">Category</label>
                <select wire:model.live="category" class="w-full px-3 py-2 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 backdrop-blur-sm text-white font-mono">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Price Range -->
            <div>
                <label class="block text-sm font-medium text-white mb-2 font-display">Price Range</label>
                <div class="grid grid-cols-2 gap-2">
                    <input type="number" wire:model.live="priceMin" placeholder="Min"
                        class="px-3 py-2 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 backdrop-blur-sm text-white placeholder-gray-400 font-mono">
                    <input type="number" wire:model.live="priceMax" placeholder="Max"
                        class="px-3 py-2 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 backdrop-blur-sm text-white placeholder-gray-400 font-mono">
                </div>
            </div>

            <!-- Sort -->
            <div>
                <label class="block text-sm font-medium text-white mb-2 font-display">Sort By</label>
                <select wire:model.live="sortBy" class="w-full px-3 py-2 bg-white/10 border border-primary-600/30 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-400 backdrop-blur-sm text-white font-mono">
                    <option value="name">Name</option>
                    <option value="price">Price</option>
                    <option value="created_at">Newest</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Results Info -->
    <div class="flex items-center justify-between mb-6">
        <p class="text-gray-400 font-mono">
            Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{ $products->total() }} results
        </p>
        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-400 font-display">Sort:</span>
            <button wire:click="sortBy('name')" class="text-sm {{ $sortBy === 'name' ? 'text-primary-400 font-semibold' : 'text-gray-400' }} hover:text-primary-300 transition-colors duration-300 font-display">
                Name {{ $sortBy === 'name' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
            </button>
            <button wire:click="sortBy('price')" class="text-sm {{ $sortBy === 'price' ? 'text-primary-400 font-semibold' : 'text-gray-400' }} hover:text-primary-300 transition-colors duration-300 font-display">
                Price {{ $sortBy === 'price' ? ($sortDirection === 'asc' ? '↑' : '↓') : '' }}
            </button>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        @foreach($products as $product)
        <div class="tech-card overflow-hidden hover:shadow-glow transition-all duration-300 transform hover:scale-105 group">
            <div class="aspect-w-1 aspect-h-1 relative">
                @if($product->isOnSale())
                <span class="absolute top-3 left-3 bg-gradient-to-r from-secondary-500 to-secondary-600 text-white px-3 py-1 text-xs rounded-full z-10 font-mono font-bold">
                    -{{ $product->getDiscountPercentage() }}%
                </span>
                @endif
                <div class="flex items-center justify-center h-48 bg-gradient-to-br from-gray-800 to-gray-900 text-4xl group-hover:from-gray-700 group-hover:to-gray-800 transition-all duration-300">
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
                <h3 class="font-semibold text-white mb-1 font-display group-hover:text-primary-400 transition-colors duration-300">{{ $product->name }}</h3>
                <p class="text-sm text-gray-400 mb-2 font-mono">{{ $product->category->name }}</p>
                <p class="text-gray-400 text-sm mb-3 font-mono">{{ Str::limit($product->short_description, 80) }}</p>

                <!-- Price -->
                <div class="mb-3">
                    @if($product->isOnSale())
                    <span class="text-lg font-bold text-secondary-400 font-mono">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-sm text-gray-500 line-through ml-1 font-mono">${{ number_format($product->price, 2) }}</span>
                    @else
                    <span class="text-lg font-bold text-white font-mono">${{ number_format($product->price, 2) }}</span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="mb-3">
                    @if($product->stock_quantity > 0)
                    <span class="text-sm text-secondary-400 font-mono">✓ In Stock ({{ $product->stock_quantity }})</span>
                    @else
                    <span class="text-sm text-red-400 font-mono">✗ Out of Stock</span>
                    @endif
                </div>

                <!-- Actions -->
                <div class="flex space-x-2">
                    <a href="{{ route('product', $product->slug) }}"
                        class="flex-1 tech-button text-center py-2 px-4 text-sm font-medium">
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
        <h3 class="text-xl font-semibold text-white mb-2 font-display">No products found</h3>
        <p class="text-gray-400 font-mono">Try adjusting your search or filter criteria</p>
    </div>
    @endif
</div>