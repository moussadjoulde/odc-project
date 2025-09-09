@extends('layouts.product')

@section('title', 'Créer une Commande')

@section('content')
    <style>
        /* Styles personnalisés pour la création de commande */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .form-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .form-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .form-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }

        .form-body {
            padding: 2.5rem;
        }

        .section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #667eea;
        }

        .section-title {
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating > .form-control,
        .form-floating > .form-select {
            height: 60px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-floating > .form-control:focus,
        .form-floating > .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .form-floating > label {
            color: #718096;
            font-weight: 600;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label,
        .form-floating > .form-select:focus ~ label,
        .form-floating > .form-select:not([value=""]) ~ label {
            color: #667eea;
            font-weight: 700;
        }

        .form-control.is-invalid,
        .form-select.is-invalid {
            border-color: #e53e3e;
            background: #fef5f5;
        }

        .form-control.is-valid,
        .form-select.is-valid {
            border-color: #38a169;
            background: #f0fff4;
        }

        .textarea-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .textarea-floating > textarea {
            min-height: 100px;
            resize: vertical;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .textarea-floating > textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .textarea-floating > label {
            position: absolute;
            top: 1rem;
            left: 1rem;
            color: #718096;
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
            padding: 0 0.5rem;
            pointer-events: none;
        }

        .textarea-floating > textarea:focus ~ label,
        .textarea-floating > textarea:not(:placeholder-shown) ~ label {
            top: -0.5rem;
            font-size: 0.875rem;
            color: #667eea;
            font-weight: 700;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-gradient-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .btn-outline-secondary {
            border: 2px solid #e2e8f0;
            color: #718096;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e0;
            color: #4a5568;
            transform: translateY(-2px);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-danger {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            color: white;
        }

        .breadcrumb-modern {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-modern .breadcrumb-item {
            font-weight: 600;
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: #667eea;
        }

        .breadcrumb-modern a {
            color: #718096;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-modern a:hover {
            color: #667eea;
        }

        .order-summary {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 2rem;
            border: 1px solid #cbd5e0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 700;
            font-size: 1.1rem;
            color: #2d3748;
        }

        .summary-label {
            color: #718096;
            font-weight: 600;
        }

        .summary-value {
            color: #2d3748;
            font-weight: 600;
        }

        .form-card {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .form-header h1 {
                font-size: 2rem;
            }

            .form-body {
                padding: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }

            .button-group .btn {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-modern">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('orders.admin.index') }}">
                        <i class="bi bi-cart-check me-1"></i>
                        Commandes
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="bi bi-plus-circle me-1"></i>
                    Nouvelle Commande
                </li>
            </ol>
        </nav>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Erreurs détectées !</strong>
                    </div>
                </div>
                <ul class="mb-0 ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="form-card">
                    <!-- Header du formulaire -->
                    <div class="form-header">
                        <div class="form-icon">
                            <i class="bi bi-cart-plus"></i>
                        </div>
                        <h1>Nouvelle Commande</h1>
                        <p>Créez une nouvelle commande pour un client</p>
                    </div>

                    <!-- Corps du formulaire -->
                    <div class="form-body">
                        <form action="{{ route('orders.admin.store') }}" method="POST" id="orderForm">
                            @csrf
                            
                            <!-- Informations Client -->
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-person me-2"></i>
                                    Informations Client
                                </h3>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               class="form-control @error('customer_name') is-invalid @enderror" 
                                               id="customer_name" 
                                               name="customer_name" 
                                               placeholder="Nom du client"
                                               value="{{ old('customer_name') }}"
                                               required>
                                        <label for="customer_name">
                                            <i class="bi bi-person me-2"></i>
                                            Nom du client
                                        </label>
                                        @error('customer_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" 
                                               class="form-control @error('customer_email') is-invalid @enderror" 
                                               id="customer_email" 
                                               name="customer_email" 
                                               placeholder="Email du client"
                                               value="{{ old('customer_email') }}"
                                               required>
                                        <label for="customer_email">
                                            <i class="bi bi-envelope me-2"></i>
                                            Email du client
                                        </label>
                                        @error('customer_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating">
                                <input type="tel" 
                                       class="form-control @error('customer_phone') is-invalid @enderror" 
                                       id="customer_phone" 
                                       name="customer_phone" 
                                       placeholder="Téléphone du client"
                                       value="{{ old('customer_phone') }}">
                                <label for="customer_phone">
                                    <i class="bi bi-telephone me-2"></i>
                                    Téléphone (optionnel)
                                </label>
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Adresse de Livraison -->
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-truck me-2"></i>
                                    Adresse de Livraison
                                </h3>
                            </div>

                            <div class="form-floating">
                                <input type="text" 
                                       class="form-control @error('shipping_address') is-invalid @enderror" 
                                       id="shipping_address" 
                                       name="shipping_address" 
                                       placeholder="Adresse de livraison"
                                       value="{{ old('shipping_address') }}"
                                       required>
                                <label for="shipping_address">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    Adresse de livraison
                                </label>
                                @error('shipping_address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               class="form-control @error('shipping_city') is-invalid @enderror" 
                                               id="shipping_city" 
                                               name="shipping_city" 
                                               placeholder="Ville"
                                               value="{{ old('shipping_city') }}"
                                               required>
                                        <label for="shipping_city">
                                            <i class="bi bi-building me-2"></i>
                                            Ville
                                        </label>
                                        @error('shipping_city')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" 
                                               class="form-control @error('shipping_postal_code') is-invalid @enderror" 
                                               id="shipping_postal_code" 
                                               name="shipping_postal_code" 
                                               placeholder="Code postal"
                                               value="{{ old('shipping_postal_code') }}">
                                        <label for="shipping_postal_code">
                                            <i class="bi bi-mailbox me-2"></i>
                                            Code postal
                                        </label>
                                        @error('shipping_postal_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating">
                                <select class="form-select @error('shipping_country') is-invalid @enderror" 
                                        id="shipping_country" 
                                        name="shipping_country" 
                                        required>
                                    <option value="">Sélectionnez un pays</option>
                                    <option value="Guinea" {{ old('shipping_country', 'Guinea') == 'Guinea' ? 'selected' : '' }}>Guinée</option>
                                    <option value="Senegal" {{ old('shipping_country') == 'Senegal' ? 'selected' : '' }}>Sénégal</option>
                                    <option value="Mali" {{ old('shipping_country') == 'Mali' ? 'selected' : '' }}>Mali</option>
                                    <option value="Burkina Faso" {{ old('shipping_country') == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                    <option value="Côte d'Ivoire" {{ old('shipping_country') == "Côte d'Ivoire" ? 'selected' : '' }}>Côte d'Ivoire</option>
                                </select>
                                <label for="shipping_country">
                                    <i class="bi bi-flag me-2"></i>
                                    Pays
                                </label>
                                @error('shipping_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Configuration de Commande -->
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-gear me-2"></i>
                                    Configuration de la Commande
                                </h3>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                                id="payment_method" 
                                                name="payment_method">
                                            <option value="">Méthode de paiement</option>
                                            <option value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'selected' : '' }}>Paiement à la livraison</option>
                                            <option value="mobile_money" {{ old('payment_method') == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                                            <option value="card" {{ old('payment_method') == 'card' ? 'selected' : '' }}>Carte bancaire</option>
                                            <option value="wallet" {{ old('payment_method') == 'wallet' ? 'selected' : '' }}>Portefeuille électronique</option>
                                        </select>
                                        <label for="payment_method">
                                            <i class="bi bi-credit-card me-2"></i>
                                            Méthode de paiement
                                        </label>
                                        @error('payment_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('shipping_method') is-invalid @enderror" 
                                                id="shipping_method" 
                                                name="shipping_method"
                                                required>
                                            <option value="">Méthode de livraison</option>
                                            <option value="standard" {{ old('shipping_method', 'standard') == 'standard' ? 'selected' : '' }}>Livraison standard</option>
                                            <option value="express" {{ old('shipping_method') == 'express' ? 'selected' : '' }}>Livraison express</option>
                                            <option value="pickup" {{ old('shipping_method') == 'pickup' ? 'selected' : '' }}>Retrait en magasin</option>
                                        </select>
                                        <label for="shipping_method">
                                            <i class="bi bi-truck me-2"></i>
                                            Méthode de livraison
                                        </label>
                                        @error('shipping_method')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating">
                                <input type="text" 
                                       class="form-control @error('coupon_code') is-invalid @enderror" 
                                       id="coupon_code" 
                                       name="coupon_code" 
                                       placeholder="Code promo"
                                       value="{{ old('coupon_code') }}">
                                <label for="coupon_code">
                                    <i class="bi bi-ticket-perforated me-2"></i>
                                    Code promo (optionnel)
                                </label>
                                @error('coupon_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="textarea-floating">
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" 
                                          name="notes" 
                                          placeholder="Notes du client"
                                          rows="3">{{ old('notes') }}</textarea>
                                <label for="notes">
                                    <i class="bi bi-chat-text me-2"></i>
                                    Notes du client (optionnelles)
                                </label>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="textarea-floating">
                                <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                          id="admin_notes" 
                                          name="admin_notes" 
                                          placeholder="Notes administratives"
                                          rows="3">{{ old('admin_notes') }}</textarea>
                                <label for="admin_notes">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Notes administratives (optionnelles)
                                </label>
                                @error('admin_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Boutons d'action -->
                            <div class="button-group">
                                <a href="{{ route('orders.admin.index') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Retour
                                </a>
                                <button type="submit" class="btn btn-gradient-primary flex-fill">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Créer la Commande
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Résumé de commande (côté droit) -->
            <div class="col-lg-4">
                <div class="form-card">
                    <div class="form-header" style="padding: 1.5rem;">
                        <h3 style="font-size: 1.5rem; margin: 0;">
                            <i class="bi bi-receipt me-2"></i>
                            Résumé de la Commande
                        </h3>
                    </div>
                    <div class="form-body" style="padding: 1.5rem;">
                        <div class="order-summary">
                            <div class="summary-row">
                                <span class="summary-label">Sous-total:</span>
                                <span class="summary-value" id="subtotalDisplay">0 GNF</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">TVA:</span>
                                <span class="summary-value" id="taxDisplay">0 GNF</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Frais de livraison:</span>
                                <span class="summary-value" id="shippingDisplay">0 GNF</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Réduction:</span>
                                <span class="summary-value" id="discountDisplay">0 GNF</span>
                            </div>
                            <div class="summary-row">
                                <span class="summary-label">Total:</span>
                                <span class="summary-value" id="totalDisplay">0 GNF</span>
                            </div>
                        </div>

                        <!-- Champs cachés pour les montants -->
                        <input type="hidden" name="subtotal" id="subtotal" value="0">
                        <input type="hidden" name="tax_amount" id="tax_amount" value="0">
                        <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                        <input type="hidden" name="discount_amount" id="discount_amount" value="0">
                        <input type="hidden" name="total_amount" id="total_amount" value="0">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fonction pour formater les montants
            function formatCurrency(amount) {
                return new Intl.NumberFormat('fr-FR').format(amount) + ' GNF';
            }

            // Calcul automatique des montants basé sur la méthode de livraison
            const shippingMethodSelect = document.getElementById('shipping_method');
            const couponCodeInput = document.getElementById('coupon_code');

            function updateOrderSummary() {
                let subtotal = 0; // À calculer basé sur les produits sélectionnés
                let taxAmount = subtotal * 0.18; // TVA de 18%
                let shippingCost = 0;
                let discountAmount = 0;

                // Calcul des frais de livraison
                const shippingMethod = shippingMethodSelect.value;
                switch(shippingMethod) {
                    case 'standard':
                        shippingCost = 5000;
                        break;
                    case 'express':
                        shippingCost = 15000;
                        break;
                    case 'pickup':
                        shippingCost = 0;
                        break;
                }

                // Application de réduction basée sur le code promo (exemple)
                const couponCode = couponCodeInput.value.trim();
                if (couponCode === 'WELCOME10') {
                    discountAmount = subtotal * 0.10; // 10% de réduction
                }

                const totalAmount = subtotal + taxAmount + shippingCost - discountAmount;

                // Mise à jour de l'affichage
                document.getElementById('subtotalDisplay').textContent = formatCurrency(subtotal);
                document.getElementById('taxDisplay').textContent = formatCurrency(taxAmount);
                document.getElementById('shippingDisplay').textContent = formatCurrency(shippingCost);
                document.getElementById('discountDisplay').textContent = formatCurrency(discountAmount);
                document.getElementById('totalDisplay').textContent = formatCurrency(totalAmount);

                // Mise à jour des champs cachés
                document.getElementById('subtotal').value = subtotal;
                document.getElementById('tax_amount').value = taxAmount;
                document.getElementById('shipping_cost').value = shippingCost;
                document.getElementById('discount_amount').value = discountAmount;
                document.getElementById('total_amount').value = totalAmount;
            }

            // Écouteurs d'événements
            shippingMethodSelect.addEventListener('change', updateOrderSummary);
            couponCodeInput.addEventListener('input', updateOrderSummary);

            // Génération automatique du numéro de commande
            const orderNumberInput = document.createElement('input');
            orderNumberInput.type = 'hidden';
            orderNumberInput.name = 'order_number';
            orderNumberInput.value = 'ORD-' + Date.now();
            document.getElementById('orderForm').appendChild(orderNumberInput);

            // Animation des champs lors du focus
            const formControls = document.querySelectorAll('.form-control, .form-select, textarea');
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                control.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Validation en temps réel
            const form = document.getElementById('orderForm');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Vérification des champs obligatoires
                const requiredFields = ['customer_name', 'customer_email', 'shipping_address', 'shipping_city', 'shipping_country', 'shipping_method'];
                
                requiredFields.forEach(fieldName => {
                    const field = document.getElementById(fieldName);
                    if (!field.value.trim()) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });

                // Vérification de l'email
                const emailField = document.getElementById('customer_email');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (emailField.value && !emailPattern.test(emailField.value)) {
                    emailField.classList.add('is-invalid');
                    isValid = false;
                }

                if (!isValid) {
                    e.preventDefault();
                    // Scroll vers le premier champ invalide
                    const firstInvalid = document.querySelector('.form-control.is-invalid, .form-select.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
                }
            });

            // Initialiser le résumé de commande
            updateOrderSummary();
        });
    </script>
@endsection