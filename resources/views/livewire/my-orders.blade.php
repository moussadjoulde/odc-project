<div>
    <!-- Notification -->
    @if($notification)
        <div class="alert alert-{{ $notificationType === 'error' ? 'danger' : $notificationType }} alert-dismissible fade show" role="alert">
            {{ $notification }}
            <button type="button" class="btn-close" wire:click="clearNotification" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold mb-3">Mes Commandes</h1>
                    <p class="lead mb-0">Suivez l'état de toutes vos commandes en temps réel</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex align-items-center justify-content-lg-end gap-3">
                        <div class="bg-white bg-opacity-20 rounded-pill px-3 py-2">
                            <small class="text-black-50">Total commandes</small>
                            <div class="fw-bold text-blue-600">{{ $orders->total() ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4">
        <!-- Filtres et recherche -->
        <div class="floating-card p-4 mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-search me-2"></i>Rechercher
                    </label>
                    <input type="text" 
                           class="form-control" 
                           placeholder="Numéro de commande, produit..."
                           wire:model.debounce.500ms="search">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-funnel me-2"></i>Statut
                    </label>
                    <select class="form-select" wire:model="statusFilter">
                        <option value="">Tous les statuts</option>
                        <option value="pending">En attente</option>
                        <option value="confirmed">Confirmée</option>
                        <option value="processing">En traitement</option>
                        <option value="shipped">Expédiée</option>
                        <option value="delivered">Livrée</option>
                        <option value="cancelled">Annulée</option>
                        <option value="refunded">Remboursée</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">
                        <i class="bi bi-calendar me-2"></i>Période
                    </label>
                    <select class="form-select" wire:model="periodFilter">
                        <option value="">Toutes les périodes</option>
                        <option value="7">7 derniers jours</option>
                        <option value="30">30 derniers jours</option>
                        <option value="90">3 derniers mois</option>
                        <option value="365">Cette année</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-modern w-100" wire:click="applyFilters">
                        <span wire:loading.remove wire:target="applyFilters">
                            <i class="bi bi-search me-2"></i>Filtrer
                        </span>
                        <span wire:loading wire:target="applyFilters">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            Filtrage...
                        </span>
                    </button>
                </div>
            </div>
            @if($search || $statusFilter || $periodFilter)
                <div class="row mt-3">
                    <div class="col-12">
                        <button class="btn btn-outline-secondary btn-sm" wire:click="clearFilters">
                            <i class="bi bi-arrow-counterclockwise me-1"></i>
                            Effacer les filtres
                        </button>
                    </div>
                </div>
            @endif
        </div>

        <!-- Loading Indicator -->
        <div wire:loading.class="opacity-50" wire:target="search,statusFilter,periodFilter,applyFilters,clearFilters">
            <!-- Liste des commandes -->
            @if($orders->count() > 0)
                <div class="row">
                    @foreach($orders as $order)
                        <div class="col-12 mb-4" wire:key="order-{{ $order->id }}">
                            <div class="floating-card overflow-hidden">
                                <!-- En-tête de commande -->
                                <div class="d-flex justify-content-between align-items-start p-4 border-bottom">
                                    <div>
                                        <div class="d-flex align-items-center gap-3 mb-2">
                                            <h5 class="mb-0 fw-bold">#{{ $order->order_number }}</h5>
                                            @php
                                                $status = $this->statusConfig[$order->status] ?? [
                                                    'class' => 'secondary',
                                                    'icon' => 'question',
                                                    'text' => ucfirst($order->status),
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $status['class'] }} rounded-pill px-3 py-2">
                                                <i class="bi bi-{{ $status['icon'] }} me-1"></i>
                                                {{ $status['text'] }}
                                            </span>
                                        </div>
                                        <div class="text-muted">
                                            <i class="bi bi-calendar3 me-1"></i>
                                            {{ $order->created_at->format('d/m/Y à H:i') }}
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="h4 mb-1 fw-bold text-primary">
                                            {{ number_format($order->total_amount, 0, ',', ' ') }} GNF
                                        </div>
                                        <div class="text-muted small">
                                            @php
                                                $paymentStatus = $this->paymentStatusConfig[$order->payment_status] ?? [
                                                    'class' => 'secondary',
                                                    'text' => ucfirst($order->payment_status),
                                                ];
                                            @endphp
                                            <span class="badge bg-{{ $paymentStatus['class'] }} bg-opacity-10 text-{{ $paymentStatus['class'] }} border border-{{ $paymentStatus['class'] }} border-opacity-25">
                                                {{ $paymentStatus['text'] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Détails de la commande -->
                                <div class="p-4">
                                    <div class="row g-4">
                                        <!-- Informations de livraison -->
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="bi bi-geo-alt text-primary me-2"></i>
                                                Adresse de livraison
                                            </h6>
                                            <div class="text-muted">
                                                <div>{{ $order->customer_name }}</div>
                                                <div>{{ $order->shipping_address }}</div>
                                                <div>{{ $order->shipping_city }}, {{ $order->shipping_country }}</div>
                                                @if($order->shipping_postal_code)
                                                    <div>{{ $order->shipping_postal_code }}</div>
                                                @endif
                                            </div>
                                            @if($order->customer_phone)
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="bi bi-telephone me-1"></i>
                                                        {{ $order->customer_phone }}
                                                    </small>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Informations de paiement et expédition -->
                                        <div class="col-md-6">
                                            <h6 class="fw-semibold mb-3">
                                                <i class="bi bi-credit-card text-primary me-2"></i>
                                                Paiement & Livraison
                                            </h6>
                                            <div class="row g-2">
                                                @if($order->payment_method)
                                                    <div class="col-12">
                                                        <small class="text-muted">Mode de paiement:</small>
                                                        <div class="fw-medium">
                                                            {{ $this->paymentMethods[$order->payment_method] ?? ucfirst($order->payment_method) }}
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-12">
                                                    <small class="text-muted">Mode de livraison:</small>
                                                    <div class="fw-medium">
                                                        {{ $this->shippingMethods[$order->shipping_method] ?? ucfirst($order->shipping_method) }}
                                                    </div>
                                                </div>
                                                @if($order->tracking_number)
                                                    <div class="col-12">
                                                        <small class="text-muted">Numéro de suivi:</small>
                                                        <div class="fw-medium text-primary">{{ $order->tracking_number }}</div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    @if($order->shipped_at || $order->delivered_at)
                                        <div class="row mt-3">
                                            <div class="col-12">
                                                <div class="bg-light rounded-3 p-3">
                                                    <div class="row text-center">
                                                        @if($order->shipped_at)
                                                            <div class="col-md-6">
                                                                <i class="bi bi-truck text-success fs-4"></i>
                                                                <div class="mt-1">
                                                                    <small class="text-muted">Expédié le</small>
                                                                    <div class="fw-medium">
                                                                        {{ \Carbon\Carbon::parse($order->shipped_at)->format('d/m/Y à H:i') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        @if($order->delivered_at)
                                                            <div class="col-md-6">
                                                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                                                <div class="mt-1">
                                                                    <small class="text-muted">Livré le</small>
                                                                    <div class="fw-medium">
                                                                        {{ \Carbon\Carbon::parse($order->delivered_at)->format('d/m/Y à H:i') }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if($order->notes)
                                        <div class="mt-3">
                                            <small class="text-muted">Note:</small>
                                            <div class="text-muted">{{ $order->notes }}</div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Actions -->
                                <div class="border-top p-4">
                                    <div class="d-flex flex-wrap gap-2 justify-content-end">
                                        <button class="btn btn-outline-primary btn-sm" 
                                                wire:click="viewOrderDetails({{ $order->id }})">
                                            <span wire:loading.remove wire:target="viewOrderDetails({{ $order->id }})">
                                                <i class="bi bi-eye me-1"></i>Voir détails
                                            </span>
                                            <span wire:loading wire:target="viewOrderDetails({{ $order->id }})">
                                                <div class="spinner-border spinner-border-sm me-1" role="status"></div>
                                                Chargement...
                                            </span>
                                        </button>

                                        @if($order->status === 'delivered')
                                            <button class="btn btn-outline-success btn-sm"
                                                    wire:click="leaveReview({{ $order->id }})">
                                                <span wire:loading.remove wire:target="leaveReview({{ $order->id }})">
                                                    <i class="bi bi-star me-1"></i>Laisser un avis
                                                </span>
                                                <span wire:loading wire:target="leaveReview({{ $order->id }})">
                                                    <div class="spinner-border spinner-border-sm me-1" role="status"></div>
                                                </span>
                                            </button>
                                        @endif

                                        @if(in_array($order->status, ['pending', 'confirmed']) && $order->payment_status !== 'paid')
                                            <button class="btn btn-outline-warning btn-sm"
                                                    wire:click="payNow({{ $order->id }})">
                                                <span wire:loading.remove wire:target="payNow({{ $order->id }})">
                                                    <i class="bi bi-credit-card me-1"></i>Payer maintenant
                                                </span>
                                                <span wire:loading wire:target="payNow({{ $order->id }})">
                                                    <div class="spinner-border spinner-border-sm me-1" role="status"></div>
                                                </span>
                                            </button>
                                        @endif

                                        @if($order->tracking_number)
                                            <button class="btn btn-outline-info btn-sm"
                                                    wire:click="trackOrder('{{ $order->tracking_number }}')">
                                                <span wire:loading.remove wire:target="trackOrder('{{ $order->tracking_number }}')">
                                                    <i class="bi bi-geo-alt me-1"></i>Suivre
                                                </span>
                                                <span wire:loading wire:target="trackOrder('{{ $order->tracking_number }}')">
                                                    <div class="spinner-border spinner-border-sm me-1" role="status"></div>
                                                </span>
                                            </button>
                                        @endif

                                        @if(in_array($order->status, ['pending', 'confirmed']) && $order->payment_status !== 'paid')
                                            <button class="btn btn-outline-danger btn-sm"
                                                    wire:click="cancelOrder({{ $order->id }})"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                                <span wire:loading.remove wire:target="cancelOrder({{ $order->id }})">
                                                    <i class="bi bi-x-circle me-1"></i>Annuler
                                                </span>
                                                <span wire:loading wire:target="cancelOrder({{ $order->id }})">
                                                    <div class="spinner-border spinner-border-sm me-1" role="status"></div>
                                                    Annulation...
                                                </span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
            @else
                <!-- État vide -->
                <div class="floating-card text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-bag text-muted" style="font-size: 4rem;"></i>
                    </div>
                    @if($search || $statusFilter || $periodFilter)
                        <h3 class="text-muted mb-3">Aucun résultat trouvé</h3>
                        <p class="text-muted mb-4">Aucune commande ne correspond à vos critères de recherche.</p>
                        <button class="btn btn-outline-primary" wire:click="clearFilters">
                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                            Effacer les filtres
                        </button>
                    @else
                        <h3 class="text-muted mb-3">Aucune commande trouvée</h3>
                        <p class="text-muted mb-4">Vous n'avez pas encore passé de commande.</p>
                        <a href="{{ url('/shop') ?? '#' }}" class="btn btn-modern">
                            <i class="bi bi-shop me-2"></i>
                            Commencer mes achats
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Scripts pour fonctionnalités supplémentaires -->
    <script>
        // Écouter l'événement pour masquer la notification automatiquement
        // window.addEventListener('hideNotificationAfter', event => {
        //     setTimeout(() => {
        //         @this.call('clearNotification');
        //     }, event.detail);
        // });

        // Écouter l'événement pour ouvrir la modal de suivi
        window.addEventListener('openTrackingModal', event => {
            // Implémentation de la modal de suivi
            console.log('Ouvrir modal de suivi pour:', event.detail);
            // Ici vous pouvez ouvrir une modal Bootstrap par exemple
        });

        // Écouter l'événement pour ouvrir la modal d'avis
        window.addEventListener('openReviewModal', event => {
            // Implémentation de la modal d'avis
            console.log('Ouvrir modal d\'avis pour la commande:', event.detail);
            // Ici vous pouvez ouvrir une modal Bootstrap par exemple
        });
    </script>
</div>