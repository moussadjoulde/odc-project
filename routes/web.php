<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OAuth\SocialAuthController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth', 'role:admin', 'verified'])->group(function () {
    Route::resource('products', ProductController::class);
    Route::get('products/export/csv', [ProductController::class, 'exportCSV'])->name('products.exportCSV');
    Route::get('products/{id}/export/csv', [ProductController::class, 'exportCSVWithId'])->name('products.exportCSVWithId');

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        // Route::get('/products', [AdminController::class, 'productsIndex'])->name('admin.products.index');
        Route::resource('products', ProductController::class);
        Route::resource('categories', CategoryController::class);
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/export/csv', [CategoryController::class, 'exportCSV'])->name('categories.exportCSV');
        Route::patch('categories/{category}/toggle-status', [CategoryController::class, 'toggleStatus'])->name('categories.toggleStatus');
        Route::resource('users', UserController::class);
        // Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
        Route::post('users/{user}/revoke-permissions', [UserController::class, 'revokeAllPermissions'])->name('users.revokeAllPermissions');
        Route::patch('users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::post('users/{user}/verification', [UserController::class, 'sendVerification'])->name('users.sendVerification');
        Route::get('users/export/csv', [UserController::class, 'exportCSV'])->name('users.exportCSV');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.resetPassword');
        Route::patch('/users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');

        Route::get('/orders', [OrderAdminController::class, 'index'])->name('orders.admin.index');
        Route::get('/orders/create', [OrderAdminController::class, 'create'])->name('orders.admin.create');
        Route::post('/orders', [OrderAdminController::class, 'store'])->name('orders.admin.store');
        Route::get('/orders/{order}', [OrderAdminController::class, 'show'])->name('orders.admin.show');
        Route::get('/orders/{order}/edit', [OrderAdminController::class, 'edit'])->name('orders.admin.edit');
        Route::get('/orders/{order}/update', [OrderAdminController::class, 'update'])->name('orders.admin.update');
        Route::delete('/orders/{order}', [OrderAdminController::class, 'destroy'])->name('orders.admin.destroy');
        Route::get('/orders/export/csv', [OrderAdminController::class, 'exportCSV'])->name('orders.admin.exportCSV');
        Route::get('/orders/{order}/print', [OrderAdminController::class, 'print'])->name('orders.admin.print');
        Route::patch('/orders/{order}/status', [OrderAdminController::class, 'updateStatus'])->name('orders.admin.updateStatus');
    });
});

Auth::routes(['verify' => true]);

Route::get('auth/{provider}', [SocialAuthController::class, 'redirect'])->name('oauth.redirect');
Route::get('auth/callback/{provider}', [SocialAuthController::class, 'callback']);

Route::middleware(['auth', 'verified'])->group(
    function () {
        // Page principale des commandes avec Livewire
        // Route::get('/my-orders', function () {
        //     return view('orders.index');
        // })->name('orders.index');

        // Route alternative si vous voulez utiliser un contrôleur
        Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');

        // Détails d'une commande spécifique
        Route::get('/orders/{order}', [OrderController::class, 'show'])
            ->name('orders.show'); // Politique pour s'assurer que l'utilisateur peut voir cette commande

        Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])
            ->name('orders.edit')
            ->middleware('can:update,order'); // si tu veux protéger
        Route::put('/orders/{order}', [OrderController::class, 'update'])
            ->name('orders.update')
            ->middleware('can:update,order');

        // Routes API pour les actions Livewire (optionnel - Livewire gère automatiquement)
        Route::post('/orders/{order}/cancel', [OrderController::class, 'cancel'])
            ->name('orders.cancel')
            ->middleware('can:cancel,order');

        // Route pour le processus de paiement
        Route::get('/payment/{order}/process', [OrderController::class, 'processPayment'])
            ->name('payment.process')
            ->middleware('can:pay,order');

        // Routes pour les avis (si implémentées)
        Route::post('/orders/{order}/review', [OrderController::class, 'storeReview'])
            ->name('orders.review.store')
            ->middleware('can:review,order');

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
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart-add', [CartController::class, 'add'])->name('cart.add');
Route::get('/show/{product}', [ProductController::class, 'showDetails'])->name('product.show');
Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/products/{product}/reviews/load-more', [ProductController::class, 'loadMoreReviews'])->name('product.reviews.load-more');
// Route::get('/products/{product}', ProductShow::class)
//     ->name('product.show')
//     ->where('product', '[0-9]+');
// WishList
Route::get('/wishlist', [WishListController::class, 'index'])->name('wishlist.index');
