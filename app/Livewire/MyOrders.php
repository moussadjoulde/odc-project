<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MyOrders extends Component
{
    use WithPagination;

    // Propriétés pour les filtres
    public $search = '';
    public $statusFilter = '';
    public $periodFilter = '';

    // Messages de notification
    public $notification = null;
    public $notificationType = 'success';

    // Pagination
    protected $paginationTheme = 'bootstrap';

    // Propriétés à surveiller pour mise à jour automatique
    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
        'periodFilter' => ['except' => ''],
        'page' => ['except' => 1],
    ];

    protected $listeners = [
        'orderCanceled' => 'handleOrderCanceled',
        'paymentCompleted' => 'handlePaymentCompleted',
    ];

    public function mount()
    {
        // Initialisation si nécessaire
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingPeriodFilter()
    {
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->statusFilter = '';
        $this->periodFilter = '';
        $this->resetPage();

        $this->showNotification('Filtres effacés', 'info');
    }

    public function applyFilters()
    {
        $this->resetPage();
        $this->showNotification('Filtres appliqués', 'success');
    }

    public function viewOrderDetails($orderId)
    {
        // Redirection vers les détails de commande
        $this->redirectRoute('orders.show', $orderId);
    }

    public function trackOrder($trackingNumber)
    {
        $this->showNotification("Suivi de la commande: {$trackingNumber}", 'info');
        // Ici vous pourriez émettre un événement pour ouvrir une modal de suivi
        $this->emit('openTrackingModal', $trackingNumber);
    }

    public function cancelOrder($orderId)
    {
        try {
            $order = Order::where('id', $orderId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                $this->showNotification('Commande introuvable', 'error');
                return;
            }

            if (!in_array($order->status, ['pending', 'confirmed'])) {
                $this->showNotification('Cette commande ne peut plus être annulée', 'error');
                return;
            }

            if ($order->payment_status === 'paid') {
                $this->showNotification('Les commandes payées ne peuvent pas être annulées directement', 'error');
                return;
            }

            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => 'Annulée par le client'
            ]);

            $this->showNotification('Commande annulée avec succès', 'success');

            // Émettre un événement pour notifier d'autres composants si nécessaire
            $this->emit('orderCanceled', $orderId);
        } catch (\Exception $e) {
            $this->showNotification('Erreur lors de l\'annulation de la commande', 'error');
        }
    }

    public function payNow($orderId)
    {
        try {
            $order = Order::where('id', $orderId)
                ->where('user_id', Auth::id())
                ->first();

            if (!$order) {
                $this->showNotification('Commande introuvable', 'error');
                return;
            }

            if ($order->payment_status === 'paid') {
                $this->showNotification('Cette commande est déjà payée', 'info');
                return;
            }

            // Rediriger vers la page de paiement
            $this->redirectRoute('payment.process', $orderId);
        } catch (\Exception $e) {
            $this->showNotification('Erreur lors du traitement du paiement', 'error');
        }
    }

    public function leaveReview($orderId)
    {
        // Redirection vers la page d'avis ou ouverture d'une modal
        $this->emit('openReviewModal', $orderId);
        $this->showNotification('Formulaire d\'avis ouvert', 'info');
    }

    public function handleOrderCanceled($orderId)
    {
        // Gestionnaire pour l'événement d'annulation d'ordre
        $this->showNotification('Statut de commande mis à jour', 'success');
    }

    public function handlePaymentCompleted($orderId)
    {
        // Gestionnaire pour l'événement de paiement complété
        $this->showNotification('Paiement effectué avec succès', 'success');
    }

    private function showNotification($message, $type = 'success', $duration = 5000)
    {
        $this->notification = $message;
        $this->notificationType = $type;

        // Émettre vers le frontend
        $this->dispatch('showNotification', $message, $type, $duration);
    }

    public function clearNotification()
    {
        $this->notification = null;
    }

    public function getOrdersProperty()
    {
        $query = Order::where('user_id', Auth::id())
            ->with(['orderItems.product'])
            ->orderBy('created_at', 'desc');

        // Filtre de recherche
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('order_number', 'like', '%' . $this->search . '%')
                    ->orWhere('customer_name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('orderItems.product', function ($productQuery) {
                        $productQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            });
        }

        // Filtre de statut
        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        // Filtre de période
        if ($this->periodFilter) {
            $days = (int) $this->periodFilter;
            $query->where('created_at', '>=', Carbon::now()->subDays($days));
        }

        return $query->paginate(10);
    }

    public function getStatusConfigProperty()
    {
        return [
            'pending' => [
                'class' => 'warning',
                'icon' => 'clock',
                'text' => 'En attente',
            ],
            'confirmed' => [
                'class' => 'info',
                'icon' => 'check-circle',
                'text' => 'Confirmée',
            ],
            'processing' => [
                'class' => 'primary',
                'icon' => 'gear',
                'text' => 'En traitement',
            ],
            'shipped' => [
                'class' => 'success',
                'icon' => 'truck',
                'text' => 'Expédiée',
            ],
            'delivered' => [
                'class' => 'success',
                'icon' => 'check-circle-fill',
                'text' => 'Livrée',
            ],
            'cancelled' => [
                'class' => 'danger',
                'icon' => 'x-circle',
                'text' => 'Annulée',
            ],
            'refunded' => [
                'class' => 'secondary',
                'icon' => 'arrow-counterclockwise',
                'text' => 'Remboursée',
            ],
        ];
    }

    public function getPaymentStatusConfigProperty()
    {
        return [
            'pending' => ['class' => 'warning', 'text' => 'En attente'],
            'paid' => ['class' => 'success', 'text' => 'Payé'],
            'failed' => ['class' => 'danger', 'text' => 'Échec'],
            'refunded' => ['class' => 'info', 'text' => 'Remboursé'],
            'partial' => ['class' => 'warning', 'text' => 'Partiel'],
        ];
    }

    public function getPaymentMethodsProperty()
    {
        return [
            'cash_on_delivery' => 'Paiement à la livraison',
            'mobile_money' => 'Mobile Money',
            'bank_transfer' => 'Virement bancaire',
            'card' => 'Carte bancaire',
            'wallet' => 'Portefeuille électronique',
        ];
    }

    public function getShippingMethodsProperty()
    {
        return [
            'standard' => 'Livraison standard',
            'express' => 'Livraison express',
            'pickup' => 'Retrait en magasin',
        ];
    }

    public function render()
    {
        return view('livewire.my-orders', [
            'orders' => $this->orders,
        ]);
    }
}
