<?php

namespace App\Livewire;

use App\Models\Cart;
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

    public function render()
    {
        return view('livewire.cart-page');
    }
}
