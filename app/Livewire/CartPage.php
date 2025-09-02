<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
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
            if (count($this->cartItems) == 0) {
                $this->dispatch('showToast', [
                    'type' => 'warning',
                    'message' => 'Votre panier est vide.'
                ]);
                return;
            }

            $user = Auth::user();

            // Création de la commande
            $order = Order::create([
                'order_number'     => strtoupper(Str::random(10)),
                'user_id'          => $user->id,
                'customer_name'    => $user->name,
                'customer_email'   => $user->email,
                'customer_phone'   => $user->phone ?? null,
                'shipping_address' => $user->address ?? 'Adresse non renseignée',
                'shipping_city'    => $user->city ?? 'Ville',
                'status'           => 'pending',
            ]);

            // Sauvegarde des items du panier dans order_items
            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'price'      => $item->price,
                    'quantity'   => $item->quantity,
                ]);
            }

            // Vider le panier après validation
            Cart::clearCart();
            $this->refreshCart();

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Commande passée avec succès !'
            ]);

            // Redirection optionnelle vers une page "merci"
            return redirect()->to('/orders/' . $order->id);
        } catch (\Exception $e) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Erreur lors du passage de commande.'
            ]);
        }
    }


    public function render()
    {
        return view('livewire.cart-page');
    }
}
