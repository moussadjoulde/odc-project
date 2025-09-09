@extends('layouts.product')

@section('title', 'Gestion des Commandes')

@section('content')
    <style>
        /* Styles personnalisés pour la page commandes */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            line-height: 1;
        }

        .stat-label {
            color: #718096;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .page-header {
            position: relative;
            padding: 3rem 0;
            margin-bottom: 2rem;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            right: -100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 20px;
            z-index: -1;
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        .search-box {
            background: white;
            border-radius: 50px;
            padding: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        .search-box .input-group-text {
            background: transparent;
            border: none;
            color: #667eea;
        }

        .table-modern {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table-modern thead {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .table-modern thead th {
            border: none;
            padding: 1.25rem 1rem;
            font-weight: 700;
            color: #2d3748;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
            border: none;
        }

        .table-modern tbody tr:hover {
            background: #f7fafc;
            transform: scale(1.01);
        }

        .table-modern tbody td {
            padding: 1.25rem 1rem;
            border: none;
            vertical-align: middle;
        }

        .order-avatar {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .btn-group-modern .btn {
            border-radius: 8px;
            margin: 0 2px;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            transform: translateY(-1px);
        }

        .btn-outline-warning:hover {
            background: #f6ad55;
            border-color: #f6ad55;
            transform: translateY(-1px);
        }

        .btn-outline-success:hover {
            background: #48bb78;
            border-color: #48bb78;
            transform: translateY(-1px);
        }

        .btn-outline-danger:hover {
            background: #fc8181;
            border-color: #fc8181;
            transform: translateY(-1px);
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 6rem;
            color: #e2e8f0;
            margin-bottom: 2rem;
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

        .alert-danger {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            color: white;
        }

        /* Status badges */
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            display: inline-block;
            text-align: center;
            min-width: 80px;
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

        /* Payment status badges */
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

        .amount-badge {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-weight: 700;
            font-size: 0.9rem;
            display: inline-block;
            min-width: 80px;
            text-align: center;
        }

        .filter-tabs {
            background: white;
            border-radius: 16px;
            padding: 0.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 2rem;
        }

        .filter-tab {
            background: transparent;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            color: #718096;
            transition: all 0.3s ease;
            margin: 0 0.25rem;
        }

        .filter-tab.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .filter-tab:hover:not(.active) {
            background: #f7fafc;
            color: #4a5568;
        }

        @media (max-width: 768px) {
            .stat-number {
                font-size: 2rem;
            }

            .page-header {
                padding: 2rem 0;
            }

            .btn-group-modern {
                flex-direction: column;
                gap: 0.25rem;
            }

            .filter-tabs {
                overflow-x: auto;
                white-space: nowrap;
                padding-bottom: 1rem;
            }
        }
    </style>

    <!-- Messages d'alerte -->
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

    @if (session('error'))
        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Erreur !</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header de la page -->
    <div class="page-header text-center">
        <div class="container-fluid">
            <div class="float-animation mb-4">
                <i class="bi bi-cart-check" style="font-size: 4rem; color: #667eea;"></i>
            </div>
            <h1 class="display-4 fw-bold mb-3" style="color: #2d3748;">Gestion des Commandes</h1>
            <p class="lead" style="color: #718096;">Suivez et gérez toutes vos commandes clients avec efficacité</p>
        </div>
    </div>

    <!-- Statistiques et Actions -->
    <div class="container-fluid">
        <div class="row mb-5">
            <!-- Statistiques -->
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="bi bi-cart text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="stat-label mb-2">Total Commandes</h6>
                                    <div class="stat-number">{{ count($orders) }}</div>
                                    <small class="text-muted">
                                        <i class="bi bi-graph-up text-success me-1"></i>
                                        Toutes commandes
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                        <i class="bi bi-clock text-warning" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="stat-label mb-2">En Attente</h6>
                                    <div class="stat-number">
                                        {{ $orders->where('status', 'pending')->count() }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-hourglass text-warning me-1"></i>
                                        À traiter
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                        <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="stat-label mb-2">Livrées</h6>
                                    <div class="stat-number">
                                        {{ $orders->where('status', 'delivered')->count() }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-truck text-success me-1"></i>
                                        Terminées
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-3">
                                    <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                        <i class="bi bi-currency-exchange text-info" style="font-size: 2rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="stat-label mb-2">CA Total</h6>
                                    <div class="stat-number" style="font-size: 1.8rem;">
                                        {{ number_format($orders->sum('total_amount'), 0) }}
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-cash text-info me-1"></i>
                                        GNF
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="col-lg-3 mb-4">
                <div class="stat-card d-flex flex-column justify-content-center">
                    <div class="text-center">
                        <h6 class="stat-label mb-4">Actions Rapides</h6>
                        <a href="{{ route('orders.admin.create') }}" class="btn btn-gradient-primary btn-lg mb-3 w-100">
                            <i class="bi bi-plus-circle me-2"></i>
                            Nouvelle Commande
                        </a>
                        <a href="#" class="btn btn-outline-secondary w-100 mb-2">
                            <i class="bi bi-download me-2"></i>
                            Exporter CSV
                        </a>
                        <a href="#" class="btn btn-outline-info w-100">
                            <i class="bi bi-graph-up me-2"></i>
                            Rapports
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres par statut -->
        <div class="filter-tabs text-center">
            <button class="filter-tab active" data-status="all">
                <i class="bi bi-grid me-2"></i>Toutes
            </button>
            <button class="filter-tab" data-status="pending">
                <i class="bi bi-clock me-2"></i>En attente
            </button>
            <button class="filter-tab" data-status="confirmed">
                <i class="bi bi-check-circle me-2"></i>Confirmées
            </button>
            <button class="filter-tab" data-status="processing">
                <i class="bi bi-gear me-2"></i>En traitement
            </button>
            <button class="filter-tab" data-status="shipped">
                <i class="bi bi-truck me-2"></i>Expédiées
            </button>
            <button class="filter-tab" data-status="delivered">
                <i class="bi bi-check-circle-fill me-2"></i>Livrées
            </button>
            <button class="filter-tab" data-status="cancelled">
                <i class="bi bi-x-circle me-2"></i>Annulées
            </button>
        </div>

        <!-- Table des commandes -->
        <div class="card border-0 table-modern">
            <div class="card-header bg-white border-0 py-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="card-title mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-list-ul me-3 text-primary"></i>
                            Liste des Commandes
                            <span class="badge bg-primary bg-opacity-10 text-primary ms-3 rounded-pill px-3">
                                {{ count($orders) }}
                            </span>
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <div class="search-box">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Rechercher une commande..."
                                    id="searchInput">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($orders) > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="ordersTable">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">
                                        <i class="bi bi-hash me-1"></i>ID
                                    </th>
                                    <th>
                                        <i class="bi bi-receipt me-2"></i>
                                        Numéro
                                    </th>
                                    <th>
                                        <i class="bi bi-person me-2"></i>
                                        Client
                                    </th>
                                    <th class="text-center">
                                        <i class="bi bi-toggle-on me-2"></i>
                                        Statut
                                    </th>
                                    <th class="text-center">
                                        <i class="bi bi-credit-card me-2"></i>
                                        Paiement
                                    </th>
                                    <th class="text-center">
                                        <i class="bi bi-cash me-2"></i>
                                        Montant
                                    </th>
                                    <th class="text-center">
                                        <i class="bi bi-calendar me-2"></i>
                                        Date
                                    </th>
                                    <th class="text-center" style="width: 200px;">
                                        <i class="bi bi-gear me-2"></i>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr data-status="{{ $order->status }}">
                                        <!-- ID -->
                                        <td>
                                            <div class="order-avatar">
                                                {{ $order->id }}
                                            </div>
                                        </td>

                                        <!-- Numéro de commande -->
                                        <td>
                                            <div>
                                                <h6 class="mb-1 fw-bold" style="color: #2d3748;">
                                                    {{ $order->order_number }}
                                                </h6>
                                                @if($order->tracking_number)
                                                    <small class="text-muted d-flex align-items-center">
                                                        <i class="bi bi-truck me-1"></i>
                                                        {{ $order->tracking_number }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Client -->
                                        <td>
                                            <div>
                                                <h6 class="mb-1 fw-bold" style="color: #2d3748;">{{ $order->customer_name }}</h6>
                                                <small class="text-muted d-flex align-items-center">
                                                    <i class="bi bi-envelope me-1"></i>
                                                    {{ $order->customer_email }}
                                                </small>
                                                @if($order->customer_phone)
                                                    <small class="text-muted d-flex align-items-center">
                                                        <i class="bi bi-telephone me-1"></i>
                                                        {{ $order->customer_phone }}
                                                    </small>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Statut de la commande -->
                                        <td class="text-center">
                                            <span class="status-badge status-{{ $order->status }}">
                                                @switch($order->status)
                                                    @case('pending')
                                                        <i class="bi bi-clock me-1"></i>En attente
                                                        @break
                                                    @case('confirmed')
                                                        <i class="bi bi-check-circle me-1"></i>Confirmée
                                                        @break
                                                    @case('processing')
                                                        <i class="bi bi-gear me-1"></i>En traitement
                                                        @break
                                                    @case('shipped')
                                                        <i class="bi bi-truck me-1"></i>Expédiée
                                                        @break
                                                    @case('delivered')
                                                        <i class="bi bi-check-circle-fill me-1"></i>Livrée
                                                        @break
                                                    @case('cancelled')
                                                        <i class="bi bi-x-circle me-1"></i>Annulée
                                                        @break
                                                    @case('refunded')
                                                        <i class="bi bi-arrow-return-left me-1"></i>Remboursée
                                                        @break
                                                @endswitch
                                            </span>
                                        </td>

                                        <!-- Statut de paiement -->
                                        <td class="text-center">
                                            <span class="status-badge payment-{{ $order->payment_status }}">
                                                @switch($order->payment_status)
                                                    @case('pending')
                                                        <i class="bi bi-clock me-1"></i>En attente
                                                        @break
                                                    @case('paid')
                                                        <i class="bi bi-check-circle me-1"></i>Payé
                                                        @break
                                                    @case('failed')
                                                        <i class="bi bi-x-circle me-1"></i>Échoué
                                                        @break
                                                    @case('refunded')
                                                        <i class="bi bi-arrow-return-left me-1"></i>Remboursé
                                                        @break
                                                    @case('partial')
                                                        <i class="bi bi-dash-circle me-1"></i>Partiel
                                                        @break
                                                @endswitch
                                            </span>
                                        </td>

                                        <!-- Montant -->
                                        <td class="text-center">
                                            <span class="amount-badge">
                                                {{ number_format($order->total_amount, 0) }} GNF
                                            </span>
                                        </td>

                                        <!-- Date -->
                                        <td class="text-center">
                                            <div>
                                                <strong style="color: #2d3748;">{{ $order->created_at->format('d/m/Y') }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}</small>
                                            </div>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="btn-group-modern d-flex justify-content-center" role="group">
                                                <!-- Voir -->
                                                <a href="{{ route('orders.admin.show', $order) }}"
                                                    class="btn btn-outline-primary btn-sm" title="Voir les détails"
                                                    data-bs-toggle="tooltip">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <!-- Modifier -->
                                                <a href="{{ route('orders.admin.edit', $order) }}"
                                                    class="btn btn-outline-warning btn-sm" title="Modifier"
                                                    data-bs-toggle="tooltip">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <!-- Imprimer -->
                                                <a href="{{ route('orders.admin.print', $order) }}"
                                                    class="btn btn-outline-success btn-sm" title="Imprimer"
                                                    data-bs-toggle="tooltip" target="_blank">
                                                    <i class="bi bi-printer"></i>
                                                </a>

                                                <!-- Supprimer -->
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    title="Supprimer" data-bs-toggle="tooltip"
                                                    onclick="confirmDelete('{{ $order->order_number }}', '{{ route('orders.admin.destroy', $order) }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- État vide -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-cart-x"></i>
                    </div>
                    <h3 class="fw-bold mb-3" style="color: #4a5568;">Aucune commande trouvée</h3>
                    <p class="text-muted mb-4 fs-5">Vos premières commandes apparaîtront ici dès qu'elles seront passées.</p>
                    <a href="{{ route('orders.admin.create') }}" class="btn btn-gradient-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>
                        Créer une nouvelle commande
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal pour confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel" style="color: #2d3748;">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                        Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted mb-4">Êtes-vous sûr de vouloir supprimer la commande <strong
                            id="orderToDelete"></strong> ?</p>
                    <div class="alert alert-warning border-0"
                        style="border-radius: 12px; background: rgba(255, 193, 7, 0.1);">
                        <i class="bi bi-info-circle text-warning me-2"></i>
                        Cette action est irréversible et supprimera toutes les données associées à cette commande.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        style="border-radius: 8px;">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="border-radius: 8px;">
                            <i class="bi bi-trash me-1"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour changement de statut rapide -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-2">
                    <h5 class="modal-title fw-bold" id="statusModalLabel" style="color: #2d3748;">
                        <i class="bi bi-arrow-repeat text-primary me-2"></i>
                        Changer le statut de la commande
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="orderStatus" class="form-label fw-bold">Nouveau statut :</label>
                            <select class="form-select" id="orderStatus" name="status" style="border-radius: 8px;">
                                <option value="pending">En attente</option>
                                <option value="confirmed">Confirmée</option>
                                <option value="processing">En traitement</option>
                                <option value="shipped">Expédiée</option>
                                <option value="delivered">Livrée</option>
                                <option value="cancelled">Annulée</option>
                                <option value="refunded">Remboursée</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="adminNotes" class="form-label fw-bold">Notes administratives (optionnel) :</label>
                            <textarea class="form-control" id="adminNotes" name="admin_notes" rows="3" 
                                style="border-radius: 8px;" placeholder="Ajoutez une note concernant ce changement de statut..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        style="border-radius: 8px;">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <button type="submit" form="statusForm" class="btn btn-primary" style="border-radius: 8px;">
                        <i class="bi bi-check-circle me-1"></i>Mettre à jour
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Fonction de recherche améliorée
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('ordersTable');

            if (searchInput && table) {
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                    for (let i = 0; i < rows.length; i++) {
                        let found = false;
                        const cells = rows[i].getElementsByTagName('td');

                        // Rechercher dans le numéro de commande, nom client, email
                        for (let j = 1; j <= 2; j++) {
                            if (cells[j]) {
                                const textValue = cells[j].textContent || cells[j].innerText;
                                if (textValue.toLowerCase().indexOf(filter) > -1) {
                                    found = true;
                                    break;
                                }
                            }
                        }

                        rows[i].style.display = found ? '' : 'none';
                    }

                    // Animation pour les résultats
                    const visibleRows = table.querySelectorAll('tbody tr[style=""]');
                    visibleRows.forEach((row, index) => {
                        setTimeout(() => {
                            row.style.opacity = '0';
                            row.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                row.style.transition = 'all 0.3s ease';
                                row.style.opacity = '1';
                                row.style.transform = 'translateY(0)';
                            }, 50);
                        }, index * 50);
                    });
                });
            }

            // Filtres par statut
            const filterTabs = document.querySelectorAll('.filter-tab');
            const tableRows = document.querySelectorAll('#ordersTable tbody tr');

            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Retirer la classe active de tous les onglets
                    filterTabs.forEach(t => t.classList.remove('active'));
                    // Ajouter la classe active à l'onglet cliqué
                    this.classList.add('active');

                    const status = this.dataset.status;

                    // Filtrer les lignes
                    tableRows.forEach(row => {
                        if (status === 'all' || row.dataset.status === status) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Animation pour les lignes visibles
                    const visibleRows = document.querySelectorAll('#ordersTable tbody tr[style=""]');
                    visibleRows.forEach((row, index) => {
                        setTimeout(() => {
                            row.style.opacity = '0';
                            row.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                row.style.transition = 'all 0.3s ease';
                                row.style.opacity = '1';
                                row.style.transform = 'translateY(0)';
                            }, 50);
                        }, index * 50);
                    });

                    // Mettre à jour le compteur
                    const visibleCount = visibleRows.length;
                    const badge = document.querySelector('.card-title .badge');
                    if (badge) {
                        badge.textContent = visibleCount;
                    }
                });
            });
        });

        // Fonction pour confirmer la suppression
        function confirmDelete(orderNumber, deleteUrl) {
            document.getElementById('orderToDelete').textContent = orderNumber;
            document.getElementById('deleteForm').action = deleteUrl;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Fonction pour changer le statut rapidement
        function changeStatus(orderId, currentStatus) {
            const form = document.getElementById('statusForm');
            form.action = `/orders/${orderId}/status`;
            
            const statusSelect = document.getElementById('orderStatus');
            statusSelect.value = currentStatus;

            const modal = new bootstrap.Modal(document.getElementById('statusModal'));
            modal.show();
        }

        // Animation au chargement
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'all 0.6s ease';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 200);
            });

            // Animation des lignes du tableau
            const tableRows = document.querySelectorAll('#ordersTable tbody tr');
            tableRows.forEach((row, index) => {
                setTimeout(() => {
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(-20px)';
                    row.style.transition = 'all 0.4s ease';
                    setTimeout(() => {
                        row.style.opacity = '1';
                        row.style.transform = 'translateX(0)';
                    }, 50);
                }, index * 100);
            });
        });

        // Mise à jour automatique des statuts (optionnel)
        function autoRefresh() {
            // Cette fonction peut être utilisée pour actualiser automatiquement les statuts
            // Par exemple, toutes les 30 secondes
            setTimeout(() => {
                // Ici vous pouvez faire un appel AJAX pour récupérer les nouveaux statuts
                // et mettre à jour l'interface sans recharger la page
                console.log('Auto-refresh des statuts...');
                autoRefresh(); // Récursion pour répéter
            }, 30000); // 30 secondes
        }

        // Démarrer l'auto-refresh (décommentez si nécessaire)
        // autoRefresh();

        // Fonction pour exporter les données filtrées
        function exportFiltered() {
            const visibleRows = document.querySelectorAll('#ordersTable tbody tr[style=""]');
            const orderIds = Array.from(visibleRows).map(row => row.dataset.orderId);
            
            // Créer un formulaire caché pour envoyer les IDs à exporter
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '#';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            const idsInput = document.createElement('input');
            idsInput.type = 'hidden';
            idsInput.name = 'order_ids';
            idsInput.value = JSON.stringify(orderIds);
            form.appendChild(idsInput);
            
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    </script>
@endsection