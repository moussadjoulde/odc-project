<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    public function index()
    {
        $wishlists = WishList::where('user_id', Auth::id())->latest()->get();
        return view('wishlist.index', compact('wishlists'));
    }
}
