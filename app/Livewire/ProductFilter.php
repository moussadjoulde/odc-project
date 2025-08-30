<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\WishList;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ProductFilter extends Component
{
    use WithPagination;

    // Propriétés pour les filtres
    public $category = 'all';
    public $minPrice = 0;
    public $maxPrice = 1000;
    public $brands = [];
    public $rating = '';
    public $sortBy = 'newest';
    public $viewType = 'grid';

    // Propriétés pour les données disponibles
    public $availableBrands = [];
    public $availableCategories = [];

    protected $paginationTheme = 'bootstrap';

    // CORRECTION : Propriété pour stocker les favoris
    public $userWishList = [];

    // Propriétés à surveiller pour réinitialiser la pagination
    protected $updatesQueryString = [
        'category' => ['except' => 'all'],
        'minPrice' => ['except' => 0],
        'maxPrice' => ['except' => 1000],
        'brands' => ['except' => []],
        'rating' => ['except' => ''],
        'sortBy' => ['except' => 'newest'],
        'viewType' => ['except' => 'grid'],
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
            $this->minPrice = floor($priceRange->min_price ?? 0);
            $this->maxPrice = ceil($priceRange->max_price ?? 1000);
        }

        // AJOUT : Initialiser la wishlist de l'utilisateur
        $this->loadUserWishList();
    }

    /**
     * AJOUT : Charger la wishlist de l'utilisateur
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
     * Ajouter un produit au panier
     */
    public function addToCart($productId, $quantity = 1)
    {
        try {
            Cart::addToCart($productId, $quantity);

            // Émettre un événement pour mettre à jour l'indicateur du panier
            $this->dispatch('cartUpdated');

            // Afficher un message de succès
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
     * CORRECTION : Nom de méthode cohérent
     */
    public function toggleWishList($productId)
    {
        if (!Auth::check()) {
            $this->dispatch('showToast', [
                'type' => 'warning',
                'message' => 'Veuillez vous connecter pour ajouter à vos favoris.'
            ]);
            return;
        }

        try {
            $existingWishList = WishList::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->first();

            if ($existingWishList) {
                $existingWishList->delete();
                // AJOUT : Retirer de la liste locale
                $this->userWishList = array_values(array_filter($this->userWishList, function ($id) use ($productId) {
                    return $id != $productId;
                }));
                $message = 'Produit retiré des favoris.';
            } else {
                WishList::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId
                ]);
                // AJOUT : Ajouter à la liste locale
                $this->userWishList[] = $productId;
                $message = 'Produit ajouté aux favoris !';
            }

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => $message
            ]);
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de la mise à jour des favoris.'
            ]);
        }
    }

    /**
     * MODIFICATION : Vérifier si un produit est dans la WishList (version optimisée)
     */
    public function isInWishList($productId)
    {
        return in_array($productId, $this->userWishList);
    }

    // ... (le reste des méthodes reste identique)

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
     * Appliquer le filtre de prix
     */
    public function applyPriceFilter()
    {
        if ($this->minPrice < 0) {
            $this->minPrice = 0;
        }

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
     * Définir le type d'affichage
     */
    public function setViewType($viewType)
    {
        $this->viewType = $viewType;
    }

    /**
     * Réinitialiser tous les filtres
     */
    public function resetFilters()
    {
        $this->category = 'all';
        $this->brands = [];
        $this->rating = '';
        $this->sortBy = 'newest';

        $priceRange = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();
        if ($priceRange) {
            $this->minPrice = floor($priceRange->min_price ?? 0);
            $this->maxPrice = ceil($priceRange->max_price ?? 1000);
        } else {
            $this->minPrice = 0;
            $this->maxPrice = 1000;
        }

        $this->resetPage();
        $this->updateAvailableBrands();
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
        $query = Product::query();

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

    // Méthodes de cycle de vie Livewire
    public function updatedCategory()
    {
        $this->resetPage();
        $this->updateAvailableBrands();
    }

    public function updatedBrands()
    {
        $this->resetPage();
    }

    public function updatedRating()
    {
        $this->resetPage();
    }

    public function updatedMinPrice()
    {
        if ($this->minPrice < 0) {
            $this->minPrice = 0;
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
     * Obtenir le nombre total de résultats pour l'affichage
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
        return $this->category !== 'all' ||
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

    public function render()
    {
        return view('livewire.product-filter', [
            'products' => $this->products
        ]);
    }
}
