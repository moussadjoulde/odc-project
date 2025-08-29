@extends('layouts.app')
@section('content')
    <p>Favoris</p>
    @forelse ($wishlists as $wishlist)
        <p>{{ $wishlist->product->name }}</p>
        
    @empty
        <p>Aucun produit dans votre liste de souhaits.</p>
    @endforelse
@endsection