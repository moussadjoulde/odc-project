<div class="container my-5">
    <div class="row">
        <!-- Sidebar Filtres -->
        <div class="col-lg-3 mb-4">
            <div class="filter-card p-4">
                <h5 class="fw-bold mb-4">
                    <i class="bi bi-funnel me-2"></i>Filtres
                </h5>

                <!-- Catégories - CORRECTION ICI -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">Catégories</h6>
                    <button class="category-btn {{ $category === 'all' ? 'active' : '' }}"
                        wire:click="setCategory('all')">
                        <i class="bi bi-grid me-2"></i>Tous les produits
                    </button>
                    @foreach ($availableCategories as $cat)
                        <button class="category-btn {{ $category == $cat['id'] ? 'active' : '' }}"
                            wire:click="setCategory({{ $cat['id'] }})">
                            <i class="bi bi-laptop me-2"></i>{{ $cat['name'] }}
                        </button>
                    @endforeach
                </div>

                <!-- Prix -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">Gamme de prix</h6>
                    <div class="price-range">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label">Min</label>
                                <input type="number" class="form-control" wire:model.lazy="minPrice" min="0">
                            </div>
                            <div class="col-6">
                                <label class="form-label">Max</label>
                                <input type="number" class="form-control" wire:model.lazy="maxPrice" min="0">
                            </div>
                        </div>
                        <button class="btn btn-outline-primary w-100 mt-3" wire:click="applyPriceFilter">
                            Appliquer
                        </button>
                    </div>
                </div>

                <!-- Marques -->
                @if (!empty($availableBrands))
                    <div class="mb-4">
                        <h6 class="fw-semibold mb-3">Marques populaires</h6>
                        @foreach ($availableBrands as $brand)
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="brand_{{ $loop->index }}"
                                    wire:click="toggleBrand('{{ $brand }}')"
                                    {{ in_array($brand, $brands) ? 'checked' : '' }}>
                                <label class="form-check-label" for="brand_{{ $loop->index }}">
                                    {{ $brand }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Note moyenne -->
                <div class="mb-4">
                    <h6 class="fw-semibold mb-3">Note minimum</h6>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rating" id="rating5" value="5"
                            wire:model="rating">
                        <label class="form-check-label" for="rating5">
                            <span class="stars">★★★★★</span> 5 étoiles
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rating" id="rating4" value="4"
                            wire:model="rating">
                        <label class="form-check-label" for="rating4">
                            <span class="stars">★★★★☆</span> 4 étoiles et plus
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rating" id="rating3" value="3"
                            wire:model="rating">
                        <label class="form-check-label" for="rating3">
                            <span class="stars">★★★☆☆</span> 3 étoiles et plus
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio" name="rating" id="rating0" value=""
                            wire:model="rating">
                        <label class="form-check-label" for="rating0">
                            Toutes les notes
                        </label>
                    </div>
                </div>

                <!-- Bouton reset -->
                <button class="btn btn-outline-secondary w-100" wire:click="resetFilters">
                    <i class="bi bi-arrow-clockwise me-2"></i>Réinitialiser
                </button>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="col-lg-9">
            <!-- Indicateur de chargement -->
            <div wire:loading class="text-center py-3">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Chargement...</span>
                </div>
            </div>

            <div wire:loading.remove>
                <!-- Barre de tri et résultats -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold">Nos Produits</h4>
                        <p class="text-muted">{{ $products->total() }} produits trouvés</p>
                    </div>
                    <div class="d-flex align-items-center gap-3">
                        <div class="sort-dropdown">
                            <div class="dropdown">
                                <button class="dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-sort-down me-2"></i>
                                    @switch($sortBy)
                                        @case('price_asc')
                                            Prix croissant
                                        @break

                                        @case('price_desc')
                                            Prix décroissant
                                        @break

                                        @case('rating')
                                            Mieux notés
                                        @break

                                        @case('popular')
                                            Plus populaires
                                        @break

                                        @default
                                            Plus récent
                                        @break
                                    @endswitch
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#"
                                            wire:click.prevent="setSortBy('newest')">Plus récent</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            wire:click.prevent="setSortBy('price_asc')">Prix croissant</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            wire:click.prevent="setSortBy('price_desc')">Prix décroissant</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            wire:click.prevent="setSortBy('rating')">Mieux notés</a></li>
                                    <li><a class="dropdown-item" href="#"
                                            wire:click.prevent="setSortBy('popular')">Plus populaires</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group" role="group">
                            <button type="button"
                                class="btn btn-outline-secondary {{ $viewType === 'grid' ? 'active' : '' }}"
                                wire:click="setViewType('grid')">
                                <i class="bi bi-grid"></i>
                            </button>
                            <button type="button"
                                class="btn btn-outline-secondary {{ $viewType === 'list' ? 'active' : '' }}"
                                wire:click="setViewType('list')">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Grille de produits -->
                <div class="row">
                    @forelse($products as $product)
                        <div class="{{ $viewType === 'grid' ? 'col-lg-4 col-md-6' : 'col-12' }} mb-4">
                            <div class="product-card {{ $viewType === 'list' ? 'product-card-list' : '' }}">
                                <div class="product-image">
                                    <!-- Badge promotionnel -->
                                    @if ($product->old_price && $product->discount_percentage)
                                        <div class="product-badge">-{{ $product->discount_percentage }}%</div>
                                    @elseif($product->is_featured)
                                        <div class="product-badge">Top vente</div>
                                    @elseif($product->created_at->diffInDays(now()) < 30)
                                        <div class="product-badge">Nouveau</div>
                                    @endif

                                    <button
                                        class="wishlist-btn {{ $this->isInWishList($product->id) ? 'active' : '' }}"
                                        wire:click="toggleWishList({{ $product->id }})">
                                        <i
                                            class="bi bi-heart{{ $this->isInWishList($product->id) ? '-fill' : '' }}"></i>
                                    </button>

                                    <div class="product-overlay">
                                        <button class="btn-quick-view">
                                            <i class="bi bi-eye me-2"></i>Aperçu rapide
                                        </button>
                                    </div>

                                    <!-- Image du produit -->
                                    @if ($product->image)
                                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                            class="img-fluid product-main-image">
                                    @else
                                        <div class="position-absolute top-50 start-50 translate-middle">
                                            @if (str_contains(strtolower($product->name), 'phone') || str_contains(strtolower($product->name), 'iphone'))
                                                <i class="bi bi-phone text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @elseif(str_contains(strtolower($product->name), 'laptop') || str_contains(strtolower($product->name), 'macbook'))
                                                <i class="bi bi-laptop text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @elseif(str_contains(strtolower($product->name), 'tablet') || str_contains(strtolower($product->name), 'ipad'))
                                                <i class="bi bi-tablet text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @elseif(str_contains(strtolower($product->name), 'watch'))
                                                <i class="bi bi-smartwatch text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @elseif(str_contains(strtolower($product->name), 'headphone') || str_contains(strtolower($product->name), 'airpod'))
                                                <i class="bi bi-headphones text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @elseif(str_contains(strtolower($product->name), 'camera'))
                                                <i class="bi bi-camera text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @elseif(str_contains(strtolower($product->name), 'game') || str_contains(strtolower($product->name), 'playstation'))
                                                <i class="bi bi-controller text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @elseif(str_contains(strtolower($product->name), 'speaker') || str_contains(strtolower($product->name), 'homepod'))
                                                <i class="bi bi-speaker text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @elseif(str_contains(strtolower($product->name), 'keyboard'))
                                                <i class="bi bi-keyboard text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @else
                                                <i class="bi bi-box text-primary"
                                                    style="font-size: 4rem; opacity: 0.3;"></i>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="product-info">
                                    <h6 class="product-title">{{ $product->name }}</h6>

                                    <div class="product-rating">
                                        <div class="stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= floor($product->rating))
                                                    <i class="bi bi-star-fill text-warning"></i>
                                                @elseif($i - 0.5 <= $product->rating)
                                                    <i class="bi bi-star-half text-warning"></i>
                                                @else
                                                    <i class="bi bi-star text-warning"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="rating-count">({{ $product->review_count }} avis)</span>
                                    </div>

                                    <div class="product-price">
                                        {{ number_format($product->price, 2, ',', ' ') }} €
                                        @if ($product->old_price)
                                            <span
                                                class="old-price">{{ number_format($product->old_price, 2, ',', ' ') }}
                                                €</span>
                                        @endif
                                    </div>

                                    <button class="btn-add-cart" wire:click="addToCart({{ $product->id }}, 1)">
                                        <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="bi bi-box-seam display-1 text-muted"></i>
                                <h4 class="mt-3">Aucun produit trouvé</h4>
                                <p class="text-muted">Aucun produit ne correspond à vos critères de recherche.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination Livewire -->
                {{ $products->links() }}
            </div>
        </div>
    </div>
</div>
