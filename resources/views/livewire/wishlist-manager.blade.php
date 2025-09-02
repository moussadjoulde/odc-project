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
        @if(!$isEmpty)
            <!-- Barre d'outils -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="floating-card p-3">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <span class="text-muted me-3">
                                        {{ $wishlists->total() }} produit(s) dans vos favoris
                                    </span>
                                    <div class="btn-group me-3" role="group">
                                        <button type="button" 
                                                class="btn {{ $viewType === 'grid' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm"
                                                wire:click="setViewType('grid')">
                                            <i class="bi bi-grid-3x3-gap"></i>
                                        </button>
                                        <button type="button" 
                                                class="btn {{ $viewType === 'list' ? 'btn-primary' : 'btn-outline-primary' }} btn-sm"
                                                wire:click="setViewType('list')">
                                            <i class="bi bi-list"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-md-end gap-2 mt-3 mt-md-0">
                                    <!-- Tri -->
                                    <div class="dropdown">
                                        <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            <i class="bi bi-sort-down me-1"></i>
                                            {{ $currentSortText }}
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><button class="dropdown-item" wire:click="setSortBy('newest')">Plus récents</button></li>
                                            <li><button class="dropdown-item" wire:click="setSortBy('oldest')">Plus anciens</button></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><button class="dropdown-item" wire:click="setSortBy('name_asc')">Nom (A-Z)</button></li>
                                            <li><button class="dropdown-item" wire:click="setSortBy('name_desc')">Nom (Z-A)</button></li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li><button class="dropdown-item" wire:click="setSortBy('price_asc')">Prix croissant</button></li>
                                            <li><button class="dropdown-item" wire:click="setSortBy('price_desc')">Prix décroissant</button></li>
                                        </ul>
                                    </div>

                                    <!-- Actions groupées -->
                                    <button class="btn btn-success btn-sm" wire:click="addAllToCart" title="Ajouter tous au panier">
                                        <i class="bi bi-cart-plus me-1"></i>
                                        Tout ajouter
                                    </button>
                                    
                                    <button class="btn btn-outline-danger btn-sm" 
                                            wire:click="clearWishlist" 
                                            wire:confirm="Êtes-vous sûr de vouloir vider votre liste de favoris ?"
                                            title="Vider la wishlist">
                                        <i class="bi bi-trash me-1"></i>
                                        Vider
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Liste des produits -->
            <div class="row">
                <div class="col-12">
                    @if($viewType === 'grid')
                        <div class="row g-4">
                            @foreach ($wishlists as $wishlist)
                                @if($wishlist->product)
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                                        <div class="floating-card h-100 overflow-hidden position-relative">
                                            <!-- Badge favori -->
                                            <div class="position-absolute top-0 end-0 z-index-10 p-3">
                                                <button class="btn btn-link p-0" 
                                                        wire:click="removeFromWishlist({{ $wishlist->product->id }})"
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
                                                        <a href="{{ route('product.show', $wishlist->product) }}" 
                                                           class="btn btn-modern me-2">
                                                            <i class="bi bi-eye me-1"></i>
                                                            Voir
                                                        </a>
                                                        <button class="btn btn-outline-light rounded-pill"
                                                                wire:click="addToCart({{ $wishlist->product->id }})">
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
                                                                {{ $this->formatPrice($wishlist->product->discount_price) }}
                                                            </span>
                                                            <small class="text-muted text-decoration-line-through ms-1">
                                                                {{ $this->formatPrice($wishlist->product->price) }}
                                                            </small>
                                                        @else
                                                            <span class="fw-bold fs-5 text-dark">
                                                                {{ $this->formatPrice($wishlist->product->price) }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    
                                                    @if($wishlist->product->discount_price && $this->getDiscountPercentage($wishlist->product) > 0)
                                                        <span class="badge bg-danger rounded-pill">
                                                            -{{ $this->getDiscountPercentage($wishlist->product) }}%
                                                        </span>
                                                    @endif
                                                </div>

                                                <!-- Actions -->
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('product.show', $wishlist->product) }}" 
                                                       class="btn btn-outline-primary rounded-pill flex-grow-1">
                                                        <i class="bi bi-eye me-1"></i>
                                                        Détails
                                                    </a>
                                                    <button class="btn btn-modern rounded-pill flex-grow-1"
                                                            wire:click="addToCart({{ $wishlist->product->id }})">
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
                                @endif
                            @endforeach
                        </div>
                    @else
                        <!-- Vue liste -->
                        <div class="row">
                            @foreach ($wishlists as $wishlist)
                                @if($wishlist->product)
                                    <div class="col-12 mb-3">
                                        <div class="floating-card">
                                            <div class="row g-0 align-items-center">
                                                <div class="col-md-2">
                                                    <div class="position-relative" style="height: 120px;">
                                                        @if($wishlist->product->image)
                                                            <img src="{{ asset('storage/' . $wishlist->product->image) }}" 
                                                                 alt="{{ $wishlist->product->name }}"
                                                                 class="w-100 h-100 object-fit-cover rounded-start">
                                                        @else
                                                            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light rounded-start">
                                                                <i class="bi bi-image text-muted fs-1"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-7">
                                                    <div class="p-4">
                                                        <h5 class="card-title fw-bold mb-2">{{ $wishlist->product->name }}</h5>
                                                        @if($wishlist->product->description)
                                                            <p class="text-muted mb-2">{{ Str::limit($wishlist->product->description, 120) }}</p>
                                                        @endif
                                                        <div class="d-flex align-items-center">
                                                            @if($wishlist->product->discount_price)
                                                                <span class="fw-bold fs-5 text-success me-2">
                                                                    {{ $this->formatPrice($wishlist->product->discount_price) }}
                                                                </span>
                                                                <small class="text-muted text-decoration-line-through me-2">
                                                                    {{ $this->formatPrice($wishlist->product->price) }}
                                                                </small>
                                                                <span class="badge bg-danger">
                                                                    -{{ $this->getDiscountPercentage($wishlist->product) }}%
                                                                </span>
                                                            @else
                                                                <span class="fw-bold fs-5 text-dark">
                                                                    {{ $this->formatPrice($wishlist->product->price) }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <small class="text-muted">
                                                            <i class="bi bi-clock me-1"></i>
                                                            Ajouté le {{ $wishlist->created_at->format('d/m/Y à H:i') }}
                                                        </small>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="p-4 text-center">
                                                        <div class="d-flex flex-column gap-2">
                                                            <a href="{{ route('product.show', $wishlist->product) }}" 
                                                               class="btn btn-outline-primary btn-sm">
                                                                <i class="bi bi-eye me-1"></i>
                                                                Voir détails
                                                            </a>
                                                            <button class="btn btn-success btn-sm"
                                                                    wire:click="addToCart({{ $wishlist->product->id }})">
                                                                <i class="bi bi-cart-plus me-1"></i>
                                                                Ajouter au panier
                                                            </button>
                                                            <button class="btn btn-outline-danger btn-sm"
                                                                    wire:click="removeFromWishlist({{ $wishlist->product->id }})">
                                                                <i class="bi bi-heart-fill me-1"></i>
                                                                Retirer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    <!-- Pagination -->
                    @if($wishlists->hasPages())
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-center">
                                    {{ $wishlists->links() }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Statistiques -->
            <div class="row mt-5">
                <div class="col-12">
                    <div class="floating-card">
                        <div class="row text-center py-4">
                            <div class="col-md-4">
                                <div class="border-end border-light">
                                    <h4 class="fw-bold text-primary mb-1">{{ $totalItems }}</h4>
                                    <small class="text-muted">Produits favoris</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="border-end border-light">
                                    <h4 class="fw-bold text-success mb-1">
                                        {{ $this->formatPrice($totalValue) }}
                                    </h4>
                                    <small class="text-muted">Valeur totale</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h4 class="fw-bold text-info mb-1">{{ $discountedItems }}</h4>
                                <small class="text-muted">En promotion</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @else
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
        @endif
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
</div>
