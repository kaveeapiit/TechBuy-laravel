<div>
    <!-- Flash Message -->
    @if (session()->has('message'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
        {{ session('message') }}
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Product Images -->
        <div>
            <div class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden mb-4">
                <div class="flex items-center justify-center h-96 bg-gray-100 text-8xl">
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

            <!-- Thumbnail Images -->
            @if($product->images && count($product->images) > 1)
            <div class="grid grid-cols-4 gap-2">
                @foreach($product->images as $index => $image)
                <button wire:click="selectImage({{ $index }})"
                    class="aspect-w-1 aspect-h-1 bg-gray-200 rounded-lg overflow-hidden border-2 {{ $selectedImage === $index ? 'border-blue-500' : 'border-transparent' }}">
                    <div class="flex items-center justify-center h-20 bg-gray-100 text-2xl">
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
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Info -->
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

            <div class="mb-4">
                <span class="text-sm text-gray-500">Brand: </span>
                <span class="text-sm font-medium">{{ $product->brand }}</span>
                <span class="mx-2">•</span>
                <span class="text-sm text-gray-500">SKU: </span>
                <span class="text-sm font-medium">{{ $product->sku }}</span>
            </div>

            <!-- Price -->
            <div class="mb-6">
                @if($product->isOnSale())
                <div class="flex items-center space-x-3">
                    <span class="text-3xl font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                    <span class="text-xl text-gray-500 line-through">${{ number_format($product->price, 2) }}</span>
                    <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-medium">
                        Save {{ $product->getDiscountPercentage() }}%
                    </span>
                </div>
                @else
                <span class="text-3xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                @if($product->stock_quantity > 0)
                <span class="inline-flex items-center text-green-600">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    In Stock ({{ $product->stock_quantity }} available)
                </span>
                @else
                <span class="inline-flex items-center text-red-600">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    Out of Stock
                </span>
                @endif
            </div>

            <!-- Description -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Description</h3>
                <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Quantity and Add to Cart -->
            @if($product->stock_quantity > 0)
            <div class="mb-6">
                <div class="flex items-center space-x-4 mb-4">
                    <span class="text-sm font-medium text-gray-700">Quantity:</span>
                    <div class="flex items-center border border-gray-300 rounded-md">
                        <button wire:click="decrementQuantity" type="button"
                            class="px-3 py-2 text-gray-600 hover:text-gray-800">
                            -
                        </button>
                        <span class="px-4 py-2 text-center">{{ $quantity }}</span>
                        <button wire:click="incrementQuantity" type="button"
                            class="px-3 py-2 text-gray-600 hover:text-gray-800">
                            +
                        </button>
                    </div>
                </div>

                <button wire:click="addToCart"
                    class="w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                    Add to Cart - ${{ number_format($product->getCurrentPrice() * $quantity, 2) }}
                </button>
            </div>
            @endif

            <!-- Specifications -->
            @if($product->specifications)
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-4">Specifications</h3>
                <div class="bg-gray-50 rounded-lg p-4">
                    <dl class="grid grid-cols-1 gap-3">
                        @foreach($product->specifications as $key => $value)
                        <div class="flex justify-between py-2 border-b border-gray-200 last:border-b-0">
                            <dt class="font-medium text-gray-900">{{ $key }}:</dt>
                            <dd class="text-gray-600">
                                @if(is_array($value))
                                {{ implode(', ', $value) }}
                                @else
                                {{ $value }}
                                @endif
                            </dd>
                        </div>
                        @endforeach
                    </dl>
                </div>
            </div>
            @endif

            <!-- Features -->
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Free Shipping
                </div>
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    30-Day Returns
                </div>
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Secure Payment
                </div>
                <div class="flex items-center text-gray-600">
                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    1 Year Warranty
                </div>
            </div>
        </div>
    </div>
</div>