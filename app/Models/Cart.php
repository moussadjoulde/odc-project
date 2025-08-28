<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtenir les articles du panier pour l'utilisateur/session actuelle
     */
    public static function getCartItems()
    {
        $query = self::with('product');

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        return $query->get();
    }

    /**
     * Obtenir le nombre total d'articles dans le panier
     */
    public static function getCartCount()
    {
        $query = self::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        return $query->sum('quantity');
    }

    /**
     * Obtenir le total du panier
     */
    public static function getCartTotal()
    {
        $query = self::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        return $query->get()->sum(function ($item) {
            return $item->quantity * $item->price;
        });
    }

    /**
     * Ajouter un produit au panier
     */
    public static function addToCart($productId, $quantity = 1)
    {
        $product = Product::find($productId);

        if (!$product) {
            return false;
        }

        $cartData = [
            'product_id' => $productId,
            'price' => $product->price,
        ];

        if (Auth::check()) {
            $cartData['user_id'] = Auth::id();
        } else {
            $cartData['session_id'] = Session::getId();
        }

        $existingItem = self::where($cartData)->first();

        if ($existingItem) {
            $existingItem->increment('quantity', $quantity);
            return $existingItem;
        } else {
            $cartData['quantity'] = $quantity;
            return self::create($cartData);
        }
    }

    /**
     * Supprimer un article du panier
     */
    public static function removeFromCart($cartItemId)
    {
        $query = self::where('id', $cartItemId);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        return $query->delete();
    }

    /**
     * Vider le panier
     */
    public static function clearCart()
    {
        $query = self::query();

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        return $query->delete();
    }

    /**
     * Mettre à jour la quantité d'un article
     */
    public static function updateQuantity($cartItemId, $quantity)
    {
        $query = self::where('id', $cartItemId);

        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        if ($quantity <= 0) {
            return $query->delete();
        }

        return $query->update(['quantity' => $quantity]);
    }
}
