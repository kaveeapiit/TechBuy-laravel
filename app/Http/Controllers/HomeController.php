<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('is_active', true)->get();
        $featuredProducts = Product::where('is_active', true)
            ->whereNotNull('sale_price')
            ->with('category')
            ->limit(8)
            ->get();

        $newProducts = Product::where('is_active', true)
            ->with('category')
            ->latest()
            ->limit(8)
            ->get();

        return view('home', compact('categories', 'featuredProducts', 'newProducts'));
    }

    public function products()
    {
        return view('products');
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return view('products', ['category' => $category->slug]);
    }

    public function product($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        return view('product', compact('product'));
    }
}
