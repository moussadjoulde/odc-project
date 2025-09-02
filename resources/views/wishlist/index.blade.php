@extends('layouts.app')

@section('title', 'Mes Favoris')

@section('content')
    @livewire('wishlist-manager')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Écouter les événements Livewire pour les toasts
    window.addEventListener('showToast', event => {
        const { type, message } = event.detail[0];
        
        // Si vous avez une fonction toast globale
        if (typeof showToast === 'function') {
            showToast(type, message);
        } else {
            // Fallback avec une alerte simple
            alert(message);
        }
    });

    // Écouter les mises à jour du panier
    window.addEventListener('cartUpdated', event => {
        // Mettre à jour l'indicateur du panier dans la navigation
        if (typeof updateCartIndicator === 'function') {
            updateCartIndicator();
        }
        
        // Ou émettre un événement personnalisé
        window.dispatchEvent(new CustomEvent('cart-updated'));
    });

    // Écouter les mises à jour de la wishlist
    window.addEventListener('wishlistUpdated', event => {
        // Mettre à jour l'indicateur de la wishlist dans la navigation
        if (typeof updateWishlistIndicator === 'function') {
            updateWishlistIndicator();
        }
        
        // Ou émettre un événement personnalisé
        window.dispatchEvent(new CustomEvent('wishlist-updated'));
    });
});
</script>
@endpush