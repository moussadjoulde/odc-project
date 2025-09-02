<div>
    <!-- Page Header -->
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-12 text-center position-relative">
                    <i class="bi bi-cart3 display-4 mb-3"></i>
                    <h1 class="display-4 fw-bold mb-3">Mon Panier</h1>
                    <p class="lead mb-0">
                        @if (count($cartItems) > 0)
                            {{ count($cartItems) }} article{{ count($cartItems) > 1 ? 's' : '' }} dans votre panier
                        @else
                            Votre panier vous attend
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        @if (count($cartItems) == 0)
            <!-- Panier vide -->
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="floating-card p-5 text-center empty-cart">
                        <div class="empty-cart-icon mb-4">
                            <div class="icon-wrapper">
                                <i class="bi bi-cart-x display-1 text-muted"></i>
                                <div class="floating-elements">
                                    <div class="floating-dot dot-1"></div>
                                    <div class="floating-dot dot-2"></div>
                                    <div class="floating-dot dot-3"></div>
                                </div>
                            </div>
                        </div>
                        <h2 class="h3 fw-bold mb-3">Votre panier est vide</h2>
                        <p class="text-muted mb-4">
                            Il semble que vous n'ayez encore rien ajouté à votre panier.<br>
                            Découvrez nos produits exceptionnels !
                        </p>
                        <div class="d-grid gap-3 d-md-flex justify-content-md-center">
                            <a href="{{ url('/shop') }}" class="btn btn-modern btn-lg">
                                <i class="bi bi-shop me-2"></i>Découvrir nos produits
                            </a>
                            <a href="{{ url('/home') }}" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-house me-2"></i>Retour à l'accueil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Panier avec articles -->
            <div class="row g-4">
                <!-- Liste des articles -->
                <div class="col-lg-8">
                    <div class="floating-card p-0 overflow-hidden">
                        <!-- En-tête du panier -->
                        <div class="cart-header p-4 border-bottom">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h3 class="h5 mb-0 fw-bold">
                                        <i class="bi bi-bag-check text-primary me-2"></i>
                                        Articles sélectionnés ({{ count($cartItems) }})
                                    </h3>
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-outline-danger btn-sm rounded-pill" wire:click="clearCart"
                                        wire:confirm="Êtes-vous sûr de vouloir vider votre panier ?">
                                        <i class="bi bi-trash me-1"></i>Vider le panier
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Articles du panier -->
                        <div class="cart-items">
                            @foreach ($cartItems as $index => $item)
                                <div class="cart-item p-4 {{ $index !== count($cartItems) - 1 ? 'border-bottom' : '' }}"
                                    data-item-id="{{ $item->id }}">
                                    <div class="row align-items-center g-3">
                                        <!-- Image du produit -->
                                        <div class="col-md-2 col-3">
                                            <div class="product-image-container">
                                                @if ($item->product->image)
                                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                                        alt="{{ $item->product->name }}" class="product-image">
                                                @else
                                                    <div class="product-placeholder">
                                                        <i class="bi bi-image"></i>
                                                    </div>
                                                @endif
                                                <div class="image-overlay">
                                                    <i class="bi bi-eye text-white"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Détails du produit -->
                                        <div class="col-md-4 col-9">
                                            <div class="product-details">
                                                <h6 class="product-name mb-2 fw-bold">{{ $item->product->name }}</h6>
                                                <p class="product-brand mb-1 text-muted small">
                                                    <i class="bi bi-tag me-1"></i>
                                                    {{ $item->product->brand ?? 'Sans marque' }}
                                                </p>
                                                @if ($item->product->category)
                                                    <span class="category-badge">
                                                        {{ $item->product->category->name ?? 'Catégorie' }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- Prix unitaire -->
                                        <div class="col-md-2 col-6">
                                            <div class="price-section text-center">
                                                <div class="unit-price fw-bold text-primary h6 mb-0">
                                                    {{ number_format($item->price, 0, ',', ' ') }} GNF
                                                </div>
                                                <small class="text-muted">Prix unitaire</small>
                                            </div>
                                        </div>

                                        <!-- Contrôles de quantité -->
                                        <div class="col-md-2 col-6">
                                            <div class="quantity-wrapper">
                                                <label class="form-label small text-muted mb-1">Quantité</label>
                                                <div class="quantity-controls">
                                                    <button class="quantity-btn decrease"
                                                        wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                        {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                        <i class="bi bi-dash"></i>
                                                    </button>
                                                    <input type="number" class="quantity-input"
                                                        value="{{ $item->quantity }}"
                                                        wire:change="updateQuantity({{ $item->id }}, $event.target.value)"
                                                        min="1" max="99">
                                                    <button class="quantity-btn increase"
                                                        wire:click="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">
                                                        <i class="bi bi-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Total de la ligne -->
                                        <div class="col-md-1 col-6">
                                            <div class="line-total text-center">
                                                <div class="total-price fw-bold h6 mb-0 text-success">
                                                    {{ number_format($this->getItemTotal($item->price, $item->quantity), 0, ',', ' ') }}
                                                    GNF
                                                </div>
                                                <small class="text-muted">Total</small>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="col-md-1 col-6">
                                            <div class="item-actions text-center">
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-outline-secondary btn-sm dropdown-toggle rounded-pill"
                                                        type="button" data-bs-toggle="dropdown">
                                                        <i class="bi bi-three-dots-vertical"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="#">
                                                                <i class="bi bi-heart me-2"></i>Ajouter aux favoris
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <button class="dropdown-item text-danger"
                                                                wire:click="removeItem({{ $item->id }})"
                                                                wire:confirm="Supprimer cet article du panier ?">
                                                                <i class="bi bi-trash me-2"></i>Supprimer
                                                            </button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Actions du panier -->
                        <div class="cart-footer p-4 bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <a href="{{ url('/shop') }}" class="btn btn-outline-primary rounded-pill">
                                        <i class="bi bi-arrow-left me-2"></i>Continuer mes achats
                                    </a>
                                </div>
                                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                                    <button class="btn btn-light rounded-pill me-2">
                                        <i class="bi bi-bookmark me-2"></i>Enregistrer
                                    </button>
                                    <button class="btn btn-outline-secondary rounded-pill">
                                        <i class="bi bi-share me-2"></i>Partager
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Résumé de la commande -->
                <div class="col-lg-4">
                    <div class="order-summary-sticky">
                        <!-- Résumé principal -->
                        <div class="floating-card overflow-hidden">
                            <div class="summary-header p-4 text-center">
                                <h3 class="h5 mb-0 fw-bold text-white">
                                    <i class="bi bi-calculator me-2"></i>Résumé de commande
                                </h3>
                            </div>
                            <div class="summary-body p-4">
                                <div class="summary-line d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Sous-total ({{ count($cartItems) }} articles)</span>
                                    <span class="fw-semibold h6 mb-0">{{ number_format($total, 0, ',', ' ') }}
                                        GNF</span>
                                </div>

                                <div class="summary-line d-flex justify-content-between align-items-center mb-3">
                                    <span class="text-muted">Frais de livraison</span>
                                    <span class="fw-semibold {{ $total >= 50 ? 'text-success' : '' }}">
                                        @if ($total >= 50)
                                            <i class="bi bi-check-circle me-1"></i>Gratuit
                                        @else
                                            4,99 €
                                        @endif
                                    </span>
                                </div>

                                @if ($total < 50)
                                    <div class="shipping-notice p-3 mb-3 rounded-3">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-truck text-primary me-2"></i>
                                            <div class="flex-fill">
                                                <small class="fw-semibold">Livraison gratuite dès 50 GNF</small>
                                                <div class="progress mt-1" style="height: 4px;">
                                                    <div class="progress-bar"
                                                        style="width: {{ ($total / 50) * 100 }}%"></div>
                                                </div>
                                                <small class="text-muted">
                                                    Plus que {{ number_format(50 - $total, 0, ',', ' ') }} GNF !
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <hr class="my-4">

                                <div class="total-section p-3 rounded-3 mb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h5 fw-bold mb-0">Total à payer</span>
                                        <span class="h4 fw-bold text-primary mb-0">
                                            {{ number_format($total + ($total >= 50 ? 0 : 4.99), 0, ',', ' ') }} GNF
                                        </span>
                                    </div>
                                    <small class="text-muted">TVA incluse</small>
                                </div>

                                <div class="d-grid gap-3">
                                    <button class="btn btn-modern btn-lg rounded-pill">
                                        <i class="bi bi-credit-card me-2" wire:click="placeOrder"></i>Passer la commande
                                    </button>
                                    <button class="btn btn-outline-primary btn-lg rounded-pill">
                                        <i class="bi bi-paypal me-2"></i>PayPal Express
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Informations complémentaires -->
                        <div class="floating-card p-4 mt-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-shield-check text-success me-2"></i>Paiement sécurisé
                            </h6>
                            <div class="payment-methods mb-3">
                                <div class="d-flex justify-content-center gap-3 mb-3">
                                    <div class="payment-icon">
                                        <i class="bi bi-credit-card-2-front"></i>
                                    </div>
                                    <div class="payment-icon">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                    <div class="payment-icon">
                                        <i class="bi bi-paypal"></i>
                                    </div>
                                    <div class="payment-icon">
                                        <i class="bi bi-apple"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="security-features">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-lock text-success me-2"></i>
                                    <small class="text-muted">Cryptage SSL 256 bits</small>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-arrow-return-left text-primary me-2"></i>
                                    <small class="text-muted">Retour gratuit sous 30 jours</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-headset text-info me-2"></i>
                                    <small class="text-muted">Support client 24/7</small>
                                </div>
                            </div>
                        </div>

                        <!-- Produits recommandés -->
                        <div class="floating-card p-4 mt-4">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-star text-warning me-2"></i>Vous pourriez aussi aimer
                            </h6>
                            <div class="recommended-products">
                                <div class="recommended-item d-flex align-items-center mb-3">
                                    <div class="recommended-image me-3">
                                        <div class="placeholder-image-small"></div>
                                    </div>
                                    <div class="flex-fill">
                                        <h6 class="small mb-1">Produit recommandé</h6>
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted">29,99 €</small>
                                            <button class="btn btn-outline-primary btn-sm rounded-pill">
                                                <i class="bi bi-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        /* Animations et effets */
        .empty-cart {
            border: none;
            background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
        }

        .icon-wrapper {
            position: relative;
            display: inline-block;
        }

        .floating-elements {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
        }

        .floating-dot {
            position: absolute;
            width: 8px;
            height: 8px;
            background: var(--primary-gradient);
            border-radius: 50%;
            opacity: 0.7;
            animation: float 3s ease-in-out infinite;
        }

        .dot-1 {
            top: 20%;
            right: 10%;
            animation-delay: 0s;
        }

        .dot-2 {
            top: 60%;
            left: 20%;
            animation-delay: 1s;
        }

        .dot-3 {
            top: 40%;
            right: 30%;
            animation-delay: 2s;
        }

        /* Articles du panier */
        .cart-item {
            transition: all 0.3s ease;
            position: relative;
        }

        .cart-item:hover {
            background: linear-gradient(135deg, #f8f9ff 0%, rgba(248, 249, 255, 0.5) 100%);
            transform: translateX(5px);
        }

        .cart-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 0;
            background: var(--primary-gradient);
            transition: width 0.3s ease;
        }

        .cart-item:hover::before {
            width: 4px;
        }

        .product-image-container {
            position: relative;
            width: 80px;
            height: 80px;
            border-radius: 12px;
            overflow: hidden;
            cursor: pointer;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-image-container:hover .product-image {
            transform: scale(1.1);
        }

        .product-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 1.5rem;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(102, 126, 234, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-image-container:hover .image-overlay {
            opacity: 1;
        }

        .category-badge {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Contrôles de quantité */
        .quantity-controls {
            display: flex;
            align-items: center;
            background: white;
            border: 2px solid #e9ecef;
            border-radius: 25px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .quantity-controls:hover {
            border-color: var(--bs-primary);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
        }

        .quantity-btn {
            background: none;
            border: none;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            transition: all 0.3s ease;
        }

        .quantity-btn:hover:not(:disabled) {
            background: var(--primary-gradient);
            color: white;
        }

        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            outline: none;
            font-weight: 600;
            color: var(--bs-primary);
        }

        /* Résumé de commande */
        .order-summary-sticky {
            position: sticky;
            top: 100px;
        }

        .summary-header {
            background: var(--primary-gradient);
            position: relative;
        }

        .summary-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 20px;
            background: white;
            border-radius: 20px 20px 0 0;
        }

        .summary-line {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .summary-line:last-child {
            border-bottom: none;
        }

        .shipping-notice {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .total-section {
            background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
            border: 2px solid rgba(102, 126, 234, 0.1);
        }

        /* Méthodes de paiement */
        .payment-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
            border: 2px solid #e9ecef;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            color: var(--bs-primary);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .payment-icon:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.2);
            border-color: var(--bs-primary);
        }

        /* Produits recommandés */
        .recommended-image {
            width: 50px;
            height: 50px;
        }

        .placeholder-image-small {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
            border-radius: 8px;
        }

        /* Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-10px) rotate(180deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .cart-item {
                padding: 1rem;
            }

            .cart-item .row>div {
                margin-bottom: 0.75rem;
            }

            .order-summary-sticky {
                position: static;
            }

            .quantity-controls {
                width: 120px;
            }

            .page-header {
                padding: 2rem 0;
            }
        }

        /* Animations d'entrée */
        .cart-item {
            opacity: 0;
            animation: slideInUp 0.6s ease forwards;
        }

        .cart-item:nth-child(1) {
            animation-delay: 0.1s;
        }

        .cart-item:nth-child(2) {
            animation-delay: 0.2s;
        }

        .cart-item:nth-child(3) {
            animation-delay: 0.3s;
        }

        .cart-item:nth-child(4) {
            animation-delay: 0.4s;
        }

        .cart-item:nth-child(5) {
            animation-delay: 0.5s;
        }

        @keyframes slideInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des éléments au chargement
            const cartItems = document.querySelectorAll('.cart-item');
            cartItems.forEach((item, index) => {
                item.style.transform = 'translateY(30px)';
                item.style.animationDelay = `${index * 0.1}s`;
            });

            // Mise à jour des totaux en temps réel
            function updateTotals() {
                // Cette fonction serait connectée à Livewire
                console.log('Updating totals...');
            }

            // Animation de la barre de progression pour la livraison gratuite
            const progressBar = document.querySelector('.progress-bar');
            if (progressBar) {
                const targetWidth = progressBar.style.width;
                progressBar.style.width = '0%';
                setTimeout(() => {
                    progressBar.style.transition = 'width 1s ease-in-out';
                    progressBar.style.width = targetWidth;
                }, 500);
            }

            // Effet de pulsation sur le bouton de commande
            const checkoutBtn = document.querySelector('.btn-modern');
            if (checkoutBtn) {
                setInterval(() => {
                    checkoutBtn.style.transform = 'scale(1.02)';
                    setTimeout(() => {
                        checkoutBtn.style.transform = 'scale(1)';
                    }, 200);
                }, 5000);
            }

            // Smooth scroll vers le résumé sur mobile
            window.addEventListener('scroll', function() {
                const summary = document.querySelector('.order-summary-sticky');
                const rect = summary.getBoundingClientRect();

                if (rect.top <= 20) {
                    summary.style.transform = 'translateY(0)';
                }
            });
        });

        // Fonction pour afficher des notifications
        function showCartNotification(message, type = 'success') {
            if (typeof showToast === 'function') {
                showToast(type, message);
            }
        }

        // Gestion des erreurs de quantité
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('quantity-input')) {
                const value = parseInt(e.target.value);
                if (value < 1 || value > 99) {
                    e.target.style.borderColor = '#dc3545';
                    showCartNotification('La quantité doit être entre 1 et 99', 'warning');
                } else {
                    e.target.style.borderColor = '#28a745';
                }
            }
        });
    </script>
</div>
