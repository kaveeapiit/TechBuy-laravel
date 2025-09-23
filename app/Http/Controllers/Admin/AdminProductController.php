<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ILIKE', "%{$search}%")
                    ->orWhere('description', 'ILIKE', "%{$search}%")
                    ->orWhere('sku', 'ILIKE', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Category::where('is_active', true)->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:255', 'unique:products'],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'images.*' => ['nullable', 'image', 'max:2048'],
            'specifications' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        try {
            // Generate slug
            $validated['slug'] = Str::slug($validated['name']);

            // Handle multiple image uploads
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('products', 'public');
                }
            }
            $validated['images'] = $imagePaths; // Store as array, let the model cast handle it

            // Set default active status
            $validated['is_active'] = $request->boolean('is_active', true);

            Product::create($validated);

            return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to create product. Please try again.');
        }
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load('category');
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'sku' => ['required', 'string', 'max:255', 'unique:products,sku,' . $product->id],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'images.*' => ['nullable', 'image', 'max:2048'],
            'specifications' => ['nullable', 'string'],
            'features' => ['nullable', 'string'],
            'is_active' => ['boolean'],
        ]);

        try {
            // Update slug if name changed
            if ($validated['name'] !== $product->name) {
                $validated['slug'] = Str::slug($validated['name']);
            }

            // Handle image uploads
            if ($request->hasFile('images')) {
                // Delete old images
                $oldImages = $product->images ?? [];
                foreach ($oldImages as $oldImage) {
                    if (Storage::disk('public')->exists($oldImage)) {
                        Storage::disk('public')->delete($oldImage);
                    }
                }

                // Upload new images
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imagePaths[] = $image->store('products', 'public');
                }
                $validated['images'] = $imagePaths; // Store as array, let the model cast handle it
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $product->update($validated);

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update product. Please try again.');
        }
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        try {
            // Delete product images
            $images = json_decode($product->images, true) ?? [];
            foreach ($images as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }

            $product->delete();

            return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete product. Please try again.');
        }
    }

    /**
     * Toggle product status.
     */
    public function toggleStatus(Product $product)
    {
        try {
            $product->update([
                'is_active' => !$product->is_active,
            ]);

            $status = $product->is_active ? 'activated' : 'deactivated';
            return redirect()->back()->with('success', "Product {$status} successfully!");
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update product status.');
        }
    }
}
