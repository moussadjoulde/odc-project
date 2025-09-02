<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Review;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProductShow extends Component
{
    // Propriété principale
    public Product $product;

    // Propriétés pour l'interaction
    public $quantity = 1;
    public $selectedImageIndex = 0;
    public $activeTab = 'description';

    // Propriétés pour les avis
    public $reviewRating = 5;
    public $reviewTitle = '';
    public $reviewComment = '';
    public $reviewsOffset = 5;
    public $showAllReviews = false;

    // Propriétés pour l'état
    public $isInWishList = false;
    public $userReview = null;
    public $similarProducts = [];
    public $reviews = [];
    public $reviewsCount = 0;

    protected $rules = [
        'quantity' => 'required|integer|min:1',
        'reviewRating' => 'required|integer|min:1|max:5',
        'reviewTitle' => 'required|string|max:255',
        'reviewComment' => 'required|string|min:10',
    ];

    protected $messages = [
        'reviewRating.required' => 'Veuillez sélectionner une note.',
        'reviewTitle.required' => 'Le titre est obligatoire.',
        'reviewComment.required' => 'Le commentaire est obligatoire.',
        'reviewComment.min' => 'Le commentaire doit contenir au moins 10 caractères.',
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->loadInitialData();
    }

    private function loadInitialData()
    {
        // Vérifier si le produit est en wishlist
        if (Auth::check()) {
            $this->isInWishList = WishList::where('user_id', Auth::id())
                ->where('product_id', $this->product->id)
                ->exists();

            // Charger l'avis existant de l'utilisateur
            $this->userReview = Review::where('user_id', Auth::id())
                ->where('product_id', $this->product->id)
                ->first();
        }

        // Charger les produits similaires
        $this->loadSimilarProducts();

        // Charger les avis
        $this->loadReviews();
    }

    private function loadSimilarProducts()
    {
        $this->similarProducts = Product::where('id', '!=', $this->product->id)
            ->where('is_active', true)
            ->where(function ($query) {
                if ($this->product->category_id) {
                    $query->where('category_id', $this->product->category_id);
                }
                if ($this->product->brand) {
                    $query->orWhere('brand', $this->product->brand);
                }
            })
            ->orWhere('is_featured', true)
            ->inRandomOrder()
            ->limit(4)
            ->latest()
            ->get();
    }

    private function loadReviews()
    {
        $this->reviews = $this->product->reviews()
            ->with('user')
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $this->reviewsCount = $this->product->reviews()
            ->where('approved', true)
            ->count();
    }

    public function increaseQuantity()
    {
        if ($this->quantity < $this->product->stock_quantity) {
            $this->quantity++;
        }
    }

    public function decreaseQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function updatedQuantity()
    {
        if ($this->quantity < 1) {
            $this->quantity = 1;
        } elseif ($this->quantity > $this->product->stock_quantity) {
            $this->quantity = $this->product->stock_quantity;
        }
    }

    public function addToCart()
    {
        $this->validate(['quantity' => 'required|integer|min:1|max:' . $this->product->stock_quantity]);

        if (!$this->product->in_stock) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Ce produit n\'est plus en stock.'
            ]);
            return;
        }

        try {
            Cart::addToCart($this->product->id, $this->quantity);

            $this->dispatch('cartUpdated');
            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => $this->quantity . ' article(s) ajouté(s) au panier avec succès !'
            ]);

            // Réinitialiser la quantité
            $this->quantity = 1;
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de l\'ajout au panier.'
            ]);
        }
    }

    public function toggleWishList()
    {
        if (!Auth::check()) {
            $this->dispatch('showToast', [
                'type' => 'warning',
                'message' => 'Veuillez vous connecter pour ajouter à vos favoris.'
            ]);
            return redirect()->route('login');
        }

        try {
            $existingWishList = WishList::where('user_id', Auth::id())
                ->where('product_id', $this->product->id)
                ->first();

            if ($existingWishList) {
                $existingWishList->delete();
                $this->isInWishList = false;
                $message = 'Produit retiré des favoris.';
            } else {
                WishList::create([
                    'user_id' => Auth::id(),
                    'product_id' => $this->product->id
                ]);
                $this->isInWishList = true;
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

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function selectImage($index)
    {
        $this->selectedImageIndex = $index;
    }

    public function submitReview()
    {
        if (!Auth::check()) {
            $this->dispatch('showToast', [
                'type' => 'warning',
                'message' => 'Veuillez vous connecter pour laisser un avis.'
            ]);
            return redirect()->route('login');
        }

        $this->validate();

        // Vérifier si l'utilisateur a déjà laissé un avis
        if ($this->userReview) {
            $this->dispatch('showToast', [
                'type' => 'warning',
                'message' => 'Vous avez déjà laissé un avis pour ce produit.'
            ]);
            return;
        }

        try {
            Review::create([
                'user_id' => Auth::id(),
                'product_id' => $this->product->id,
                'rating' => $this->reviewRating,
                'title' => $this->reviewTitle,
                'comment' => $this->reviewComment,
                'approved' => false // En attente d'approbation
            ]);

            // Réinitialiser le formulaire
            $this->reviewRating = 5;
            $this->reviewTitle = '';
            $this->reviewComment = '';

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Votre avis a été soumis et est en attente d\'approbation.'
            ]);

            // Recharger les données utilisateur
            $this->userReview = Review::where('user_id', Auth::id())
                ->where('product_id', $this->product->id)
                ->first();
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de la soumission de votre avis.'
            ]);
        }
    }

    public function loadMoreReviews()
    {
        $additionalReviews = $this->product->reviews()
            ->with('user')
            ->where('approved', true)
            ->orderBy('created_at', 'desc')
            ->skip($this->reviewsOffset)
            ->take(5)
            ->get();

        $this->reviews = $this->reviews->merge($additionalReviews);
        $this->reviewsOffset += 5;

        if ($additionalReviews->count() < 5) {
            $this->showAllReviews = true;
        }
    }

    public function addSimilarToCart($productId)
    {
        try {
            Cart::addToCart($productId, 1);

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

    public function share()
    {
        $url = route('product.show', $this->product->id);

        // Copier l'URL dans le presse-papier via JavaScript
        $this->dispatch('copyToClipboard', ['url' => $url]);
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Lien copié dans le presse-papier !'
        ]);
    }

    // Propriétés calculées
    public function getDiscountPercentageProperty()
    {
        if ($this->product->old_price && $this->product->old_price > $this->product->price) {
            return round((($this->product->old_price - $this->product->price) / $this->product->old_price) * 100);
        }
        return null;
    }

    public function getSavingsProperty()
    {
        if ($this->product->old_price && $this->product->old_price > $this->product->price) {
            return $this->product->old_price - $this->product->price;
        }
        return null;
    }

    public function getRatingDistributionProperty()
    {
        $distribution = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

        if ($this->product->review_count > 0) {
            // Simulation de données (remplacer par vraies données en production)
            $distribution[5] = round(($this->product->rating / 5) * $this->product->review_count * 0.6);
            $distribution[4] = round(($this->product->rating / 5) * $this->product->review_count * 0.3);
            $distribution[3] = round(($this->product->rating / 5) * $this->product->review_count * 0.1);
            $distribution[2] = round($this->product->review_count * 0.05);
            $distribution[1] = round($this->product->review_count * 0.05);
        }

        return $distribution;
    }

    public function render()
    {
        return view('livewire.product-show')
            ->layout('layouts.app');
    }
}
