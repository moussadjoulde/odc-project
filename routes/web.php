<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishListController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $products = Product::where('is_active', true)
        ->orderBy('is_featured', 'desc')
        ->orderBy('created_at', 'desc')
        ->paginate(12);
    return view('home', compact('products'));
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('products/export/csv', [ProductController::class, 'exportCSV'])->name('products.exportCSV');
    Route::get('products/{id}/export/csv', [ProductController::class, 'exportCSVWithId'])->name('products.exportCSVWithId');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/products', [AdminController::class, 'productsIndex'])->name('admin.products.index');
    });

    //Order Management
    Route::resource('orders', OrderController::class);
    Route::get('orders/export/csv', [OrderController::class, 'exportCSV'])->name('orders.exportCSV');
    Route::get('orders/{id}/export/csv', [OrderController::class, 'exportCSVWithId'])->name('orders.exportCSVWithId');

    // WishList
    Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');

});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
