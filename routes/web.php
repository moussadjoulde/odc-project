<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::resource('products', ProductController::class);
Route::get('products/export/csv', [ProductController::class, 'exportCSV'])->name('products.exportCSV');
Route::get('products/{id}/export/csv', [ProductController::class, 'exportCSVWithId'])->name('products.exportCSVWithId');
