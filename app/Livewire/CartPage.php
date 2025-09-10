<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CartPage extends Component
{
    public $cartItems = [];
    public $total = 0;

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cartItems = Cart::getCartItems();
        $this->total = Cart::getCartTotal();
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        try {
            Cart::updateQuantity($cartItemId, $quantity);
            $this->refreshCart();

            // Émettre un événement pour mettre à jour l'indicateur du panier
            $this->dispatch('cartUpdated');

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Quantité mise à jour !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de la mise à jour.'
            ]);
        }
    }

    public function removeItem($cartItemId)
    {
        try {
            Cart::removeFromCart($cartItemId);
            $this->refreshCart();

            // Émettre un événement pour mettre à jour l'indicateur du panier
            $this->dispatch('cartUpdated');

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Article supprimé du panier !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors de la suppression.'
            ]);
        }
    }

    public function clearCart()
    {
        try {
            Cart::clearCart();
            $this->refreshCart();

            // Émettre un événement pour mettre à jour l'indicateur du panier
            $this->dispatch('cartUpdated');

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Panier vidé !'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors du vidage du panier.'
            ]);
        }
    }

    public function getItemTotal($price, $quantity)
    {
        return $price * $quantity;
    }

    public function placeOrder()
    {
        try {
            // Vérifier l'authentification
            if (!Auth::check()) {
                $this->dispatch('showToast', [
                    'type' => 'warning',
                    'message' => 'Vous devez être connecté pour passer commande.'
                ]);
                return $this->redirectRoute('login');
            }

            // Vérifier que le panier n'est pas vide
            if (count($this->cartItems) == 0) {
                $this->dispatch('showToast', [
                    'type' => 'warning',
                    'message' => 'Votre panier est vide.'
                ]);
                return;
            }

            $user = Auth::user();

            // Utiliser une transaction pour garantir la cohérence
            DB::beginTransaction();

            try {
                // Calculer les totaux
                $subtotal = $this->cartItems->sum(fn($i) => $i->price * $i->quantity);
                $shippingCost = $subtotal >= 50 ? 0 : 4.99;
                $totalAmount = $subtotal + $shippingCost;

                // Création de la commande
                $order = Order::create([
                    'user_id'          => $user->id,
                    'customer_name'    => $user->name,
                    'customer_email'   => $user->email,
                    'customer_phone'   => $user->phone ?? null,
                    'shipping_address' => $user->address ?? 'Adresse à compléter',
                    'shipping_city'    => $user->city ?? 'Ville à compléter',
                    'shipping_country' => 'Guinée',
                    'subtotal'         => $subtotal,
                    'tax_amount'       => 0,
                    'shipping_cost'    => $shippingCost,
                    'discount_amount'  => 0,
                    'total_amount'     => $totalAmount,
                    'status'           => 'pending',
                    'payment_status'   => 'pending',
                    'shipping_method'  => 'standard',
                    'order_number'     => 'CMD-' . now()->format('Ymd') . '-' . str_pad($user->id, 4, '0', STR_PAD_LEFT) . '-' . rand(1000, 9999),
                ]);

                // Sauvegarde des items du panier dans order_items
                foreach ($this->cartItems as $item) {
                    OrderItem::create([
                        'order_id'        => $order->id,
                        'product_id'      => $item->product_id,
                        'product_name'    => $item->product->name ?? '',
                        'product_sku'     => $item->product->sku ?? null,
                        'unit_price'      => $item->price,
                        'quantity'        => $item->quantity,
                        'total_price'     => $item->price * $item->quantity,
                        'product_image'   => $item->product->image ?? null,
                        'product_options' => json_encode([]), // Si vous avez des options de produit
                    ]);
                }

                // Vider le panier AVANT la redirection
                Cart::clearCart();

                // Valider la transaction
                DB::commit();

                // Rafraîchir l'état du composant
                $this->refreshCart();

                // Émettre l'événement pour mettre à jour l'indicateur du panier
                $this->dispatch('cartUpdated');

                // Dispatch d'un événement personnalisé pour indiquer que la commande a été créée
                $this->dispatch('orderCreated', [
                    'orderId' => $order->id,
                    'orderNumber' => $order->order_number
                ]);

                // Toast de succès
                $this->dispatch('showToast', [
                    'type' => 'success',
                    'message' => 'Commande passée avec succès ! Redirection en cours...'
                ]);

                // Flash pour la prochaine page
                session()->flash('success', 'Votre commande #' . $order->order_number . ' a été enregistrée avec succès !');
                session()->flash('order_id', $order->id);

                // Redirection avec navigation pour Livewire 3
                return $this->redirect(
                    route('orders.show', ['order' => $order->id]),
                    navigate: true
                );
            } catch (\Exception $e) {
                // Annuler la transaction en cas d'erreur
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            // Log l'erreur pour le débogage
            \Log::error('Erreur lors du passage de commande: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'cart_items' => $this->cartItems->toArray(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Une erreur est survenue lors du passage de commande. Veuillez réessayer.'
            ]);
        }
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
