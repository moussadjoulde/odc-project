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
            // dd('Méthode exécutée');

            if (!Auth::check()) {
                return redirect()->route('login');
            }

            if (count($this->cartItems) == 0) {
                $this->dispatch('showToast', [
                    'type' => 'warning',
                    'message' => 'Votre panier est vide.'
                ]);
                return;
            }

            $user = Auth::user();

            // Vérification des données obligatoires
            // if (empty($user->address) || empty($user->city)) {
            //     $this->dispatch('showToast', [
            //         'type' => 'error',
            //         'message' => 'Veuillez compléter votre adresse et ville dans votre profil.'
            //     ]);
            //     return;
            // }

            // Création de la commande
            $order = Order::create([
                'user_id'          => $user->id,
                'customer_name'    => $user->name,
                'customer_email'   => $user->email,
                'customer_phone'   => $user->phone ?? null,
                'shipping_address' => $user->address ?? 'Adresse non renseignée',
                'shipping_city'    => $user->city ?? 'Ville',
                'shipping_country' => 'Guinée', // par défaut
                'subtotal'         => $this->cartItems->sum(fn($i) => $i->price * $i->quantity),
                'tax_amount'       => 0,
                'shipping_cost'    => 0,
                'discount_amount'  => 0,
                'total_amount'     => $this->cartItems->sum(fn($i) => $i->price * $i->quantity),
                'status'           => 'pending',
                'payment_status'   => 'pending',
                'shipping_method'  => 'standard',
            ]);

            // Sauvegarde des items du panier dans order_items
            foreach ($this->cartItems as $item) {
                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $item->product_id,
                    'product_name'   => $item->product->name ?? '',   // si tu as la relation
                    'product_sku'    => $item->product->sku ?? null, // si dispo
                    'unit_price'     => $item->price,
                    'quantity'       => $item->quantity,
                    'total_price'    => $item->price * $item->quantity,
                    'product_image'  => $item->product->image ?? null,
                    'product_options' => [], // ou infos du panier si tu en as
                ]);
            }

            // Vider le panier après validation
            Cart::clearCart();
            $this->refreshCart();

            // Toast côté Livewire
            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => 'Commande passée avec succès !'
            ]);

            // Flash Laravel
            session()->flash('success', 'Votre commande a bien été enregistrée !');

            // Redirection Livewire 3
            return $this->redirectRoute('orders.index', ['order' => $order->id], navigate: true);
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
