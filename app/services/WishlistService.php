<?php

namespace App\Services;

use App\Models\WishList;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class WishlistService
{
    /**
     * Ajouter un produit à la wishlist
     */
    public static function add($productId, $userId = null): bool
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return false;
        }

        // Vérifier si le produit existe et est actif
        $product = Product::where('id', $productId)->where('is_active', true)->first();
        if (!$product) {
            return false;
        }

        // Vérifier si le produit n'est pas déjà dans la wishlist
        $exists = WishList::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        if ($exists) {
            return false;
        }

        // Ajouter à la wishlist
        WishList::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return true;
    }

    /**
     * Retirer un produit de la wishlist
     */
    public static function remove($productId, $userId = null): bool
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return false;
        }

        $deleted = WishList::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();

        return $deleted > 0;
    }

    /**
     * Basculer un produit dans la wishlist (ajouter/retirer)
     */
    public static function toggle($productId, $userId = null): array
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return ['success' => false, 'message' => 'Utilisateur non authentifié', 'action' => null];
        }

        $existingWishList = WishList::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingWishList) {
            $existingWishList->delete();
            return [
                'success' => true,
                'message' => 'Produit retiré des favoris',
                'action' => 'removed',
                'inWishlist' => false
            ];
        } else {
            // Vérifier si le produit existe
            $product = Product::where('id', $productId)->where('is_active', true)->first();
            if (!$product) {
                return ['success' => false, 'message' => 'Produit non trouvé', 'action' => null];
            }

            WishList::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);

            return [
                'success' => true,
                'message' => 'Produit ajouté aux favoris',
                'action' => 'added',
                'inWishlist' => true
            ];
        }
    }

    /**
     * Vérifier si un produit est dans la wishlist
     */
    public static function isInWishlist($productId, $userId = null): bool
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return false;
        }

        return WishList::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();
    }

    /**
     * Obtenir le nombre d'éléments dans la wishlist
     */
    public static function count($userId = null): int
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return 0;
        }

        return WishList::where('user_id', $userId)->count();
    }

    /**
     * Obtenir tous les produits de la wishlist d'un utilisateur
     */
    public static function getItems($userId = null): Collection
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return collect();
        }

        return WishList::where('user_id', $userId)
            ->with(['product' => function ($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Obtenir les IDs des produits dans la wishlist
     */
    public static function getProductIds($userId = null): array
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return [];
        }

        return WishList::where('user_id', $userId)
            ->pluck('product_id')
            ->toArray();
    }

    /**
     * Vider complètement la wishlist
     */
    public static function clear($userId = null): int
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return 0;
        }

        return WishList::where('user_id', $userId)->delete();
    }

    /**
     * Obtenir les statistiques de la wishlist
     */
    public static function getStats($userId = null): array
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return [
                'total_items' => 0,
                'total_value' => 0,
                'discounted_items' => 0,
                'average_price' => 0
            ];
        }

        $wishlists = WishList::where('user_id', $userId)
            ->with(['product' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();

        $totalItems = $wishlists->count();
        $products = $wishlists->pluck('product')->filter();

        $totalValue = $products->sum(function ($product) {
            return $product->discount_price ?? $product->price;
        });

        $discountedItems = $products->where('discount_price', '!=', null)->count();
        $averagePrice = $totalItems > 0 ? $totalValue / $totalItems : 0;

        return [
            'total_items' => $totalItems,
            'total_value' => $totalValue,
            'discounted_items' => $discountedItems,
            'average_price' => $averagePrice
        ];
    }

    /**
     * Obtenir les produits similaires basés sur la wishlist
     */
    public static function getSimilarProducts($userId = null, $limit = 6): Collection
    {
        $userId = $userId ?? Auth::id();

        if (!$userId) {
            return collect();
        }

        // Obtenir les catégories des produits dans la wishlist
        $categoryIds = WishList::where('user_id', $userId)
            ->join('products', 'wish_lists.product_id', '=', 'products.id')
            ->pluck('products.category_id')
            ->unique()
            ->toArray();

        if (empty($categoryIds)) {
            return collect();
        }

        // Obtenir les IDs des produits déjà dans la wishlist
        $wishlistProductIds = static::getProductIds($userId);

        // Trouver des produits similaires
        return Product::whereIn('category_id', $categoryIds)
            ->whereNotIn('id', $wishlistProductIds)
            ->where('is_active', true)
            ->orderBy('rating', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
