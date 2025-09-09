@extends('layouts.product')

@section('title', 'Modifier la Commande #' . $order->order_number)

@section('content')
    <style>
        /* Styles identiques à create avec quelques ajouts */
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
            background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
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
            border-left: 4px solid #f6ad55;
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
            border-color: #f6ad55;
            box-shadow: 0 0 0 3px rgba(246, 173, 85, 0.1);
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
            color: #f6ad55;
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
            border-color: #f6ad55;
            box-shadow: 0 0 0 3px rgba(246, 173, 85, 0.1);
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
            color: #f6ad55;
            font-weight: 700;
        }

        .btn-gradient-warning {
            background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(246, 173, 85, 0.4);
        }

        .btn-gradient-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(246, 173, 85, 0.6);
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

        .alert-success {
            background: linear-gradient(135deg, #68d391 0%, #38a169 100%);
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
            color: #f6ad55;
        }

        .breadcrumb-modern a {
            color: #718096;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-modern a:hover {
            color: #f6ad55;
        }

        .order-info {
            background: linear-gradient(135deg, #fef5e7 0%, #fed7aa 100%);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #f6ad55;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }

        .info-item {
            background: white;
            border-radius: 8px;
            padding: 1rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .info-label {
            font-weight: 600;
            color: #718096;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-weight: 700;
            color: #2d3748;
            font-size: 1.1rem;
            margin-top: 0.25rem;
        }

        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-block;
            text-align: center;
        }

        .status-pending {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
        }

        .status-confirmed {
            background: linear-gradient(135deg, #60a5fa 0%, #3b82f6 100%);
            color: white;
        }

        .status-processing {
            background: linear-gradient(135deg, #a78bfa 0%, #8b5cf6 100%);
            color: white;
        }

        .status-shipped {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
            color: white;
        }

        .status-delivered {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .status-cancelled {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
        }

        .status-refunded {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
        }

        .payment-pending {
            background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
            color: white;
        }

        .payment-paid {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .payment-failed {
            background: linear-gradient(135deg, #f87171 0%, #ef4444 100%);
            color: white;
        }

        .payment-refunded {
            background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
            color: white;
        }

        .payment-partial {
            background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
            color: white;
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

            .info-grid {
                grid-template-columns: 1fr;
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
                <li class="breadcrumb-item">
                    <a href="{{ route('orders.admin.show', $order) }}">
                        <i class="bi bi-receipt me-1"></i>
                        {{ $order->order_number }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="bi bi-pencil me-1"></i>
                    Modification
                </li>
            </ol>
        </nav>

        <!-- Messages -->
        @if (session('success'))
            <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle me-3" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Succès !</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

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

        <!-- Informations actuelles de la commande -->
        <div class="order-info">
            <h3 class="mb-4" style="color: #2d3748;">
                <i class="bi bi-info-circle me-2"></i>
                Informations actuelles de la commande
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">Numéro de commande</div>
                    <div class="info-value">{{ $order->order_number }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Statut actuel</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $order->status }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Statut paiement</div>
                    <div class="info-value">
                        <span class="status-badge payment-{{ $order->payment_status }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">Montant total</div>
                    <div class="info-value">{{ number_format($order->total_amount, 0) }} GNF</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Date de création</div>
                    <div class="info-value">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                </div>
                @if($order->tracking_number)
                <div class="info-item">
                    <div class="info-label">Numéro de suivi</div>
                    <div class="info-value">{{ $order->tracking_number }}</div>
                </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="form-card">
                    <!-- Header du formulaire -->
                    <div class="form-header">
                        <div class="form-icon">
                            <i class="bi bi-pencil-square"></i>
                        </div>
                        <h1>Modifier la Commande</h1>
                        <p>Commande #{{ $order->order_number }}</p>
                    </div>

                    <!-- Corps du formulaire -->
                    <div class="form-body">
                        <form action="{{ route('orders.admin.update', $order) }}" method="POST" id="orderForm">
                            @csrf
                            @method('PUT')
                            
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
                                               value="{{ old('customer_name', $order->customer_name) }}"
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
                                               value="{{ old('customer_email', $order->customer_email) }}"
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
                                       value="{{ old('customer_phone', $order->customer_phone) }}">
                                <label for="customer_phone">
                                    <i class="bi bi-telephone me-2"></i>
                                    Téléphone
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
                                       value="{{ old('shipping_address', $order->shipping_address) }}"
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
                                               value="{{ old('shipping_city', $order->shipping_city) }}"
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
                                               value="{{ old('shipping_postal_code', $order->shipping_postal_code) }}">
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
                                    <option value="Guinea" {{ old('shipping_country', $order->shipping_country) == 'Guinea' ? 'selected' : '' }}>Guinée</option>
                                    <option value="Senegal" {{ old('shipping_country', $order->shipping_country) == 'Senegal' ? 'selected' : '' }}>Sénégal</option>
                                    <option value="Mali" {{ old('shipping_country', $order->shipping_country) == 'Mali' ? 'selected' : '' }}>Mali</option>
                                    <option value="Burkina Faso" {{ old('shipping_country', $order->shipping_country) == 'Burkina Faso' ? 'selected' : '' }}>Burkina Faso</option>
                                    <option value="Côte d'Ivoire" {{ old('shipping_country', $order->shipping_country) == "Côte d'Ivoire" ? 'selected' : '' }}>Côte d'Ivoire</option>
                                </select>
                                <label for="shipping_country">
                                    <i class="bi bi-flag me-2"></i>
                                    Pays
                                </label>
                                @error('shipping_country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statuts et Configuration -->
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-gear me-2"></i>
                                    Statuts et Configuration
                                </h3>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('status') is-invalid @enderror" 
                                                id="status" 
                                                name="status"
                                                required>
                                            <option value="pending" {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="confirmed" {{ old('status', $order->status) == 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                                            <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>En traitement</option>
                                            <option value="shipped" {{ old('status', $order->status) == 'shipped' ? 'selected' : '' }}>Expédiée</option>
                                            <option value="delivered" {{ old('status', $order->status) == 'delivered' ? 'selected' : '' }}>Livrée</option>
                                            <option value="cancelled" {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                            <option value="refunded" {{ old('status', $order->status) == 'refunded' ? 'selected' : '' }}>Remboursée</option>
                                        </select>
                                        <label for="status">
                                            <i class="bi bi-arrow-repeat me-2"></i>
                                            Statut de la commande
                                        </label>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('payment_status') is-invalid @enderror" 
                                                id="payment_status" 
                                                name="payment_status"
                                                required>
                                            <option value="pending" {{ old('payment_status', $order->payment_status) == 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="paid" {{ old('payment_status', $order->payment_status) == 'paid' ? 'selected' : '' }}>Payé</option>
                                            <option value="failed" {{ old('payment_status', $order->payment_status) == 'failed' ? 'selected' : '' }}>Échoué</option>
                                            <option value="refunded" {{ old('payment_status', $order->payment_status) == 'refunded' ? 'selected' : '' }}>Remboursé</option>
                                            <option value="partial" {{ old('payment_status', $order->payment_status) == 'partial' ? 'selected' : '' }}>Partiel</option>
                                        </select>
                                        <label for="payment_status">
                                            <i class="bi bi-credit-card me-2"></i>
                                            Statut du paiement
                                        </label>
                                        @error('payment_status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select @error('payment_method') is-invalid @enderror" 
                                                id="payment_method" 
                                                name="payment_method">
                                            <option value="">Méthode de paiement</option>
                                            <option value="cash_on_delivery" {{ old('payment_method', $order->payment_method) == 'cash_on_delivery' ? 'selected' : '' }}>Paiement à la livraison</option>
                                            <option value="mobile_money" {{ old('payment_method', $order->payment_method) == 'mobile_money' ? 'selected' : '' }}>Mobile Money</option>
                                            <option value="bank_transfer" {{ old('payment_method', $order->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Virement bancaire</option>
                                            <option value="card" {{ old('payment_method', $order->payment_method) == 'card' ? 'selected' : '' }}>Carte bancaire</option>
                                            <option value="wallet" {{ old('payment_method', $order->payment_method) == 'wallet' ? 'selected' : '' }}>Portefeuille électronique</option>
                                        </select>
                                        <label for="payment_method">
                                            <i class="bi bi-wallet me-2"></i>
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
                                            <option value="standard" {{ old('shipping_method', $order->shipping_method) == 'standard' ? 'selected' : '' }}>Livraison standard</option>
                                            <option value="express" {{ old('shipping_method', $order->shipping_method) == 'express' ? 'selected' : '' }}>Livraison express</option>
                                            <option value="pickup" {{ old('shipping_method', $order->shipping_method) == 'pickup' ? 'selected' : '' }}>Retrait en magasin</option>
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
                                       class="form-control @error('tracking_number') is-invalid @enderror" 
                                       id="tracking_number" 
                                       name="tracking_number" 
                                       placeholder="Numéro de suivi"
                                       value="{{ old('tracking_number', $order->tracking_number) }}">
                                <label for="tracking_number">
                                    <i class="bi bi-truck me-2"></i>
                                    Numéro de suivi
                                </label>
                                @error('tracking_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-floating">
                                <input type="text" 
                                       class="form-control @error('coupon_code') is-invalid @enderror" 
                                       id="coupon_code" 
                                       name="coupon_code" 
                                       placeholder="Code promo"
                                       value="{{ old('coupon_code', $order->coupon_code) }}">
                                <label for="coupon_code">
                                    <i class="bi bi-ticket-perforated me-2"></i>
                                    Code promo
                                </label>
                                @error('coupon_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Notes -->
                            <div class="section-header">
                                <h3 class="section-title">
                                    <i class="bi bi-chat-text me-2"></i>
                                    Notes et Commentaires
                                </h3>
                            </div>

                            <div class="textarea-floating">
                                <textarea class="form-control @error('notes') is-invalid @enderror" 
                                          id="notes" 
                                          name="notes" 
                                          placeholder="Notes du client"
                                          rows="3">{{ old('notes', $order->notes) }}</textarea>
                                <label for="notes">
                                    <i class="bi bi-chat-text me-2"></i>
                                    Notes du client
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
                                          rows="3">{{ old('admin_notes', $order->admin_notes) }}</textarea>
                                <label for="admin_notes">
                                    <i class="bi bi-shield-check me-2"></i>
                                    Notes administratives
                                </label>
                                @error('admin_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Boutons d'action -->
                            <div class="button-group">
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Retour
                                </a>
                                <button type="submit" class="btn btn-gradient-warning flex-fill">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Mettre à jour la Commande
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Résumé des montants (côté droit) -->
            <div class="col-lg-4">
                <div class="form-card">
                    <div class="form-header" style="padding: 1.5rem;">
                        <h3 style="font-size: 1.5rem; margin: 0;">
                            <i class="bi bi-calculator me-2"></i>
                            Montants de la Commande
                        </h3>
                    </div>
                    <div class="form-body" style="padding: 1.5rem;">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" 
                                           class="form-control @error('subtotal') is-invalid @enderror" 
                                           id="subtotal" 
                                           name="subtotal" 
                                           placeholder="Sous-total"
                                           value="{{ old('subtotal', $order->subtotal) }}"
                                           step="0.01"
                                           min="0"
                                           required>
                                    <label for="subtotal">
                                        <i class="bi bi-calculator me-2"></i>
                                        Sous-total (GNF)
                                    </label>
                                    @error('subtotal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" 
                                           class="form-control @error('tax_amount') is-invalid @enderror" 
                                           id="tax_amount" 
                                           name="tax_amount" 
                                           placeholder="TVA"
                                           value="{{ old('tax_amount', $order->tax_amount) }}"
                                           step="0.01"
                                           min="0"
                                           required>
                                    <label for="tax_amount">
                                        <i class="bi bi-percent me-2"></i>
                                        TVA (GNF)
                                    </label>
                                    @error('tax_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" 
                                           class="form-control @error('shipping_cost') is-invalid @enderror" 
                                           id="shipping_cost" 
                                           name="shipping_cost" 
                                           placeholder="Frais de livraison"
                                           value="{{ old('shipping_cost', $order->shipping_cost) }}"
                                           step="0.01"
                                           min="0"
                                           required>
                                    <label for="shipping_cost">
                                        <i class="bi bi-truck me-2"></i>
                                        Livraison (GNF)
                                    </label>
                                    @error('shipping_cost')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating">
                                    <input type="number" 
                                           class="form-control @error('discount_amount') is-invalid @enderror" 
                                           id="discount_amount" 
                                           name="discount_amount" 
                                           placeholder="Réduction"
                                           value="{{ old('discount_amount', $order->discount_amount) }}"
                                           step="0.01"
                                           min="0"
                                           required>
                                    <label for="discount_amount">
                                        <i class="bi bi-tag me-2"></i>
                                        Réduction (GNF)
                                    </label>
                                    @error('discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating">
                            <input type="number" 
                                   class="form-control @error('total_amount') is-invalid @enderror" 
                                   id="total_amount" 
                                   name="total_amount" 
                                   placeholder="Montant total"
                                   value="{{ old('total_amount', $order->total_amount) }}"
                                   step="0.01"
                                   min="0"
                                   required
                                   readonly
                                   style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); font-weight: bold; font-size: 1.2rem;">
                            <label for="total_amount">
                                <i class="bi bi-cash me-2"></i>
                                Total (GNF)
                            </label>
                            @error('total_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calcul automatique du total
            const subtotalInput = document.getElementById('subtotal');
            const taxAmountInput = document.getElementById('tax_amount');
            const shippingCostInput = document.getElementById('shipping_cost');
            const discountAmountInput = document.getElementById('discount_amount');
            const totalAmountInput = document.getElementById('total_amount');

            function calculateTotal() {
                const subtotal = parseFloat(subtotalInput.value) || 0;
                const taxAmount = parseFloat(taxAmountInput.value) || 0;
                const shippingCost = parseFloat(shippingCostInput.value) || 0;
                const discountAmount = parseFloat(discountAmountInput.value) || 0;
                
                const total = subtotal + taxAmount + shippingCost - discountAmount;
                totalAmountInput.value = Math.max(0, total).toFixed(2);
            }

            // Écouteurs d'événements pour le calcul automatique
            [subtotalInput, taxAmountInput, shippingCostInput, discountAmountInput].forEach(input => {
                input.addEventListener('input', calculateTotal);
            });

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
                
                // Vérification des champs requis
                const requiredFields = ['customer_name', 'customer_email', 'shipping_address', 'shipping_city', 'shipping_country', 'shipping_method', 'status', 'payment_status'];
                
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

                // Validation email
                const emailField = document.getElementById('customer_email');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(emailField.value)) {
                    emailField.classList.add('is-invalid');
                    isValid = false;
                }

                // Validation des montants
                const amountFields = ['subtotal', 'tax_amount', 'shipping_cost', 'discount_amount', 'total_amount'];
                amountFields.forEach(fieldName => {
                    const field = document.getElementById(fieldName);
                    const value = parseFloat(field.value);
                    if (isNaN(value) || value < 0) {
                        field.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        field.classList.remove('is-invalid');
                        field.classList.add('is-valid');
                    }
                });

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

            // Calcul initial
            calculateTotal();
        });
    </script>
@endsection