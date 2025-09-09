@extends('layouts.product')

@section('title', 'Commande #' . $order->order_number)

@section('content')
    <style>
        /* Styles personnalisés pour l'affichage de la commande */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .detail-header {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .detail-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .detail-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .detail-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .detail-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }

        .detail-body {
            padding: 2.5rem;
        }

        .section-header {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid #4299e1;
        }

        .section-title {
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: #f8fafc;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .info-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .info-label {
            font-weight: 600;
            color: #718096;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-weight: 700;
            color: #2d3748;
            font-size: 1.1rem;
            line-height: 1.4;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-weight: 700;
            font-size: 0.875rem;
            display: inline-flex;
            align-items: center;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        .breadcrumb-modern {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-modern .breadcrumb-item {
            font-weight: 600;
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: #4299e1;
        }

        .breadcrumb-modern a {
            color: #718096;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-modern a:hover {
            color: #4299e1;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 2px solid #e2e8f0;
        }

        .btn-modern {
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: 2px solid;
            display: inline-flex;
            align-items: center;
        }

        .btn-primary-modern {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(66, 153, 225, 0.4);
        }

        .btn-primary-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(66, 153, 225, 0.6);
            color: white;
        }

        .btn-warning-modern {
            background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(246, 173, 85, 0.4);
        }

        .btn-warning-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(246, 173, 85, 0.6);
            color: white;
        }

        .btn-success-modern {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            border-color: transparent;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.4);
        }

        .btn-success-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(72, 187, 120, 0.6);
            color: white;
        }

        .btn-outline-modern {
            background: transparent;
            color: #4299e1;
            border-color: #4299e1;
        }

        .btn-outline-modern:hover {
            background: #4299e1;
            color: white;
            transform: translateY(-2px);
        }

        .timeline {
            position: relative;
            padding: 1rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 20px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
        }

        .timeline-item {
            position: relative;
            padding-left: 3rem;
            margin-bottom: 2rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 14px;
            top: 0;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: white;
            border: 3px solid #4299e1;
            z-index: 1;
        }

        .timeline-item.completed::before {
            background: #38a169;
            border-color: #38a169;
        }

        .timeline-content {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        .timeline-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 0.5rem;
        }

        .timeline-date {
            color: #718096;
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .timeline-description {
            color: #4a5568;
            line-height: 1.6;
        }

        .amount-display {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            margin: 1rem 0;
        }

        .amount-value {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .amount-label {
            font-size: 1rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .notes-section {
            background: #fefefe;
            border-radius: 12px;
            padding: 1.5rem;
            border: 1px solid #e2e8f0;
            margin-top: 1rem;
        }

        .notes-title {
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .notes-content {
            background: #f8fafc;
            border-radius: 8px;
            padding: 1rem;
            border-left: 4px solid #4299e1;
            color: #4a5568;
            line-height: 1.6;
            font-style: italic;
        }

        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #68d391 0%, #38a169 100%);
            color: white;
        }

        .detail-card {
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
            .detail-header h1 {
                font-size: 2rem;
            }

            .detail-body {
                padding: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
            }

            .amount-value {
                font-size: 2rem;
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
                    <i class="bi bi-receipt me-1"></i>
                    {{ $order->order_number }}
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

        <div class="row">
            <!-- Détails de la commande -->
            <div class="col-lg-8">
                <div class="detail-card">
                    <!-- Header -->
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="bi bi-receipt"></i>
                        </div>
                        <h1>Commande {{ $order->order_number }}</h1>
                        <p>Détails complets de la commande</p>
                    </div>

                    <!-- Corps -->
                    <div class="detail-body">
                        <!-- Informations générales -->
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="bi bi-info-circle me-2"></i>
                                Informations Générales
                            </h3>
                        </div>

                        <div class="info-grid">
                            <div class="info-card">
                                <div class="info-label">Numéro de commande</div>
                                <div class="info-value">{{ $order->order_number }}</div>
                            </div>

                            <div class="info-card">
                                <div class="info-label">Date de création</div>
                                <div class="info-value">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                            </div>

                            <div class="info-card">
                                <div class="info-label">Statut de la commande</div>
                                <div class="info-value">
                                    <span class="status-badge status-{{ $order->status }}">
                                        @switch($order->status)
                                            @case('pending')
                                                <i class="bi bi-clock me-2"></i>En attente
                                                @break
                                            @case('confirmed')
                                                <i class="bi bi-check-circle me-2"></i>Confirmée
                                                @break
                                            @case('processing')
                                                <i class="bi bi-gear me-2"></i>En traitement
                                                @break
                                            @case('shipped')
                                                <i class="bi bi-truck me-2"></i>Expédiée
                                                @break
                                            @case('delivered')
                                                <i class="bi bi-check-circle-fill me-2"></i>Livrée
                                                @break
                                            @case('cancelled')
                                                <i class="bi bi-x-circle me-2"></i>Annulée
                                                @break
                                            @case('refunded')
                                                <i class="bi bi-arrow-return-left me-2"></i>Remboursée
                                                @break
                                        @endswitch
                                    </span>
                                </div>
                            </div>

                            <div class="info-card">
                                <div class="info-label">Statut du paiement</div>
                                <div class="info-value">
                                    <span class="status-badge payment-{{ $order->payment_status }}">
                                        @switch($order->payment_status)
                                            @case('pending')
                                                <i class="bi bi-clock me-2"></i>En attente
                                                @break
                                            @case('paid')
                                                <i class="bi bi-check-circle me-2"></i>Payé
                                                @break
                                            @case('failed')
                                                <i class="bi bi-x-circle me-2"></i>Échoué
                                                @break
                                            @case('refunded')
                                                <i class="bi bi-arrow-return-left me-2"></i>Remboursé
                                                @break
                                            @case('partial')
                                                <i class="bi bi-dash-circle me-2"></i>Partiel
                                                @break
                                        @endswitch
                                    </span>
                                </div>
                            </div>

                            @if($order->payment_method)
                            <div class="info-card">
                                <div class="info-label">Méthode de paiement</div>
                                <div class="info-value">
                                    @switch($order->payment_method)
                                        @case('cash_on_delivery')
                                            <i class="bi bi-cash me-2"></i>Paiement à la livraison
                                            @break
                                        @case('mobile_money')
                                            <i class="bi bi-phone me-2"></i>Mobile Money
                                            @break
                                        @case('bank_transfer')
                                            <i class="bi bi-bank me-2"></i>Virement bancaire
                                            @break
                                        @case('card')
                                            <i class="bi bi-credit-card me-2"></i>Carte bancaire
                                            @break
                                        @case('wallet')
                                            <i class="bi bi-wallet me-2"></i>Portefeuille électronique
                                            @break
                                        @default
                                            {{ ucfirst($order->payment_method) }}
                                    @endswitch
                                </div>
                            </div>
                            @endif

                            <div class="info-card">
                                <div class="info-label">Méthode de livraison</div>
                                <div class="info-value">
                                    @switch($order->shipping_method)
                                        @case('standard')
                                            <i class="bi bi-truck me-2"></i>Livraison standard
                                            @break
                                        @case('express')
                                            <i class="bi bi-lightning me-2"></i>Livraison express
                                            @break
                                        @case('pickup')
                                            <i class="bi bi-shop me-2"></i>Retrait en magasin
                                            @break
                                        @default
                                            {{ ucfirst($order->shipping_method) }}
                                    @endswitch
                                </div>
                            </div>
                        </div>

                        @if($order->tracking_number)
                        <div class="info-grid">
                            <div class="info-card">
                                <div class="info-label">Numéro de suivi</div>
                                <div class="info-value">
                                    <i class="bi bi-truck me-2"></i>
                                    {{ $order->tracking_number }}
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Informations client -->
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="bi bi-person me-2"></i>
                                Informations Client
                            </h3>
                        </div>

                        <div class="info-grid">
                            <div class="info-card">
                                <div class="info-label">Nom du client</div>
                                <div class="info-value">{{ $order->customer_name }}</div>
                            </div>

                            <div class="info-card">
                                <div class="info-label">Email</div>
                                <div class="info-value">
                                    <a href="mailto:{{ $order->customer_email }}" class="text-decoration-none">
                                        <i class="bi bi-envelope me-2"></i>{{ $order->customer_email }}
                                    </a>
                                </div>
                            </div>

                            @if($order->customer_phone)
                            <div class="info-card">
                                <div class="info-label">Téléphone</div>
                                <div class="info-value">
                                    <a href="tel:{{ $order->customer_phone }}" class="text-decoration-none">
                                        <i class="bi bi-telephone me-2"></i>{{ $order->customer_phone }}
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Adresses -->
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="bi bi-geo-alt me-2"></i>
                                Adresses
                            </h3>
                        </div>

                        <div class="row">
                            <!-- Adresse de livraison -->
                            <div class="col-md-6 mb-3">
                                <div class="info-card h-100">
                                    <div class="info-label mb-3">
                                        <i class="bi bi-truck me-2"></i>Adresse de livraison
                                    </div>
                                    <div class="info-value">
                                        {{ $order->shipping_address }}<br>
                                        {{ $order->shipping_city }}
                                        @if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif<br>
                                        {{ $order->shipping_country }}
                                    </div>
                                </div>
                            </div>

                            <!-- Adresse de facturation -->
                            <div class="col-md-6 mb-3">
                                <div class="info-card h-100">
                                    <div class="info-label mb-3">
                                        <i class="bi bi-receipt me-2"></i>Adresse de facturation
                                    </div>
                                    <div class="info-value">
                                        @if($order->billing_address)
                                            {{ $order->billing_address }}<br>
                                            {{ $order->billing_city }}
                                            @if($order->billing_postal_code), {{ $order->billing_postal_code }}@endif<br>
                                            {{ $order->billing_country }}
                                        @else
                                            <span class="text-muted">Identique à l'adresse de livraison</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline de la commande -->
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="bi bi-clock-history me-2"></i>
                                Historique de la Commande
                            </h3>
                        </div>

                        <div class="timeline">
                            <div class="timeline-item completed">
                                <div class="timeline-content">
                                    <h5 class="timeline-title">Commande créée</h5>
                                    <div class="timeline-date">{{ $order->created_at->format('d/m/Y à H:i') }}</div>
                                    <div class="timeline-description">La commande a été créée et enregistrée dans le système.</div>
                                </div>
                            </div>

                            @if($order->status != 'pending')
                            <div class="timeline-item completed">
                                <div class="timeline-content">
                                    <h5 class="timeline-title">Commande confirmée</h5>
                                    <div class="timeline-date">{{ $order->updated_at->format('d/m/Y à H:i') }}</div>
                                    <div class="timeline-description">La commande a été confirmée et est en cours de traitement.</div>
                                </div>
                            </div>
                            @endif

                            @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                            <div class="timeline-item completed">
                                <div class="timeline-content">
                                    <h5 class="timeline-title">En traitement</h5>
                                    <div class="timeline-date">{{ $order->updated_at->format('d/m/Y à H:i') }}</div>
                                    <div class="timeline-description">La commande est en cours de préparation.</div>
                                </div>
                            </div>
                            @endif

                            @if(in_array($order->status, ['shipped', 'delivered']))
                            <div class="timeline-item completed">
                                <div class="timeline-content">
                                    <h5 class="timeline-title">Expédiée</h5>
                                    <div class="timeline-date">
                                        {{ $order->shipped_at ? $order->shipped_at->format('d/m/Y à H:i') : $order->updated_at->format('d/m/Y à H:i') }}
                                    </div>
                                    <div class="timeline-description">
                                        La commande a été expédiée.
                                        @if($order->tracking_number)
                                            Numéro de suivi: <strong>{{ $order->tracking_number }}</strong>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($order->status == 'delivered')
                            <div class="timeline-item completed">
                                <div class="timeline-content">
                                    <h5 class="timeline-title">Livrée</h5>
                                    <div class="timeline-date">
                                        {{ $order->delivered_at ? $order->delivered_at->format('d/m/Y à H:i') : $order->updated_at->format('d/m/Y à H:i') }}
                                    </div>
                                    <div class="timeline-description">La commande a été livrée avec succès.</div>
                                </div>
                            </div>
                            @endif

                            @if($order->status == 'cancelled')
                            <div class="timeline-item">
                                <div class="timeline-content">
                                    <h5 class="timeline-title text-danger">Commande annulée</h5>
                                    <div class="timeline-date">{{ $order->updated_at->format('d/m/Y à H:i') }}</div>
                                    <div class="timeline-description">La commande a été annulée.</div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Notes -->
                        @if($order->notes || $order->admin_notes)
                        <div class="section-header">
                            <h3 class="section-title">
                                <i class="bi bi-chat-text me-2"></i>
                                Notes et Commentaires
                            </h3>
                        </div>

                        @if($order->notes)
                        <div class="notes-section">
                            <h5 class="notes-title">
                                <i class="bi bi-person me-2"></i>
                                Notes du client
                            </h5>
                            <div class="notes-content">
                                {{ $order->notes }}
                            </div>
                        </div>
                        @endif

                        @if($order->admin_notes)
                        <div class="notes-section">
                            <h5 class="notes-title">
                                <i class="bi bi-shield-check me-2"></i>
                                Notes administratives
                            </h5>
                            <div class="notes-content">
                                {{ $order->admin_notes }}
                            </div>
                        </div>
                        @endif
                        @endif

                        <!-- Actions -->
                        <div class="action-buttons">
                            <a href="{{ route('orders.admin.index') }}" class="btn btn-outline-modern">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour à la liste
                            </a>
                            
                            <a href="{{ route('orders.admin.edit', $order) }}" class="btn btn-warning-modern">
                                <i class="bi bi-pencil me-2"></i>
                                Modifier
                            </a>
                            
                            <a href="{{ route('orders.admin.print', $order) }}" class="btn btn-success-modern" target="_blank">
                                <i class="bi bi-printer me-2"></i>
                                Imprimer
                            </a>
                            
                            @if($order->status == 'pending')
                            <button type="button" class="btn btn-primary-modern" onclick="updateStatus('confirmed')">
                                <i class="bi bi-check-circle me-2"></i>
                                Confirmer
                            </button>
                            @endif
                            
                            @if(in_array($order->status, ['pending', 'confirmed']))
                            <button type="button" class="btn btn-outline-modern text-danger border-danger" onclick="updateStatus('cancelled')">
                                <i class="bi bi-x-circle me-2"></i>
                                Annuler
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Résumé financier -->
            <div class="col-lg-4">
                <div class="detail-card">
                    <div class="detail-header" style="padding: 1.5rem;">
                        <h3 style="font-size: 1.5rem; margin: 0;">
                            <i class="bi bi-calculator me-2"></i>
                            Résumé Financier
                        </h3>
                    </div>
                    <div class="detail-body" style="padding: 1.5rem;">
                        <!-- Montant total -->
                        <div class="amount-display">
                            <div class="amount-value">{{ number_format($order->total_amount, 0) }}</div>
                            <div class="amount-label">GNF - Total</div>
                        </div>

                        <!-- Détail des montants -->
                        <div class="info-card">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="info-label">Sous-total</div>
                                    <div class="info-value">{{ number_format($order->subtotal, 0) }} GNF</div>
                                </div>
                                <div class="col-6">
                                    <div class="info-label">TVA</div>
                                    <div class="info-value">{{ number_format($order->tax_amount, 0) }} GNF</div>
                                </div>
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="info-label">Livraison</div>
                                    <div class="info-value">{{ number_format($order->shipping_cost, 0) }} GNF</div>
                                </div>
                                <div class="col-6">
                                    <div class="info-label">Réduction</div>
                                    <div class="info-value text-success">-{{ number_format($order->discount_amount, 0) }} GNF</div>
                                </div>
                            </div>

                            @if($order->coupon_code)
                            <div class="row">
                                <div class="col-12">
                                    <div class="info-label">Code promo utilisé</div>
                                    <div class="info-value">
                                        <span class="badge bg-success">{{ $order->coupon_code }}</span>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Statuts rapides -->
                        <div class="info-card">
                            <h6 class="info-label mb-3">Actions rapides</h6>
                            
                            @if($order->payment_status == 'pending')
                            <button type="button" class="btn btn-success-modern w-100 mb-2" onclick="updatePaymentStatus('paid')">
                                <i class="bi bi-check-circle me-2"></i>
                                Marquer comme payé
                            </button>
                            @endif
                            
                            @if($order->status == 'confirmed')
                            <button type="button" class="btn btn-primary-modern w-100 mb-2" onclick="updateStatus('processing')">
                                <i class="bi bi-gear me-2"></i>
                                Mettre en traitement
                            </button>
                            @endif
                            
                            @if($order->status == 'processing')
                            <button type="button" class="btn btn-success-modern w-100 mb-2" onclick="updateStatus('shipped')">
                                <i class="bi bi-truck me-2"></i>
                                Marquer comme expédiée
                            </button>
                            @endif
                            
                            @if($order->status == 'shipped')
                            <button type="button" class="btn btn-success-modern w-100 mb-2" onclick="updateStatus('delivered')">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Marquer comme livrée
                            </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Fonction pour mettre à jour le statut
        function updateStatus(newStatus) {
            if (confirm('Êtes-vous sûr de vouloir changer le statut de cette commande ?')) {
                // Créer un formulaire caché
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("orders.updateStatus", $order) }}';
                
                // Token CSRF
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Méthode PATCH
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                form.appendChild(methodField);
                
                // Nouveau statut
                const statusField = document.createElement('input');
                statusField.type = 'hidden';
                statusField.name = 'status';
                statusField.value = newStatus;
                form.appendChild(statusField);
                
                // Soumettre le formulaire
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Fonction pour mettre à jour le statut de paiement
        function updatePaymentStatus(newStatus) {
            if (confirm('Êtes-vous sûr de vouloir changer le statut de paiement ?')) {
                // Créer un formulaire caché
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("orders.updatePaymentStatus", $order) }}';
                
                // Token CSRF
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                // Méthode PATCH
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'PATCH';
                form.appendChild(methodField);
                
                // Nouveau statut
                const paymentStatusField = document.createElement('input');
                paymentStatusField.type = 'hidden';
                paymentStatusField.name = 'payment_status';
                paymentStatusField.value = newStatus;
                form.appendChild(paymentStatusField);
                
                // Soumettre le formulaire
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Animation au chargement
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.info-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(20px)';
                    card.style.transition = 'all 0.6s ease';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 100);
            });
        });
    </script>
@endsection