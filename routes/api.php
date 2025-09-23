<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\MongoProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('products', ProductController::class)->only(['index', 'show']);

// MongoDB Enhanced API routes
Route::prefix('mongo')->group(function () {
    Route::get('/products/search', [MongoProductController::class, 'search']);
    Route::get('/products/trending', [MongoProductController::class, 'trending']);
    Route::get('/products/{id}/analytics', [MongoProductController::class, 'analytics']);
    Route::post('/products/{id}/cart-addition', [MongoProductController::class, 'recordCartAddition']);
    Route::post('/products/{id}/purchase', [MongoProductController::class, 'recordPurchase']);
});

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('cart', CartController::class)->except(['show']);
    Route::post('cart/clear', [CartController::class, 'clear']);
});
