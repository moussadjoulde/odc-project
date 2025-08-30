@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- En-tête de la page -->
    <div class="page-header text-center">
        <div class="container position-relative">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="bi bi-heart-fill me-3"></i>
                        Mes Favoris
                    </h1>
                    <p class="lead opacity-90">
                        Retrouvez tous les produits que vous avez ajoutés à votre liste de souhaits
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12">
                @forelse ($wishlists as $wishlist)
                    <!-- Première itération pour créer la grille de cartes -->
                    @if ($loop->first)
                        <div class="row g-4">
                    @endif
                    
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                        <div class="floating-card h-100 overflow-hidden position-relative">
                            <!-- Badge favori -->
                            <div class="position-absolute top-0 end-0 z-index-10 p-3">
                                <button class="btn btn-link p-0 remove-favorite" 
                                        data-product-id="{{ $wishlist->product->id }}"
                                        title="Retirer des favoris">
                                    <i class="bi bi-heart-fill text-danger fs-4"></i>
                                </button>
                            </div>

                            <!-- Image du produit -->
                            <div class="position-relative overflow-hidden" style="height: 250px;">
                                @if($wishlist->product->image)
                                    <img src="{{ asset('storage/' . $wishlist->product->image) }}" 
                                         alt="{{ $wishlist->product->name }}"
                                         class="w-100 h-100 object-fit-cover transition-transform"
                                         style="transition: transform 0.3s ease;">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light">
                                        <i class="bi bi-image text-muted" style="font-size: 3rem;"></i>
                                    </div>
                                @endif
                                
                                <!-- Overlay au survol -->
                                <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark bg-opacity-0 d-flex align-items-center justify-content-center opacity-0 transition-all product-overlay">
                                    <div class="text-center">
                                        <a href="{{ route('products.show', $wishlist->product) }}" 
                                           class="btn btn-modern me-2">
                                            <i class="bi bi-eye me-1"></i>
                                            Voir
                                        </a>
                                        <button class="btn btn-outline-light rounded-pill">
                                            <i class="bi bi-cart-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Contenu de la carte -->
                            <div class="p-4">
                                <!-- Nom du produit -->
                                <h5 class="card-title fw-bold mb-2 text-truncate" title="{{ $wishlist->product->name }}">
                                    {{ $wishlist->product->name }}
                                </h5>

                                <!-- Description courte -->
                                @if($wishlist->product->description)
                                    <p class="text-muted mb-3 small" style="height: 40px; overflow: hidden;">
                                        {{ Str::limit($wishlist->product->description, 80) }}
                                    </p>
                                @endif

                                <!-- Prix -->
                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <div>
                                        @if($wishlist->product->discount_price)
                                            <span class="fw-bold fs-5 text-success">
                                                {{ number_format($wishlist->product->discount_price, 0, ',', ' ') }} FCFA
                                            </span>
                                            <small class="text-muted text-decoration-line-through ms-1">
                                                {{ number_format($wishlist->product->price, 0, ',', ' ') }} FCFA
                                            </small>
                                        @else
                                            <span class="fw-bold fs-5 text-dark">
                                                {{ number_format($wishlist->product->price, 0, ',', ' ') }} FCFA
                                            </span>
                                        @endif
                                    </div>
                                    
                                    @if($wishlist->product->discount_price)
                                        <span class="badge bg-danger rounded-pill">
                                            -{{ round((($wishlist->product->price - $wishlist->product->discount_price) / $wishlist->product->price) * 100) }}%
                                        </span>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="d-flex gap-2">
                                    <a href="{{ route('products.show', $wishlist->product) }}" 
                                       class="btn btn-outline-primary rounded-pill flex-grow-1">
                                        <i class="bi bi-eye me-1"></i>
                                        Détails
                                    </a>
                                    <button class="btn btn-modern rounded-pill flex-grow-1 add-to-cart"
                                            data-product-id="{{ $wishlist->product->id }}">
                                        <i class="bi bi-cart-plus me-1"></i>
                                        Panier
                                    </button>
                                </div>

                                <!-- Date d'ajout -->
                                <div class="mt-3 pt-2 border-top">
                                    <small class="text-muted">
                                        <i class="bi bi-clock me-1"></i>
                                        Ajouté le {{ $wishlist->created_at->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Fermer la grille après la dernière itération -->
                    @if ($loop->last)
                        </div>
                    @endif

                @empty
                    <!-- État vide -->
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-8">
                            <div class="floating-card text-center py-5">
                                <div class="mb-4">
                                    <i class="bi bi-heart text-muted" style="font-size: 4rem;"></i>
                                </div>
                                <h3 class="fw-bold text-muted mb-3">Votre liste de favoris est vide</h3>
                                <p class="text-muted mb-4">
                                    Parcourez notre catalogue et ajoutez vos produits préférés à votre liste de souhaits.
                                </p>
                                <a href="{{ url('/shop') }}" class="btn btn-modern">
                                    <i class="bi bi-shop me-2"></i>
                                    Découvrir nos produits
                                </a>
                            </div>
                        </div>
                    </div>
                @endforelse

                @if(!$wishlists->isEmpty())
                    <!-- Statistiques -->
                    <div class="row mt-5">
                        <div class="col-12">
                            <div class="floating-card">
                                <div class="row text-center py-4">
                                    <div class="col-md-4">
                                        <div class="border-end border-light">
                                            <h4 class="fw-bold text-primary mb-1">{{ $wishlists->count() }}</h4>
                                            <small class="text-muted">Produits favoris</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="border-end border-light">
                                            <h4 class="fw-bold text-success mb-1">
                                                {{ number_format($wishlists->sum(function($item) { 
                                                    return $item->product->discount_price ?? $item->product->price; 
                                                }), 0, ',', ' ') }} FCFA
                                            </h4>
                                            <small class="text-muted">Valeur totale</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <h4 class="fw-bold text-info mb-1">
                                            {{ $wishlists->where('product.discount_price', '!=', null)->count() }}
                                        </h4>
                                        <small class="text-muted">En promotion</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Styles CSS personnalisés -->
<style>
    .product-overlay {
        transition: all 0.3s ease;
    }
    
    .floating-card:hover .product-overlay {
        opacity: 1 !important;
        background-color: rgba(0, 0, 0, 0.7) !important;
    }
    
    .floating-card:hover img {
        transform: scale(1.05);
    }
    
    .remove-favorite {
        transition: all 0.3s ease;
    }
    
    .remove-favorite:hover {
        transform: scale(1.1);
    }
    
    .transition-all {
        transition: all 0.3s ease;
    }
    
    .transition-transform {
        transition: transform 0.3s ease;
    }
    
    .z-index-10 {
        z-index: 10;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 2rem 0;
        }
        
        .floating-card .row.text-center > div {
            border-bottom: 1px solid #eee;
            border-right: none !important;
            padding: 1rem 0;
        }
        
        .floating-card .row.text-center > div:last-child {
            border-bottom: none;
        }
    }
</style>

<!-- JavaScript pour les interactions -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion de la suppression des favoris
    document.querySelectorAll('.remove-favorite').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.productId;
            
            // Animation de suppression
            const card = this.closest('.col-xl-3, .col-lg-4, .col-md-6, .col-sm-12');
            card.style.transform = 'scale(0.8)';
            card.style.opacity = '0.5';
            
            // Simuler la suppression (vous devrez implémenter l'appel AJAX réel)
            setTimeout(() => {
                // showToast('success', 'Produit retiré de vos favoris');
                // card.remove();
                console.log('Retirer le produit ID:', productId, 'des favoris');
            }, 300);
        });
    });
    
    // Gestion de l'ajout au panier
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.dataset.productId;
            
            // Animation du bouton
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="bi bi-check-circle me-1"></i>Ajouté!';
            this.classList.remove('btn-modern');
            this.classList.add('btn-success');
            
            // Restaurer le bouton après 2 secondes
            setTimeout(() => {
                this.innerHTML = originalText;
                this.classList.remove('btn-success');
                this.classList.add('btn-modern');
            }, 2000);
            
            // showToast('success', 'Produit ajouté au panier');
            console.log('Ajouter le produit ID:', productId, 'au panier');
        });
    });
});
</script>
@endsection