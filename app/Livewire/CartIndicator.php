<?php

namespace App\Livewire;

use App\Models\Cart;
use Livewire\Component;

class CartIndicator extends Component
{
    public $cartCount = 0;

    protected $listeners = ['cartUpdated' => 'refreshCart'];

    public function mount()
    {
        $this->refreshCart();
    }

    public function refreshCart()
    {
        $this->cartCount = Cart::getCartCount();
    }

    public function render()
    {
        return view('livewire.cart-indicator');
    }
}
