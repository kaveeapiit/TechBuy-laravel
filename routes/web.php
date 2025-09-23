<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminProductController;
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

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Redirect admin root to login
    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    // Admin Authentication Routes (accessible without login)
    Route::middleware('guest:admin')->group(function () {
        Route::get('/register', [AdminAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [AdminAuthController::class, 'register']);
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Admin Protected Routes
    Route::middleware('auth:admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Dashboard
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // User Management
        Route::resource('users', AdminUserController::class);
        Route::post('/users/{user}/toggle-verification', [AdminUserController::class, 'toggleVerification'])->name('users.toggle-verification');

        // Product Management
        Route::resource('products', AdminProductController::class);
        Route::post('/products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    });
});
