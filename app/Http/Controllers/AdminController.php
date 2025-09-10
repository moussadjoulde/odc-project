<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $products = Product::latest()->get();
        $categories = Category::latest()->get();
        $orders = Order::latest()->get();
        $users = User::latest()->get();
        return view('admin.dashboard', compact('products', 'categories', 'orders'));
    }

    public function productsIndex()
    {
        $products = Product::latest()->get();
        return view('products.index', compact('products'));
    }

    public function categoriesIndex()
    {
        $categories = Category::latest()->get();
        return view('categories.index', compact('categories'));
    }
}
