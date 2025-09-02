<div class="container-fluid px-0">
    <!-- Breadcrumb -->
    <div class="container py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Accueil</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/shop') }}" class="text-decoration-none">Shop</a></li>
                @if($product->category)
                    <li class="breadcrumb-item">
                        <a href="{{ route('categories.show', $product->category->slug) }}" class="text-decoration-none">
                            {{ $product->category->name }}
                        </a>
                    </li>
                @endif
                <li class="breadcrumb-item active">{{ $product->name }}</li>
            </ol>
        </nav>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row g-5">
            <!-- Colonne image -->
            <div class="col-lg-6">
                <div class="product-image-section">
                    <div class="main-image mb-3">
                        <div class="floating-card p-0 overflow-hidden position-relative">
                            @if($this->discountPercentage)
                                <div class="position-absolute top-0 start-0 z-3">
                                    <span class="badge rounded-pill px-3 py-2 m-3"
                                        style="background: var(--secondary-gradient); font-size: 0.9rem; font-weight: 600;">
                                        -{{ $this->discountPercentage }}%
                                    </span>
                                </div>
                            @endif
                            @if(!$product->in_stock)
                                <div class="position-absolute top-0 end-0 z-3">
                                    <span class="badge bg-danger rounded-pill px-3 py-2 m-3"
                                        style="font-size: 0.9rem; font-weight: 600;">
                                        Rupture de stock
                                    </span>
                                </div>
                            @endif
                            <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/600x600/667eea/ffffff?text=' . urlencode($product->name) }}"
                                alt="{{ $product->name }}" class="img-fluid w-100"
                                style="height: 500px; object-fit: cover;">
                        </div>
                    </div>

                    <!-- Galerie miniatures -->
                    <div class="thumbnail-gallery">
                        <div class="row g-2">
                            @for($i = 0; $i < 4; $i++)
                                <div class="col-3">
                                    <div class="floating-card p-0 overflow-hidden"
                                        style="cursor: pointer; opacity: {{ $selectedImageIndex == $i ? '1' : '0.6' }};"
                                        wire:click="selectImage({{ $i }})">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/150x150/667eea/ffffff?text=' . ($i + 1) }}"
                                            alt="Image {{ $i + 1 }}" class="img-fluid w-100"
                                            style="height: 100px; object-fit: cover;">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Colonne informations -->
            <div class="col-lg-6">
                <div class="product-info">
                    <!-- En-tête produit -->
                    <div class="mb-4">
                        @if($product->brand)
                            <div class="text-muted mb-2 fw-500">{{ $product->brand }}</div>
                        @endif
                        <h1 class="display-5 fw-bold mb-3">{{ $product->name }}</h1>
                        <div class="mb-3">SKU: <span class="text-muted">{{ $product->sku }}</span></div>

                        <!-- Rating -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="rating me-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= floor($product->rating) ? '-fill' : ($i - $product->rating < 1 ? '-half' : '') }} text-warning"></i>
                                @endfor
                                <span class="ms-2 fw-600">{{ number_format($product->rating, 1) }}</span>
                            </div>
                            <small class="text-muted">({{ $product->review_count }} avis)</small>
                        </div>
                    </div>

                    <!-- Prix -->
                    <div class="price-section mb-4 p-4 rounded-3"
                        style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);">
                        <div class="d-flex align-items-center flex-wrap">
                            <h2 class="price-current me-3 mb-0 fw-bold" style="color: #667eea; font-size: 2.5rem;">
                                {{ number_format($product->price, 0, ',', ' ') }} GNF
                            </h2>
                            @if($product->old_price)
                                <span class="price-old text-muted text-decoration-line-through me-3" style="font-size: 1.2rem;">
                                    {{ number_format($product->old_price, 0, ',', ' ') }} GNF
                                </span>
                                @if($this->savings)
                                    <span class="badge rounded-pill px-3 py-2" style="background: var(--success-gradient); color: white;">
                                        Économie: {{ number_format($this->savings, 0, ',', ' ') }} GNF
                                    </span>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- Description courte -->
                    @if($product->short_description)
                        <div class="short-description mb-4">
                            <p class="lead text-muted">{{ $product->short_description }}</p>
                        </div>
                    @endif

                    <!-- Informations techniques -->
                    <div class="product-specs mb-4">
                        <div class="row g-3">
                            @if($product->weight)
                                <div class="col-sm-6">
                                    <div class="floating-card p-3 h-100">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-box text-primary me-2" style="font-size: 1.2rem;"></i>
                                            <div>
                                                <small class="text-muted d-block">Poids</small>
                                                <span class="fw-600">{{ $product->weight }} kg</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if($product->dimensions)
                                <div class="col-sm-6">
                                    <div class="floating-card p-3 h-100">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-rulers text-primary me-2" style="font-size: 1.2rem;"></i>
                                            <div>
                                                <small class="text-muted d-block">Dimensions</small>
                                                <span class="fw-600">{{ $product->dimensions }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Stock et disponibilité -->
                    <div class="stock-info mb-4 p-3 rounded-3"
                        style="background: {{ $product->in_stock ? 'rgba(76, 175, 80, 0.1)' : 'rgba(244, 67, 54, 0.1)' }};">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-{{ $product->in_stock ? 'check-circle-fill text-success' : 'x-circle-fill text-danger' }} me-2"></i>
                            <div>
                                <span class="fw-600">
                                    {{ $product->in_stock ? 'En stock' : 'Rupture de stock' }}
                                </span>
                                @if($product->in_stock && $product->stock_quantity > 0)
                                    <small class="text-muted d-block">{{ $product->stock_quantity }} unité(s) disponible(s)</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Quantité et boutons d'action -->
                    <div class="action-section">
                        <div class="row g-3 align-items-end">
                            <div class="col-auto">
                                <label for="quantity" class="form-label fw-600">Quantité</label>
                                <div class="input-group quantity-selector">
                                    <button type="button" class="btn btn-outline-secondary quantity-btn"
                                        wire:click="decreaseQuantity"
                                        {{ !$product->in_stock || $quantity <= 1 ? 'disabled' : '' }}>
                                        <i class="bi bi-dash"></i>
                                    </button>
                                    <input type="number" wire:model.live="quantity" id="quantity"
                                        class="form-control text-center" min="1"
                                        max="{{ $product->stock_quantity }}"
                                        {{ !$product->in_stock ? 'disabled' : '' }}>
                                    <button type="button" class="btn btn-outline-secondary quantity-btn"
                                        wire:click="increaseQuantity"
                                        {{ !$product->in_stock || $quantity >= $product->stock_quantity ? 'disabled' : '' }}>
                                        <i class="bi bi-plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col">
                                <div class="d-flex gap-3 flex-wrap">
                                    <button type="button" class="btn btn-modern flex-fill"
                                        wire:click="addToCart"
                                        {{ !$product->in_stock ? 'disabled' : '' }}
                                        wire:loading.attr="disabled"
                                        wire:target="addToCart">
                                        <i class="bi bi-cart-plus me-2"></i>
                                        <span wire:loading.remove wire:target="addToCart">Ajouter au panier</span>
                                        <span wire:loading wire:target="addToCart">Ajout...</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary rounded-pill px-4"
                                        wire:click="toggleWishList"
                                        wire:loading.attr="disabled"
                                        wire:target="toggleWishList"
                                        data-bs-toggle="tooltip" title="{{ $isInWishList ? 'Retirer des favoris' : 'Ajouter aux favoris' }}">
                                        <i class="bi bi-heart{{ $isInWishList ? '-fill text-danger' : '' }}"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4"
                                        wire:click="share"
                                        data-bs-toggle="tooltip" title="Partager">
                                        <i class="bi bi-share"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Onglets de contenu -->
        <div class="product-tabs mt-5">
            <div class="floating-card p-0 overflow-hidden">
                <nav>
                    <div class="nav nav-tabs border-0" style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                        <button class="nav-link px-4 py-3 fw-600 border-0 {{ $activeTab === 'description' ? 'active' : '' }}"
                            wire:click="setActiveTab('description')">
                            Description
                        </button>
                        <button class="nav-link px-4 py-3 fw-600 border-0 {{ $activeTab === 'specs' ? 'active' : '' }}"
                            wire:click="setActiveTab('specs')">
                            Caractéristiques
                        </button>
                        <button class="nav-link px-4 py-3 fw-600 border-0 {{ $activeTab === 'reviews' ? 'active' : '' }}"
                            wire:click="setActiveTab('reviews')">
                            Avis ({{ $reviewsCount }})
                        </button>
                    </div>
                </nav>
                
                <div class="tab-content p-4">
                    <!-- Description -->
                    @if($activeTab === 'description')
                        <div class="tab-pane-content">
                            @if($product->description)
                                <div class="product-description">
                                    {!! nl2br(e($product->description)) !!}
                                </div>
                            @else
                                <p class="text-muted">Aucune description disponible pour ce produit.</p>
                            @endif
                        </div>
                    @endif

                    <!-- Caractéristiques -->
                    @if($activeTab === 'specs')
                        <div class="tab-pane-content">
                            <div class="specifications">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-600">SKU:</td>
                                                <td>{{ $product->sku }}</td>
                                            </tr>
                                            @if($product->brand)
                                                <tr>
                                                    <td class="fw-600">Marque:</td>
                                                    <td>{{ $product->brand }}</td>
                                                </tr>
                                            @endif
                                            @if($product->weight)
                                                <tr>
                                                    <td class="fw-600">Poids:</td>
                                                    <td>{{ $product->weight }} kg</td>
                                                </tr>
                                            @endif
                                            @if($product->dimensions)
                                                <tr>
                                                    <td class="fw-600">Dimensions:</td>
                                                    <td>{{ $product->dimensions }}</td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-600">Stock:</td>
                                                <td>{{ $product->stock_quantity }} unités</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-600">Disponibilité:</td>
                                                <td>{{ $product->in_stock ? 'En stock' : 'Rupture de stock' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="fw-600">Note:</td>
                                                <td>{{ number_format($product->rating, 1) }}/5 ({{ $product->review_count }} avis)</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Avis -->
                    @if($activeTab === 'reviews')
                        <div class="tab-pane-content">
                            <div class="reviews-section">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="rating-summary text-center p-4 rounded-3"
                                            style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);">
                                            <h3 class="display-4 fw-bold mb-2" style="color: #667eea;">
                                                {{ number_format($product->rating, 1) }}
                                            </h3>
                                            <div class="stars mb-2">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="bi bi-star{{ $i <= floor($product->rating) ? '-fill' : ($i - 0.5 <= $product->rating ? '-half' : '') }} text-warning"></i>
                                                @endfor
                                            </div>
                                            <p class="text-muted">{{ $product->review_count }} avis</p>

                                            <!-- Répartition des notes -->
                                            <div class="rating-distribution mt-4">
                                                @foreach($this->ratingDistribution as $rating => $count)
                                                    <div class="d-flex align-items-center mb-2">
                                                        <small class="text-muted me-2" style="width: 20px;">{{ $rating }} <i class="bi bi-star-fill text-warning"></i></small>
                                                        <div class="progress flex-grow-1" style="height: 8px;">
                                                            <div class="progress-bar bg-warning" role="progressbar"
                                                                style="width: {{ $product->review_count > 0 ? ($count / $product->review_count) * 100 : 0 }}%"
                                                                aria-valuenow="{{ $count }}"
                                                                aria-valuemin="0"
                                                                aria-valuemax="{{ $product->review_count }}">
                                                            </div>
                                                        </div>
                                                        <small class="text-muted ms-2" style="width: 30px;">
                                                            {{ $product->review_count > 0 ? round(($count / $product->review_count) * 100) : 0 }}%
                                                        </small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <!-- Formulaire d'avis -->
                                        <div class="review-form mb-5">
                                            <h5 class="mb-3">Donnez votre avis</h5>
                                            <div class="floating-card p-4">
                                                @auth
                                                    @if(!$userReview)
                                                        <form wire:submit.prevent="submitReview">
                                                            <!-- Notation -->
                                                            <div class="mb-3">
                                                                <label class="form-label fw-600">Votre note</label>
                                                                <div class="rating-input">
                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <input type="radio" id="star{{ $i }}"
                                                                            wire:model.live="reviewRating" value="{{ $i }}">
                                                                        <label for="star{{ $i }}" class="star-label">
                                                                            <i class="bi bi-star"></i>
                                                                            <i class="bi bi-star-fill"></i>
                                                                        </label>
                                                                    @endfor
                                                                </div>
                                                                @error('reviewRating')
                                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Titre -->
                                                            <div class="mb-3">
                                                                <label for="reviewTitle" class="form-label fw-600">Titre de l'avis</label>
                                                                <input type="text" class="form-control" id="reviewTitle"
                                                                    wire:model.live="reviewTitle">
                                                                @error('reviewTitle')
                                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <!-- Commentaire -->
                                                            <div class="mb-3">
                                                                <label for="reviewComment" class="form-label fw-600">Votre avis</label>
                                                                <textarea class="form-control" id="reviewComment"
                                                                    wire:model.live="reviewComment" rows="4"></textarea>
                                                                @error('reviewComment')
                                                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                            <button type="submit" class="btn btn-modern"
                                                                wire:loading.attr="disabled"
                                                                wire:target="submitReview">
                                                                <i class="bi bi-send me-2"></i>
                                                                <span wire:loading.remove wire:target="submitReview">Publier mon avis</span>
                                                                <span wire:loading wire:target="submitReview">Publication...</span>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div class="text-center py-3">
                                                            <i class="bi bi-check-circle-fill text-success" style="font-size: 2rem;"></i>
                                                            <p class="text-muted mt-2">Vous avez déjà laissé un avis pour ce produit.</p>
                                                            <small class="text-muted">
                                                                @if($userReview->approved)
                                                                    Votre avis est publié.
                                                                @else
                                                                    Votre avis est en attente d'approbation.
                                                                @endif
                                                            </small>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="text-center py-3">
                                                        <p class="text-muted">Vous devez être connecté pour laisser un avis.</p>
                                                        <a href="{{ route('login') }}" class="btn btn-modern me-2">Se connecter</a>
                                                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Créer un compte</a>
                                                    </div>
                                                @endauth
                                            </div>
                                        </div>

                                        <!-- Liste des avis -->
                                        <div class="reviews-list">
                                            <h5 class="mb-4">Avis clients ({{ $reviewsCount }})</h5>

                                            @if($reviews->count() > 0)
                                                @foreach($reviews as $review)
                                                    <div class="review-item floating-card p-4 mb-3">
                                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                                            <div>
                                                                <h6 class="fw-600 mb-1">
                                                                    {{ $review->user->name ?? 'Utilisateur anonyme' }}
                                                                </h6>
                                                                <div class="rating small">
                                                                    @for($j = 1; $j <= 5; $j++)
                                                                        <i class="bi bi-star{{ $j <= $review->rating ? '-fill' : '' }} text-warning"></i>
                                                                    @endfor
                                                                </div>
                                                            </div>
                                                            <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                                                        </div>

                                                        <h6 class="fw-600 text-primary mb-2">{{ $review->title }}</h6>
                                                        <p class="mb-0">{{ $review->comment }}</p>
                                                    </div>
                                                @endforeach

                                                <!-- Bouton pour voir plus d'avis -->
                                                @if(!$showAllReviews && $reviewsCount > 5)
                                                    <div class="text-center mt-4">
                                                        <button class="btn btn-outline-primary"
                                                            wire:click="loadMoreReviews"
                                                            wire:loading.attr="disabled"
                                                            wire:target="loadMoreReviews">
                                                            <span wire:loading.remove wire:target="loadMoreReviews">
                                                                <i class="bi bi-chevron-down me-2"></i>Voir plus d'avis
                                                            </span>
                                                            <span wire:loading wire:target="loadMoreReviews">
                                                                <i class="spinner-border spinner-border-sm me-2"></i>Chargement...
                                                            </span>
                                                        </button>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="bi bi-chat-quote text-muted" style="font-size: 2rem;"></i>
                                                    <p class="text-muted mt-2">Aucun avis pour ce produit pour le moment.</p>
                                                    <p>Soyez le premier à donner votre avis !</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Produits similaires -->
        <div class="related-products mt-5">
            <h3 class="mb-4 fw-bold">Produits similaires</h3>
            <div class="row g-4">
                @if($similarProducts->count() > 0)
                    @foreach($similarProducts as $similarProduct)
                        <div class="col-lg-3 col-md-6">
                            <div class="floating-card p-0 overflow-hidden h-100 product-card-hover">
                                <a href="{{ route('product.show', $similarProduct->id) }}" class="text-decoration-none text-dark">
                                    <div class="position-relative">
                                        @php
                                            $similarDiscount = null;
                                            if ($similarProduct->old_price && $similarProduct->old_price > $similarProduct->price) {
                                                $similarDiscount = round((($similarProduct->old_price - $similarProduct->price) / $similarProduct->old_price) * 100);
                                            }
                                        @endphp
                                        @if($similarDiscount)
                                            <div class="position-absolute top-0 start-0 z-3">
                                                <span class="badge rounded-pill px-2 py-1 m-2"
                                                    style="background: var(--secondary-gradient); font-size: 0.8rem; font-weight: 600;">
                                                    -{{ $similarDiscount }}%
                                                </span>
                                            </div>
                                        @endif
                                        @if(!$similarProduct->in_stock)
                                            <div class="position-absolute top-0 end-0 z-3">
                                                <span class="badge bg-danger rounded-pill px-2 py-1 m-2"
                                                    style="font-size: 0.8rem; font-weight: 600;">
                                                    Rupture
                                                </span>
                                            </div>
                                        @endif
                                        <img src="{{ $similarProduct->image ? asset('storage/' . $similarProduct->image) : 'https://via.placeholder.com/300x200/667eea/ffffff?text=' . urlencode($similarProduct->name) }}"
                                            alt="{{ $similarProduct->name }}" class="img-fluid w-100"
                                            style="height: 200px; object-fit: cover;">
                                    </div>
                                    <div class="p-3">
                                        <h6 class="fw-600 mb-2"
                                            style="font-size: 0.95rem; height: 2.8rem; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                            {{ $similarProduct->name }}
                                        </h6>
                                        <div class="d-flex align-items-center justify-content-between mb-2">
                                            <div>
                                                @if($similarProduct->old_price)
                                                    <span class="text-muted text-decoration-line-through me-2 small">
                                                        {{ number_format($similarProduct->old_price, 0, ',', ' ') }} GNF
                                                    </span>
                                                @endif
                                                <span class="fw-bold" style="color: #667eea;">
                                                    {{ number_format($similarProduct->price, 0, ',', ' ') }} GNF
                                                </span>
                                            </div>
                                            <div class="rating">
                                                @for($j = 1; $j <= 5; $j++)
                                                    <i class="bi bi-star{{ $j <= floor($similarProduct->rating) ? '-fill' : '' }} text-warning small"></i>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if($similarProduct->in_stock)
                                                <small class="text-success">
                                                    <i class="bi bi-check-circle-fill"></i> En stock
                                                </small>
                                                <button class="btn btn-sm btn-outline-primary"
                                                    wire:click.prevent="addSimilarToCart({{ $similarProduct->id }})"
                                                    wire:loading.attr="disabled"
                                                    wire:target="addSimilarToCart({{ $similarProduct->id }})">
                                                    <i class="bi bi-cart-plus"></i>
                                                </button>
                                            @else
                                                <small class="text-danger">
                                                    <i class="bi bi-x-circle-fill"></i> Rupture de stock
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="text-center py-4">
                            <i class="bi bi-info-circle text-muted" style="font-size: 2rem;"></i>
                            <p class="text-muted mt-2">Aucun produit similaire trouvé.</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- Scripts JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
    
            // Animation des barres de progression
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease-in-out';
                    bar.style.width = width;
                }, 100);
            });
        });
    
        // Écouter l'événement pour copier dans le presse-papier
        document.addEventListener('livewire:init', () => {
            Livewire.on('copyToClipboard', (event) => {
                navigator.clipboard.writeText(event.url).then(() => {
                    console.log('URL copiée dans le presse-papier');
                }).catch(err => {
                    console.error('Erreur lors de la copie:', err);
                });
            });
        });
    </script>
</div>
