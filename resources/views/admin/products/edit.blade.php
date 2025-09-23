<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl font-display neon-text">
                Edit Product: {{ $product->name }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('admin.products.show', $product) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                    View Product
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                    Back to Products
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-4xl mx-auto">
            <div class="tech-card p-8">

                <!-- Validation Errors -->
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="space-y-6">
                            <!-- Product Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">Product Name</label>
                                <input id="name"
                                    name="name"
                                    type="text"
                                    value="{{ old('name', $product->name) }}"
                                    required
                                    class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                                    placeholder="Enter product name">
                            </div>

                            <!-- SKU -->
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-300 mb-2">SKU</label>
                                <input id="sku"
                                    name="sku"
                                    type="text"
                                    value="{{ old('sku', $product->sku) }}"
                                    required
                                    class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                                    placeholder="Enter SKU">
                            </div>

                            <!-- Price -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-300 mb-2">Price ($)</label>
                                <input id="price"
                                    name="price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    value="{{ old('price', $product->price) }}"
                                    required
                                    class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                                    placeholder="0.00">
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category_id" class="block text-sm font-medium text-gray-300 mb-2">Category</label>
                                <select id="category_id"
                                    name="category_id"
                                    required
                                    class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300">
                                    <option value="">Select a category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Stock Quantity -->
                            <div>
                                <label for="stock_quantity" class="block text-sm font-medium text-gray-300 mb-2">Stock Quantity</label>
                                <input id="stock_quantity"
                                    name="stock_quantity"
                                    type="number"
                                    min="0"
                                    value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                    required
                                    class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                                    placeholder="0">
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <!-- Current Images -->
                            @php
                            $currentImages = json_decode($product->images, true) ?? [];
                            @endphp

                            @if(count($currentImages) > 0)
                            <div>
                                <label class="block text-sm font-medium text-gray-300 mb-2">Current Images</label>
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach($currentImages as $index => $image)
                                    <div class="aspect-w-1 aspect-h-1">
                                        <img src="{{ Storage::url($image) }}"
                                            alt="Current product image {{ $index + 1 }}"
                                            class="w-full h-24 object-cover rounded-lg">
                                    </div>
                                    @endforeach
                                </div>
                                <p class="text-xs text-gray-400 mt-1">Uploading new images will replace all current images.</p>
                            </div>
                            @endif

                            <!-- New Product Images -->
                            <div>
                                <label for="images" class="block text-sm font-medium text-gray-300 mb-2">
                                    {{ count($currentImages) > 0 ? 'Replace Images' : 'Product Images' }}
                                </label>
                                <input id="images"
                                    name="images[]"
                                    type="file"
                                    multiple
                                    accept="image/*"
                                    class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary-500 file:text-white hover:file:bg-primary-600 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300">
                                <p class="text-xs text-gray-400 mt-1">Leave empty to keep current images. Max 2MB per image.</p>
                            </div>

                            <!-- Status -->
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox"
                                        name="is_active"
                                        value="1"
                                        {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-primary-600 shadow-sm focus:border-primary-300 focus:ring focus:ring-primary-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-300">Product is active</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                        <textarea id="description"
                            name="description"
                            rows="4"
                            required
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                            placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Specifications -->
                    <div>
                        <label for="specifications" class="block text-sm font-medium text-gray-300 mb-2">Specifications</label>
                        <textarea id="specifications"
                            name="specifications"
                            rows="4"
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                            placeholder="Enter product specifications (optional)">{{ old('specifications', $product->specifications) }}</textarea>
                    </div>

                    <!-- Features -->
                    <div>
                        <label for="features" class="block text-sm font-medium text-gray-300 mb-2">Features</label>
                        <textarea id="features"
                            name="features"
                            rows="3"
                            class="w-full bg-white/5 border border-white/20 rounded-lg px-4 py-3 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all duration-300"
                            placeholder="Enter product features (optional)">{{ old('features', $product->features) }}</textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.products.show', $product) }}"
                            class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-semibold transition-all duration-300">
                            Cancel
                        </a>
                        <button type="submit"
                            class="bg-gradient-to-r from-primary-500 to-accent-500 hover:from-primary-600 hover:to-accent-600 text-white px-8 py-3 rounded-lg font-semibold transition-all duration-300 shadow-glow hover:shadow-glow-lg">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>

            <!-- Additional Info -->
            <div class="mt-6 tech-card p-6">
                <h3 class="text-lg font-semibold text-white mb-3 font-display">Product Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-300">
                    <div>
                        <p><strong>Current Slug:</strong> {{ $product->slug }}</p>
                    </div>
                    <div>
                        <p><strong>Created:</strong> {{ $product->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p><strong>Last Updated:</strong> {{ $product->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
