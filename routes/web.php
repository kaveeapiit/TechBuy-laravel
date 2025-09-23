<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('category');
Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/cart', function () {
        return view('cart');
    })->name('cart');

    Route::get('/checkout', function () {
        return view('checkout');
    })->name('checkout');

    Route::get('/order/success/{order}', function ($orderNumber) {
        $order = \App\Models\Order::where('order_number', $orderNumber)
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->firstOrFail();
        return view('order-success', compact('order'));
    })->name('order.success');

    // User Profile Management Routes
    Route::prefix('profile')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'profile'])->name('profile');
        Route::get('/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/update', [UserController::class, 'update'])->name('update');

        // Password Management
        Route::get('/change-password', [UserController::class, 'changePasswordForm'])->name('change-password');
        Route::put('/change-password', [UserController::class, 'changePassword'])->name('update-password');

        // Account Deletion
        Route::get('/delete-account', [UserController::class, 'deleteAccountForm'])->name('delete-account');
        Route::delete('/delete-account', [UserController::class, 'deleteAccount'])->name('destroy');

        // Order History
        Route::get('/orders', [UserController::class, 'orders'])->name('orders');
        Route::get('/orders/{orderNumber}', [UserController::class, 'orderDetails'])->name('order-details');
    });
});
