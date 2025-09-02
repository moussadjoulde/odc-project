<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\WishList;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ShopFilter extends Component
{
    use WithPagination;

    // Propriétés pour les filtres
    public $search = '';
    public $category = 'all';
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $brands = [];
    public $rating = '';
    public $sortBy = 'newest';

    // Propriétés pour les données disponibles
    public $availableBrands = [];
    public $availableCategories = [];

    protected $paginationTheme = 'bootstrap';

    // Propriété pour stocker les favoris
    public $userWishList = [];

    // Propriétés à surveiller pour réinitialiser la pagination
    protected $updatesQueryString = [
        'search' => ['except' => ''],
        'category' => ['except' => 'all'],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 1000],
        'brands' => ['except' => []],
        'rating' => ['except' => ''],
        'sortBy' => ['except' => 'newest'],
    ];

    protected $listeners = [
        'searchProducts' => 'updateSearch',
        'resetFilters' => 'resetAllFilters'
    ];

    public function mount()
    {
        // Initialiser les marques disponibles
        $this->availableBrands = Product::select('brand')
            ->distinct()
            ->whereNotNull('brand')
            ->where('brand', '!=', '')
            ->orderBy('brand')
            ->pluck('brand')
            ->toArray();

        // Initialiser les catégories disponibles
        $this->availableCategories = Category::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name'])
            ->toArray();

        // Définir les prix min et max basés sur les produits existants
        $priceRange = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
        if ($priceRange) {
            $this->minPrice = 0; // Toujours commencer à 0 pour l'affichage
            $this->maxPrice = ceil($priceRange->max_price ?? 1000);
        }

        // Initialiser la wishlist de l'utilisateur
        $this->loadUserWishList();
    }

    /**
     * Charger la wishlist de l'utilisateur
     */
    private function loadUserWishList()
    {
        if (Auth::check()) {
            $this->userWishList = WishList::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        } else {
            $this->userWishList = [];
        }
    }

    /**
     * Mettre à jour la recherche
     */
    public function updateSearch($searchTerm)
    {
        $this->search = $searchTerm;
        $this->resetPage();
    }

    /**
     * Ajouter un produit au panier
     */
    public function addToCart($productId, $quantity = 1)
    {
        // if (!Auth::check()) {
        //     $this->dispatch('showToast', [
        //         'type' => 'warning',
        //         'message' => 'Veuillez vous connecter pour ajouter au panier.'
        //     ]);
        //     return redirect()->route('login');
        // }

        try {
            // Vérifier si le produit existe et est disponible
            $product = Product::findOrFail($productId);

            if ($product->stock_quantity < $quantity) {
                $this->dispatch('showToast', [
                    'type' => 'error',
                    'message' => 'Stock insuffisant pour ce produit.'
                ]);
                return;
            }

            Cart::addToCart($productId, $quantity);

            // Émettre un événement pour mettre à jour l'indicateur du panier
            $this->dispatch('cartUpdated');

            // Afficher un message de succès
            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Produit ajouté au panier !'
            ]);

            // Animation du bouton
            $this->dispatch('animateCartButton', ['productId' => $productId]);
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de l\'ajout au panier.'
            ]);
        }
    }

    /**
     * Gérer les favoris
     */
    public function toggleWishList($productId)
    {
        if (!Auth::check()) {
            $this->dispatch('showToast', [
                'type' => 'warning',
                'message' => 'Veuillez vous connecter pour gérer vos favoris.'
            ]);
            return redirect()->route('login');
        }

        try {
            $existingWishList = WishList::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($existingWishList) {
                $existingWishList->delete();
                // Retirer de la liste locale
                $this->userWishList = array_values(array_filter($this->userWishList, function ($id) use ($productId) {
                    return $id != $productId;
                }));
                $message = 'Produit retiré des favoris.';
                $action = 'removed';
            } else {
                WishList::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId
                ]);
                // Ajouter à la liste locale
                $this->userWishList[] = $productId;
                $message = 'Produit ajouté aux favoris !';
                $action = 'added';
            }

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => $message
            ]);

            // Animation du bouton wishlist
            $this->dispatch('animateWishlistButton', [
                'productId' => $productId,
                'action' => $action
            ]);
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de la mise à jour des favoris.'
            ]);
        }
    }

    /**
     * Vérifier si un produit est dans la WishList
     */
    public function isInWishList($productId)
    {
        return in_array($productId, $this->userWishList);
    }

    /**
     * Définir la catégorie de filtrage
     */
    public function setCategory($categoryId)
    {
        $this->category = $categoryId;
        $this->resetPage();
        $this->updateAvailableBrands();
    }

    /**
     * Appliquer le filtre de prix via le range slider
     */
    public function updatedMinPrice()
    {
        if ($this->minPrice < 0) {
            $this->minPrice = 0;
        }
        if ($this->minPrice > $this->maxPrice) {
            $this->minPrice = $this->maxPrice;
        }
        $this->resetPage();
    }

    public function updatedMaxPrice()
    {
        if ($this->maxPrice < $this->minPrice) {
            $this->maxPrice = $this->minPrice;
        }
        $this->resetPage();
    }

    /**
     * Basculer une marque dans le filtre
     */
    public function toggleBrand($brand)
    {
        if (in_array($brand, $this->brands)) {
            $this->brands = array_values(array_filter($this->brands, function ($b) use ($brand) {
                return $b !== $brand;
            }));
        } else {
            $this->brands[] = $brand;
        }
        $this->resetPage();
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
     * Définir la note minimum
     */
    public function setRating($rating)
    {
        $this->rating = $this->rating === $rating ? '' : $rating;
        $this->resetPage();
    }

    /**
     * Réinitialiser tous les filtres
     */
    public function resetAllFilters()
    {
        $this->search = '';
        $this->category = 'all';
        $this->brands = [];
        $this->rating = '';
        $this->sortBy = 'newest';

        // Réinitialiser les prix au maximum disponible
        $priceRange = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
        if ($priceRange) {
            $this->minPrice = 0;
            $this->maxPrice = ceil($priceRange->max_price ?? 1000);
        } else {
            $this->minPrice = 0;
            $this->maxPrice = 1000;
        }

        $this->resetPage();
        $this->updateAvailableBrands();

        $this->dispatch('showToast', [
            'type' => 'info',
            'message' => 'Filtres réinitialisés'
        ]);
    }

    /**
     * Mettre à jour les marques disponibles selon la catégorie
     */
    private function updateAvailableBrands()
    {
        $query = Product::select('brand')
            ->distinct()
            ->whereNotNull('brand')
            ->where('brand', '!=', '');

        if ($this->category !== 'all') {
            $query->where('category_id', $this->category);
        }

        $this->availableBrands = $query->orderBy('brand')
            ->pluck('brand')
            ->toArray();
    }

    /**
     * Propriété calculée pour obtenir les produits filtrés
     */
    public function getProductsProperty()
    {
        $query = Product::with(['category'])
            ->where('is_active', true);

        // Filtrer par recherche
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('description', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('brand', 'LIKE', '%' . $this->search . '%');
            });
        }

        // Filtrer par catégorie
        if ($this->category !== 'all') {
            $query->where('category_id', $this->category);
        }

        // Filtrer par prix
        if ($this->minPrice > 0 || $this->maxPrice < 10000) {
            $query->whereBetween('price', [$this->minPrice, $this->maxPrice]);
        }

        // Filtrer par marques
        if (!empty($this->brands)) {
            $query->whereIn('brand', $this->brands);
        }

        // Filtrer par note
        if ($this->rating !== '') {
            $minRating = (float) $this->rating;
            $query->where('rating', '>=', $minRating);
        }

        // Trier
        switch ($this->sortBy) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc')
                    ->orderBy('review_count', 'desc');
                break;
            case 'popular':
                $query->orderBy('review_count', 'desc')
                    ->orderBy('rating', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate(12);
    }

    /**
     * Obtenir le nombre total de résultats
     */
    public function getResultsCountProperty()
    {
        return $this->products->total();
    }

    /**
     * Vérifier si des filtres sont appliqués
     */
    public function getHasFiltersProperty()
    {
        return !empty($this->search) ||
            $this->category !== 'all' ||
            !empty($this->brands) ||
            $this->rating !== '' ||
            $this->minPrice > 0 ||
            $this->maxPrice < 10000;
    }

    /**
     * Obtenir le texte du filtre actuel pour l'affichage
     */
    public function getCurrentFilterTextProperty()
    {
        $filters = [];

        if (!empty($this->search)) {
            $filters[] = "Recherche: \"{$this->search}\"";
        }

        if ($this->category !== 'all') {
            $categoryName = collect($this->availableCategories)->firstWhere('id', $this->category)['name'] ?? '';
            if ($categoryName) {
                $filters[] = "Catégorie: {$categoryName}";
            }
        }

        if (!empty($this->brands)) {
            $filters[] = "Marques: " . implode(', ', $this->brands);
        }

        if ($this->rating !== '') {
            $filters[] = "Note: {$this->rating}+ étoiles";
        }

        if ($this->minPrice > 0 || $this->maxPrice < 10000) {
            $filters[] = "Prix: {$this->minPrice}€ - {$this->maxPrice}€";
        }

        return implode(' | ', $filters);
    }

    /**
     * Formater le prix pour l'affichage
     */
    public function formatPrice($price)
    {
        return number_format($price, 0, ',', ' ') . '€';
    }

    /**
     * Générer les étoiles pour l'affichage des notes
     */
    public function generateStars($rating)
    {
        $stars = '';
        $fullStars = floor($rating);
        $halfStar = $rating - $fullStars >= 0.5;

        for ($i = 0; $i < $fullStars; $i++) {
            $stars .= '★';
        }

        if ($halfStar) {
            $stars .= '☆';
        }

        $remainingStars = 5 - $fullStars - ($halfStar ? 1 : 0);
        for ($i = 0; $i < $remainingStars; $i++) {
            $stars .= '☆';
        }

        return $stars;
    }

    public function render()
    {
        return view('livewire.shop-filter', [
            'products' => $this->products,
            'resultsCount' => $this->resultsCount,
            'hasFilters' => $this->hasFilters,
            'currentFilterText' => $this->currentFilterText
        ]);
    }
}
