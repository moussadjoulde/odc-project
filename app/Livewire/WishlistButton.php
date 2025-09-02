<?php

namespace App\Livewire;

use App\Services\WishlistService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class WishlistButton extends Component
{
    public $productId;
    public $isInWishlist = false;
    public $buttonClass = 'btn btn-outline-secondary';
    public $iconClass = 'bi bi-heart';
    public $showText = false;
    public $size = 'normal'; // normal, sm, lg

    protected $listeners = ['wishlistUpdated' => 'checkWishlistStatus'];

    public function mount($productId, $buttonClass = null, $showText = false, $size = 'normal')
    {
        $this->productId = $productId;
        $this->showText = $showText;
        $this->size = $size;

        if ($buttonClass) {
            $this->buttonClass = $buttonClass;
        }

        $this->checkWishlistStatus();
    }

    public function checkWishlistStatus()
    {
        if (Auth::check()) {
            $this->isInWishlist = WishlistService::isInWishlist($this->productId);
            $this->updateButtonAppearance();
        }
    }

    private function updateButtonAppearance()
    {
        if ($this->isInWishlist) {
            $this->iconClass = 'bi bi-heart-fill text-danger';
        } else {
            $this->iconClass = 'bi bi-heart';
        }
    }

    public function toggleWishlist()
    {
        if (!Auth::check()) {
            $this->dispatch('showToast', [
                'type' => 'warning',
                'message' => 'Veuillez vous connecter pour ajouter à vos favoris.'
            ]);

            // Optionnel : rediriger vers la page de connexion
            // return redirect()->route('login');
            return;
        }

        $result = WishlistService::toggle($this->productId);

        if ($result['success']) {
            $this->isInWishlist = $result['inWishlist'];
            $this->updateButtonAppearance();

            $this->dispatch('showToast', [
                'type' => 'success',
                'message' => $result['message']
            ]);

            // Émettre un événement pour mettre à jour d'autres composants
            $this->dispatch('wishlistUpdated');
        } else {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => $result['message']
            ]);
        }
    }

    public function render()
    {
        return view('livewire.wishlist-button');
    }
}
