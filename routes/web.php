<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OAuth\SocialAuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WishListController;
use App\Livewire\ProductShow;
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
    
});

Auth::routes();

Route::get('auth/{provider}', [SocialAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('auth/callback/{provider}', [SocialAuthController::class, 'callback']);

Route::middleware(['auth'])->group(
    function () {
        // Profile
        Route::name('profile.')->group(function () {
            Route::get('/profile', [ProfileController::class, 'index'])->name('index');
            Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('update');
            Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('delete');
        });

        Route::post('/products/{product}/reviews', [ProductController::class, 'storeReview'])->name('product.review.store');
    }
);

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/shop/category/{category}', function ($category) {
    return view('shop', compact('category'));
})->name('shop.category');

Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart-add', [CartController::class, 'add'])->name('cart.add');
Route::get('/show/{product}', [ProductController::class, 'showDetails'])->name('product.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{product}/reviews/load-more', [ProductController::class, 'loadMoreReviews'])->name('product.reviews.load-more');
Route::get('/products/{product}', ProductShow::class)
    ->name('product.show')
    ->where('product', '[0-9]+');
// WishList
Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
