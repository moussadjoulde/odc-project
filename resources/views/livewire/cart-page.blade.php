<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">
                <i class="bi bi-cart3 me-2"></i>Mon Panier
            </h1>

            @if (count($cartItems) == 0)
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-cart-x display-1 text-muted"></i>
                    </div>
                    <h3 class="text-muted mb-3">Votre panier est vide</h3>
                    <p class="text-muted mb-4">Découvrez nos produits et ajoutez-les à votre panier.</p>
                    <a href="{{ url('/shop') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-shop me-2"></i>Continuer mes achats
                    </a>
                </div>
            @else
                <div class="row">
                    <!-- Articles du panier -->
                    <div class="col-lg-8 mb-4">
                        <div class="card">
                            <div class="card-header bg-light">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h5 class="mb-0">Articles dans votre panier ({{ count($cartItems) }})</h5>
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-outline-danger btn-sm" 
                                                wire:click="clearCart"
                                                wire:confirm="Êtes-vous sûr de vouloir vider votre panier ?">
                                            <i class="bi bi-trash me-1"></i>Vider le panier
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                @foreach ($cartItems as $item)
                                    <div class="cart-item p-4 border-bottom">
                                        <div class="row align-items-center">
                                            <!-- Image du produit -->
                                            <div class="col-md-2 col-3">
                                                <div class="product-image-cart">
                                                    @if ($item->product->image)
                                                        <img src="{{ $item->product->image }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="img-fluid rounded">
                                                    @else
                                                        <div class="placeholder-image d-flex align-items-center justify-content-center bg-light rounded">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Détails du produit -->
                                            <div class="col-md-4 col-9">
                                                <h6 class="mb-1 fw-semibold">{{ $item->product->name }}</h6>
                                                <p class="text-muted mb-1 small">{{ $item->product->brand ?? 'Sans marque' }}</p>
                                                @if($item->product->category)
                                                    <span class="badge bg-light text-dark small">{{ $item->product->category->name ?? 'Catégorie' }}</span>
                                                @endif
                                            </div>
                                            
                                            <!-- Prix unitaire -->
                                            <div class="col-md-2 col-6 text-center">
                                                <div class="price">
                                                    <strong>{{ number_format($item->price, 2, ',', ' ') }} €</strong>
                                                </div>
                                                <small class="text-muted">Prix unitaire</small>
                                            </div>
                                            
                                            <!-- Quantité -->
                                            <div class="col-md-2 col-6">
                                                <div class="quantity-controls d-flex align-items-center justify-content-center">
                                                    <button class="btn btn-outline-secondary btn-sm" 
                                                            wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" 
                                                           class="form-control text-center mx-2" 
                                                           style="width: 60px;" 
                                                           value="{{ $item->quantity }}"
                                                           wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                                           min="1">
                                                    <button class="btn btn-outline-secondary btn-sm" 
                                                            wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            
                                            <!-- Total de la ligne -->
                                            <div class="col-md-1 col-6 text-center">
                                                <div class="item-total">
                                                    <strong>{{ number_format($this->getItemTotal($item->price, $item->quantity), 2, ',', ' ') }} €</strong>
                                                </div>
                                            </div>
                                            
                                            <!-- Bouton supprimer -->
                                            <div class="col-md-1 col-6 text-center">
                                                <button class="btn btn-outline-danger btn-sm" 
                                                        wire:click="removeItem({{ $item->id }})"
                                                        wire:confirm="Supprimer cet article du panier ?">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Actions -->
                        <div class="mt-3">
                            <a href="{{ url('/shop') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                            </a>
                        </div>
                    </div>

                    <!-- Résumé de la commande -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-calculator me-2"></i>Résumé de la commande
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="summary-row d-flex justify-content-between mb-3">
                                    <span>Sous-total ({{ count($cartItems) }} articles)</span>
                                    <strong>{{ number_format($total, 2, ',', ' ') }} €</strong>
                                </div>
                                
                                <div class="summary-row d-flex justify-content-between mb-3">
                                    <span>Frais de livraison</span>
                                    <span class="text-success">
                                        @if($total >= 50)
                                            Gratuit
                                        @else
                                            4,99 €
                                        @endif
                                    </span>
                                </div>
                                
                                @if($total < 50)
                                    <div class="alert alert-info small mb-3">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Livraison gratuite dès 50€ d'achat
                                        <br>Il vous manque {{ number_format(50 - $total, 2, ',', ' ') }} €
                                    </div>
                                @endif
                                
                                <hr>
                                
                                <div class="summary-row d-flex justify-content-between mb-4">
                                    <strong class="h5">Total</strong>
                                    <strong class="h5 text-primary">
                                        {{ number_format($total + ($total >= 50 ? 0 : 4.99), 2, ',', ' ') }} €
                                    </strong>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button class="btn btn-primary btn-lg">
                                        <i class="bi bi-credit-card me-2"></i>Passer la commande
                                    </button>
                                    <button class="btn btn-outline-secondary">
                                        <i class="bi bi-bookmark me-2"></i>Enregistrer pour plus tard
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Moyens de paiement -->
                        <div class="card mt-3">
                            <div class="card-body text-center">
                                <h6 class="mb-3">Paiement sécurisé</h6>
                                <div class="payment-methods d-flex justify-content-center gap-2">
                                    <i class="bi bi-credit-card-2-front text-primary" style="font-size: 1.5rem;"></i>
                                    <i class="bi bi-credit-card text-primary" style="font-size: 1.5rem;"></i>
                                    <i class="bi bi-paypal text-primary" style="font-size: 1.5rem;"></i>
                                    <i class="bi bi-apple text-primary" style="font-size: 1.5rem;"></i>
                                </div>
                                <small class="text-muted mt-2 d-block">
                                    <i class="bi bi-shield-check me-1"></i>Transactions 100% sécurisées
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <style>
    .cart-item {
        transition: all 0.3s ease;
    }
    
    .cart-item:hover {
        background-color: #f8f9fa;
    }
    
    .product-image-cart {
        height: 80px;
        overflow: hidden;
    }
    
    .product-image-cart img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .placeholder-image {
        height: 80px;
        width: 80px;
    }
    
    .quantity-controls input {
        border: 1px solid #dee2e6;
        border-radius: 0;
    }
    
    .quantity-controls button {
        border-radius: 0;
    }
    
    .quantity-controls button:first-child {
        border-top-left-radius: 0.375rem;
        border-bottom-left-radius: 0.375rem;
    }
    
    .quantity-controls button:last-child {
        border-top-right-radius: 0.375rem;
        border-bottom-right-radius: 0.375rem;
    }
    
    .summary-row {
        padding: 0.5rem 0;
    }
    
    .payment-methods i {
        transition: transform 0.2s ease;
    }
    
    .payment-methods i:hover {
        transform: scale(1.1);
    }
    
    @media (max-width: 768px) {
        .cart-item .row > div {
            margin-bottom: 0.5rem;
        }
        
        .quantity-controls {
            justify-content: flex-start !important;
        }
    }
    </style>
</div>
