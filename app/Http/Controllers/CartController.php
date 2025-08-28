<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Afficher la page du panier
     */
    public function index()
    {
        return view('products.carts.index');
    }
}
