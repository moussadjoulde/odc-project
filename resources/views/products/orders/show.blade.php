@extends('layouts.app')

@section('title', 'Commande #' . $order->order_number)

@section('content')
<div class="container-fluid py-4">
    <!-- Header avec statut principal -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="floating-card p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <div>
                        <h1 class="h3 fw-bold mb-2">Commande #{{ $order->order_number }}</h1>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'primary') }} fs-6 px-3 py-2">
                                <i class="bi bi-{{ $order->status === 'delivered' ? 'check-circle' : ($order->status === 'shipped' ? 'truck' : ($order->status === 'processing' ? 'gear' : 'clock')) }} me-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                            <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : ($order->payment_status === 'failed' ? 'danger' : 'warning') }} fs-6 px-3 py-2">
                                <i class="bi bi-{{ $order->payment_status === 'paid' ? 'credit-card-check' : 'credit-card' }} me-1"></i>
                                Paiement {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        <p class="text-muted mt-2 mb-0">
                            <i class="bi bi-calendar3 me-1"></i>
                            Commandé le {{ $order->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    <div class="mt-3 mt-md-0">
                        <div class="d-flex gap-2">
                            @if($order->tracking_number && in_array($order->status, ['shipped', 'delivered']))
                                <button class="btn btn-outline-primary btn-sm" onclick="showTrackingModal('{{ $order->tracking_number }}')">
                                    <i class="bi bi-geo-alt me-1"></i> Suivre
                                </button>
                            @endif
                            @if($order->status === 'pending')
                                <button class="btn btn-outline-danger btn-sm" onclick="confirmCancelOrder('{{ $order->id }}')">
                                    <i class="bi bi-x-circle me-1"></i> Annuler
                                </button>
                            @endif
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Colonne principale - Articles et détails -->
        <div class="col-lg-8">
            <!-- Articles de la commande -->
            <div class="floating-card mb-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-bag-check me-2 text-primary"></i>
                        Articles commandés ({{ $order->orderItems->count() }})
                    </h5>
                </div>
                <div class="card-body p-4">
                    @foreach($order->orderItems as $item)
                        <div class="d-flex align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                            <div class="flex-shrink-0 me-3">
                                @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" 
                                         alt="{{ $item->product->name }}" 
                                         class="rounded" 
                                         style="width: 60px; height: 60px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width: 60px; height: 60px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-semibold mb-1">{{ $item->product->name }}</h6>
                                <p class="text-muted small mb-1">
                                    Quantité: {{ $item->quantity }} × {{ number_format($item->unit_price, 0, ',', ' ') }} GNF
                                </p>
                                @if($item->product_options)
                                    <div class="small text-muted">
                                        @foreach(json_decode($item->product_options, true) as $option => $value)
                                            <span class="badge bg-light text-dark me-1">{{ $option }}: {{ $value }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="text-end">
                                <div class="fw-bold">{{ number_format($item->total_price, 0, ',', ' ') }} GNF</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Timeline de la commande -->
            <div class="floating-card mb-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-clock-history me-2 text-primary"></i>
                        Historique de la commande
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="timeline">
                        @php
                            $statusHistory = [
                                ['status' => 'pending', 'label' => 'Commande passée', 'date' => $order->created_at, 'icon' => 'bi-cart-plus', 'color' => 'primary'],
                                ['status' => 'confirmed', 'label' => 'Commande confirmée', 'date' => null, 'icon' => 'bi-check-circle', 'color' => 'info'],
                                ['status' => 'processing', 'label' => 'En préparation', 'date' => null, 'icon' => 'bi-gear', 'color' => 'warning'],
                                ['status' => 'shipped', 'label' => 'Expédiée', 'date' => $order->shipped_at, 'icon' => 'bi-truck', 'color' => 'success'],
                                ['status' => 'delivered', 'label' => 'Livrée', 'date' => $order->delivered_at, 'icon' => 'bi-house-check', 'color' => 'success']
                            ];
                            $currentStatusIndex = array_search($order->status, array_column($statusHistory, 'status'));
                        @endphp

                        @foreach($statusHistory as $index => $step)
                            @php
                                $isCompleted = $index <= $currentStatusIndex;
                                $isCurrent = $index === $currentStatusIndex;
                            @endphp
                            <div class="timeline-item {{ $isCompleted ? 'completed' : '' }} {{ $isCurrent ? 'current' : '' }}">
                                <div class="timeline-marker bg-{{ $isCompleted ? $step['color'] : 'light' }}">
                                    <i class="bi {{ $step['icon'] }} text-{{ $isCompleted ? 'white' : 'muted' }}"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="fw-semibold">{{ $step['label'] }}</div>
                                    @if($step['date'] && $isCompleted)
                                        <small class="text-muted">{{ $step['date']->format('d/m/Y à H:i') }}</small>
                                    @elseif($isCompleted && !$step['date'])
                                        <small class="text-success">Étape validée</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach

                        @if($order->status === 'cancelled')
                            <div class="timeline-item completed">
                                <div class="timeline-marker bg-danger">
                                    <i class="bi bi-x-circle text-white"></i>
                                </div>
                                <div class="timeline-content">
                                    <div class="fw-semibold text-danger">Commande annulée</div>
                                    <small class="text-muted">{{ $order->updated_at->format('d/m/Y à H:i') }}</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Colonne droite - Résumé et informations -->
        <div class="col-lg-4">
            <!-- Résumé financier -->
            <div class="floating-card mb-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-receipt me-2 text-primary"></i>
                        Résumé de la commande
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Sous-total</span>
                        <span>{{ number_format($order->subtotal, 0, ',', ' ') }} GNF</span>
                    </div>
                    @if($order->discount_amount > 0)
                        <div class="d-flex justify-content-between mb-2 text-success">
                            <span>
                                <i class="bi bi-tag me-1"></i>
                                Remise @if($order->coupon_code)({{ $order->coupon_code }})@endif
                            </span>
                            <span>-{{ number_format($order->discount_amount, 0, ',', ' ') }} GNF</span>
                        </div>
                    @endif
                    @if($order->tax_amount > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span>Taxes</span>
                            <span>{{ number_format($order->tax_amount, 0, ',', ' ') }} GNF</span>
                        </div>
                    @endif
                    @if($order->shipping_cost > 0)
                        <div class="d-flex justify-content-between mb-2">
                            <span>Livraison</span>
                            <span>{{ number_format($order->shipping_cost, 0, ',', ' ') }} GNF</span>
                        </div>
                    @endif
                    <hr>
                    <div class="d-flex justify-content-between fw-bold fs-5">
                        <span>Total</span>
                        <span class="text-primary">{{ number_format($order->total_amount, 0, ',', ' ') }} GNF</span>
                    </div>
                </div>
            </div>

            <!-- Informations client -->
            <div class="floating-card mb-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-person me-2 text-primary"></i>
                        Informations client
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <strong>{{ $order->customer_name }}</strong><br>
                        <i class="bi bi-envelope me-1 text-muted"></i>
                        <a href="mailto:{{ $order->customer_email }}" class="text-decoration-none">{{ $order->customer_email }}</a><br>
                        @if($order->customer_phone)
                            <i class="bi bi-telephone me-1 text-muted"></i>
                            <a href="tel:{{ $order->customer_phone }}" class="text-decoration-none">{{ $order->customer_phone }}</a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Adresses -->
            <div class="floating-card mb-4">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-geo-alt me-2 text-primary"></i>
                        Adresses
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <h6 class="fw-semibold mb-2">
                            <i class="bi bi-truck me-1"></i>
                            Adresse de livraison
                        </h6>
                        <address class="mb-0">
                            {{ $order->shipping_address }}<br>
                            {{ $order->shipping_city }}
                            @if($order->shipping_postal_code), {{ $order->shipping_postal_code }}@endif<br>
                            {{ $order->shipping_country }}
                        </address>
                    </div>
                    
                    @if($order->billing_address)
                        <div>
                            <h6 class="fw-semibold mb-2">
                                <i class="bi bi-receipt me-1"></i>
                                Adresse de facturation
                            </h6>
                            <address class="mb-0">
                                {{ $order->billing_address }}<br>
                                {{ $order->billing_city }}
                                @if($order->billing_postal_code), {{ $order->billing_postal_code }}@endif<br>
                                {{ $order->billing_country }}
                            </address>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informations de paiement et livraison -->
            <div class="floating-card">
                <div class="card-header bg-transparent border-bottom-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0">
                        <i class="bi bi-info-circle me-2 text-primary"></i>
                        Détails supplémentaires
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Méthode de paiement</span>
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-{{ $order->payment_method === 'cash_on_delivery' ? 'cash' : ($order->payment_method === 'mobile_money' ? 'phone' : 'credit-card') }} me-1"></i>
                                {{ ucfirst(str_replace('_', ' ', $order->payment_method ?? 'Non défini')) }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Mode de livraison</span>
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-{{ $order->shipping_method === 'express' ? 'lightning' : ($order->shipping_method === 'pickup' ? 'shop' : 'truck') }} me-1"></i>
                                {{ ucfirst($order->shipping_method) }}
                            </span>
                        </div>
                        @if($order->tracking_number)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-muted">N° de suivi</span>
                                <code class="bg-light px-2 py-1 rounded">{{ $order->tracking_number }}</code>
                            </div>
                        @endif
                    </div>

                    @if($order->notes)
                        <div class="mt-3">
                            <h6 class="fw-semibold mb-2">Notes de commande</h6>
                            <p class="small text-muted mb-0 p-3 bg-light rounded">{{ $order->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de suivi -->
<div class="modal fade" id="trackingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-geo-alt me-2"></i>
                    Suivi de commande
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="mb-3">
                        <i class="bi bi-truck fs-1 text-primary"></i>
                    </div>
                    <h6>Numéro de suivi</h6>
                    <code id="trackingCode" class="fs-5 bg-light px-3 py-2 rounded"></code>
                    <p class="text-muted mt-3">
                        Utilisez ce numéro pour suivre votre colis auprès du transporteur.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .timeline {
        position: relative;
        padding-left: 0;
    }

    .timeline-item {
        position: relative;
        padding-left: 60px;
        padding-bottom: 30px;
    }

    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 20px;
        top: 40px;
        bottom: -10px;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item.completed:not(:last-child)::before {
        background: #28a745;
    }

    .timeline-marker {
        position: absolute;
        left: 0;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .timeline-item.current .timeline-marker {
        animation: pulse 2s infinite;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1), 0 0 0 4px rgba(13, 110, 253, 0.25);
    }

    @keyframes pulse {
        0% { box-shadow: 0 2px 8px rgba(0,0,0,0.1), 0 0 0 0 rgba(13, 110, 253, 0.7); }
        70% { box-shadow: 0 2px 8px rgba(0,0,0,0.1), 0 0 0 10px rgba(13, 110, 253, 0); }
        100% { box-shadow: 0 2px 8px rgba(0,0,0,0.1), 0 0 0 0 rgba(13, 110, 253, 0); }
    }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        border-left: 3px solid #dee2e6;
    }

    .timeline-item.completed .timeline-content {
        border-left-color: #28a745;
        background: rgba(40, 167, 69, 0.05);
    }

    .timeline-item.current .timeline-content {
        border-left-color: #007bff;
        background: rgba(13, 110, 253, 0.05);
    }

    @media (max-width: 768px) {
        .floating-card .d-flex.gap-2 {
            gap: 0.5rem !important;
        }
        
        .btn-sm {
            font-size: 0.8rem;
            padding: 0.375rem 0.75rem;
        }
        
        .timeline-item {
            padding-left: 50px;
        }
        
        .timeline-marker {
            width: 35px;
            height: 35px;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    function showTrackingModal(trackingNumber) {
        document.getElementById('trackingCode').textContent = trackingNumber;
        new bootstrap.Modal(document.getElementById('trackingModal')).show();
    }

    function confirmCancelOrder(orderId) {
        if (confirm('Êtes-vous sûr de vouloir annuler cette commande ? Cette action est irréversible.')) {
            // Ici vous pouvez ajouter l'appel AJAX pour annuler la commande
            fetch(`/orders/${orderId}/cancel`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('success', 'Commande annulée avec succès');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast('error', data.message || 'Erreur lors de l\'annulation');
                }
            })
            .catch(error => {
                showToast('error', 'Erreur réseau lors de l\'annulation');
            });
        }
    }
</script>
@endpush