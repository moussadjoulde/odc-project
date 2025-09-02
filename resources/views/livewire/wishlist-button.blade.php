<button 
    wire:click="toggleWishlist" 
    class="{{ $buttonClass }} {{ $size === 'sm' ? 'btn-sm' : ($size === 'lg' ? 'btn-lg' : '') }}"
    title="{{ $isInWishlist ? 'Retirer des favoris' : 'Ajouter aux favoris' }}"
    type="button">
    
    <i class="{{ $iconClass }} {{ $showText ? 'me-1' : '' }}"></i>
    
    @if($showText)
        {{ $isInWishlist ? 'Retirer' : 'Ajouter' }}
    @endif
</button>