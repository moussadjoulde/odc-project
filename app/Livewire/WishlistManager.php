<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Cart;
use App\Models\WishList;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class WishlistManager extends Component
{
    use WithPagination;

    // Propriétés pour les filtres
    public $sortBy = 'newest';
    public $viewType = 'grid';

    // Propriétés calculées pour les statistiques
    public $totalItems = 0;
    public $totalValue = 0;
    public $discountedItems = 0;

    protected $paginationTheme = 'bootstrap';

    protected $updatesQueryString = [
        'sortBy' => ['except' => 'newest'],
        'viewType' => ['except' => 'grid'],
    ];

    protected $listeners = [
        'wishlistUpdated' => 'refreshWishlist',
    ];

    public function mount()
    {
        // Rediriger si l'utilisateur n'est pas connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->calculateStatistics();
    }

    /**
     * Calculer les statistiques de la wishlist
     */
    private function calculateStatistics()
    {
        if (!Auth::check()) {
            return;
        }

        $wishlists = WishList::where('user_id', Auth::id())
            ->with('product')
            ->get();

        $this->totalItems = $wishlists->count();

        $this->totalValue = $wishlists->sum(function ($item) {
            return $item->product->discount_price ?? $item->product->price;
        });

        $this->discountedItems = $wishlists->where('product.discount_price', '!=', null)->count();
    }

    /**
     * Rafraîchir la wishlist après une modification
     */
    public function refreshWishlist()
    {
        $this->calculateStatistics();
        $this->render();
    }

    /**
     * Retirer un produit de la wishlist
     */
    public function removeFromWishlist($productId)
    {
        if (!Auth::check()) {
            $this->dispatch('showToast', [
                'type' => 'warning',
                'message' => 'Veuillez vous connecter pour gérer vos favoris.'
            ]);
            return;
        }

        try {
            $wishlistItem = WishList::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($wishlistItem) {
                $wishlistItem->delete();

                // Recalculer les statistiques
                $this->calculateStatistics();

                $this->dispatch('showToast', [
                    'type' => 'success',
                    'message' => 'Produit retiré de vos favoris.'
                ]);

                // Émettre un événement pour mettre à jour d'autres composants
                $this->dispatch('wishlistUpdated');

                // Si on est sur la dernière page et qu'elle devient vide, revenir à la page précédente
                if ($this->wishlists->isEmpty() && $this->wishlists->currentPage() > 1) {
                    $this->previousPage();
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression du produit.'
            ]);
        }
    }

    /**
     * Ajouter un produit au panier
     */
    public function addToCart($productId, $quantity = 1)
    {
        try {
            // Vérifier que le produit existe
            $product = Product::findOrFail($productId);

            Cart::addToCart($productId, $quantity);

            // Émettre un événement pour mettre à jour l'indicateur du panier
            $this->dispatch('cartUpdated');

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Produit ajouté au panier !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de l\'ajout au panier.'
            ]);
        }
    }

    /**
     * Ajouter tous les produits de la wishlist au panier
     */
    public function addAllToCart()
    {
        if (!Auth::check()) {
            return;
        }

        try {
            $wishlists = WishList::where('user_id', Auth::id())
                ->with('product')
                ->get();

            $addedCount = 0;
            foreach ($wishlists as $wishlist) {
                if ($wishlist->product && $wishlist->product->is_active) {
                    Cart::addToCart($wishlist->product->id, 1);
                    $addedCount++;
                }
            }

            if ($addedCount > 0) {
                $this->dispatch('cartUpdated');
                $this->dispatch('showToast', [
                    'type' => 'success',
                    'message' => "{$addedCount} produit(s) ajouté(s) au panier !"
                ]);
            } else {
                $this->dispatch('showToast', [
                    'type' => 'warning',
                    'message' => 'Aucun produit disponible à ajouter au panier.'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de l\'ajout des produits au panier.'
            ]);
        }
    }

    /**
     * Vider complètement la wishlist
     */
    public function clearWishlist()
    {
        if (!Auth::check()) {
            return;
        }

        try {
            WishList::where('user_id', Auth::id())->delete();

            $this->calculateStatistics();

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Votre liste de favoris a été vidée.'
            ]);

            $this->dispatch('wishlistUpdated');

            // Revenir à la première page
            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression des favoris.'
            ]);
        }
    }

    /**
     * Définir le tri
     */
    public function setSortBy($sortBy)
    {
        $this->sortBy = $sortBy;
        $this->resetPage();
    }

    /**
     * Définir le type d'affichage
     */
    public function setViewType($viewType)
    {
        $this->viewType = $viewType;
    }

    /**
     * Obtenir les produits de la wishlist avec tri et pagination
     */
    public function getWishlistsProperty()
    {
        if (!Auth::check()) {
            return collect();
        }

        $query = WishList::where('user_id', Auth::id())
            ->with(['product' => function ($query) {
                $query->where('is_active', true);
            }]);

        // Appliquer le tri
        switch ($this->sortBy) {
            case 'name_asc':
                $query->join('products', 'wish_lists.product_id', '=', 'products.id')
                    ->orderBy('products.name', 'asc')
                    ->select('wish_lists.*');
                break;

            case 'name_desc':
                $query->join('products', 'wish_lists.product_id', '=', 'products.id')
                    ->orderBy('products.name', 'desc')
                    ->select('wish_lists.*');
                break;

            case 'price_asc':
                $query->join('products', 'wish_lists.product_id', '=', 'products.id')
                    ->orderBy('products.price', 'asc')
                    ->select('wish_lists.*');
                break;

            case 'price_desc':
                $query->join('products', 'wish_lists.product_id', '=', 'products.id')
                    ->orderBy('products.price', 'desc')
                    ->select('wish_lists.*');
                break;

            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;

            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate(12);
    }

    /**
     * Vérifier si la wishlist est vide
     */
    public function getIsEmptyProperty()
    {
        return $this->totalItems === 0;
    }

    /**
     * Obtenir le texte de tri actuel
     */
    public function getCurrentSortTextProperty()
    {
        $sortOptions = [
            'newest' => 'Plus récents',
            'oldest' => 'Plus anciens',
            'name_asc' => 'Nom (A-Z)',
            'name_desc' => 'Nom (Z-A)',
            'price_asc' => 'Prix croissant',
            'price_desc' => 'Prix décroissant',
        ];

        return $sortOptions[$this->sortBy] ?? 'Plus récents';
    }

    /**
     * Calculer le pourcentage de réduction d'un produit
     */
    public function getDiscountPercentage($product)
    {
        if (!$product->discount_price || $product->discount_price >= $product->price) {
            return 0;
        }

        return round((($product->price - $product->discount_price) / $product->price) * 100);
    }

    /**
     * Formater un prix en FCFA
     */
    public function formatPrice($price)
    {
        return number_format($price, 0, ',', ' ') . ' FCFA';
    }

    public function render()
    {
        return view('livewire.wishlist-manager', [
            'wishlists' => $this->wishlists,
            'isEmpty' => $this->isEmpty,
            'currentSortText' => $this->currentSortText,
        ]);
    }
}
