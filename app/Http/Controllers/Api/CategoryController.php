<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->withCount('products')
            ->get();

        return response()->json($categories);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (!$category->is_active) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->load(['products' => function ($query) {
            $query->where('is_active', true);
        }]);

        return response()->json($category);
    }
}
