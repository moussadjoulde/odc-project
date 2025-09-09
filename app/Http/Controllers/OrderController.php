<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['trackByNumber', 'lookupTracking']);
    }

    /**
     * Afficher la page des commandes (si vous n'utilisez pas directement Livewire)
     */
    public function index()
    {
        $orders = Order::all();
        return view('products.orders.index', compact('orders'));
    }

    /**
     * Afficher les détails d'une commande spécifique
     */
    public function show(Order $order)
    {
        // Gate::authorize('view', $order);

        $order->load(['orderItems.product', 'reviews']);

        return view('products.orders.show', compact('order'));
    }

    /**
     * Annuler une commande
     */
    public function cancel(Order $order)
    {
        // Gate::authorize('cancel', $order);

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Cette commande ne peut plus être annulée.'
            ], 400);
        }

        if ($order->payment_status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Les commandes payées ne peuvent pas être annulées directement. Contactez le support.'
            ], 400);
        }

        try {
            $order->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'cancellation_reason' => 'Annulée par le client'
            ]);

            // // Émettre un événement pour notifier d'autres parties du système
            // event(new \App\Events\OrderCancelled($order));

            return response()->json([
                'success' => true,
                'message' => 'Commande annulée avec succès.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'annulation de la commande.'
            ], 500);
        }
    }

    /**
     * Processus de paiement pour une commande
     */
    public function processPayment(Order $order)
    {
        // Gate::authorize('pay', $order);

        if ($order->payment_status === 'paid') {
            return redirect()->route('orders.show', $order)
                ->with('info', 'Cette commande est déjà payée.');
        }

        if (!in_array($order->status, ['pending', 'confirmed'])) {
            return redirect()->route('orders.show', $order)
                ->with('error', 'Cette commande ne peut plus être payée.');
        }

        // Rediriger vers votre système de paiement
        return view('orders.payment', compact('order'));
    }

    /**
     * Soumettre un avis pour une commande
     */
    public function storeReview(Request $request, Order $order)
    {
        // Gate::authorize('review', $order);

        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
            'recommend' => 'boolean'
        ]);

        // Vérifier si l'utilisateur n'a pas déjà laissé un avis
        $existingReview = Review::where('order_id', $order->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Vous avez déjà laissé un avis pour cette commande.'
            ], 400);
        }

        try {
            $review = Review::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
                'recommend' => $request->boolean('recommend', false),
                'verified_purchase' => true // Puisque c'est lié à une commande
            ]);

            // Mettre à jour les statistiques des produits si nécessaire
            $this->updateProductRatings($order);

            return response()->json([
                'success' => true,
                'message' => 'Avis soumis avec succès.',
                'review' => $review
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la soumission de l\'avis.'
            ], 500);
        }
    }

    /**
     * Suivre une commande par numéro de suivi
     */
    public function trackByNumber($trackingNumber)
    {
        $order = Order::where('tracking_number', $trackingNumber)->first();

        if (!$order) {
            return view('orders.tracking', [
                'error' => 'Numéro de suivi introuvable.'
            ]);
        }

        // Récupérer les informations de suivi depuis l'API du transporteur
        $trackingInfo = $this->getTrackingInfo($trackingNumber);

        return view('orders.tracking', [
            'order' => $order,
            'trackingInfo' => $trackingInfo
        ]);
    }

    /**
     * Recherche de suivi par formulaire
     */
    public function lookupTracking(Request $request)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:100',
            'email' => 'nullable|email'
        ]);

        $query = Order::where('tracking_number', $request->tracking_number);

        if ($request->email) {
            $query->where('customer_email', $request->email);
        }

        $order = $query->first();

        if (!$order) {
            throw ValidationException::withMessages([
                'tracking_number' => 'Numéro de suivi introuvable ou email incorrect.'
            ]);
        }

        return redirect()->route('orders.track', $order->tracking_number);
    }

    /**
     * API: Liste des commandes pour l'utilisateur authentifié
     */
    public function apiIndex(Request $request)
    {
        $orders = Order::where('user_id', Auth::id())
            ->with(['orderItems.product'])
            ->latest()
            ->paginate($request->get('per_page', 15));

        return response()->json($orders);
    }

    /**
     * API: Détails d'une commande
     */
    public function apiShow(Order $order)
    {
        // Gate::authorize('view', $order);

        $order->load(['orderItems.product', 'reviews']);

        return response()->json($order);
    }

    /**
     * API: Annuler une commande
     */
    public function apiCancel(Order $order)
    {
        return $this->cancel($order);
    }

    /**
     * API: Soumettre un avis
     */
    public function apiStoreReview(Request $request, Order $order)
    {
        return $this->storeReview($request, $order);
    }

    /**
     * Récupérer les informations de suivi depuis l'API du transporteur
     */
    private function getTrackingInfo($trackingNumber)
    {
        // Exemple d'intégration avec une API de transporteur
        // À adapter selon votre transporteur
        try {
            // Simulation d'appel API
            return [
                'status' => 'in_transit',
                'estimated_delivery' => now()->addDays(2),
                'events' => [
                    [
                        'date' => now()->subDays(1),
                        'status' => 'picked_up',
                        'description' => 'Colis pris en charge',
                        'location' => 'Centre de tri principal'
                    ],
                    [
                        'date' => now()->subHours(6),
                        'status' => 'in_transit',
                        'description' => 'En cours de transport',
                        'location' => 'En route vers destination'
                    ]
                ]
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'unknown',
                'error' => 'Impossible de récupérer les informations de suivi'
            ];
        }
    }

    /**
     * Mettre à jour les notes moyennes des produits après un avis
     */
    private function updateProductRatings($order)
    {
        foreach ($order->orderItems as $item) {
            $product = $item->product;

            $avgRating = Review::whereHas('order.orderItems', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->avg('rating');

            $reviewCount = Review::whereHas('order.orderItems', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })->count();

            $product->update([
                'average_rating' => round($avgRating, 2),
                'review_count' => $reviewCount
            ]);
        }
    }
}
