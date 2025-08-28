@extends('layouts.product')

@section('title', 'Détails du Produit')

@section('content')
    <div class="container">
        <h1 class="my-4">{{ $product->name }}</h1>
        <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="img-fluid">
        <p class="lead">{{ $product->description }}</p>
        <p class="text-muted">Prix : {{ number_format($product->price, 2, ',', ' ') }} €</p>
        <p class="text-muted">Poids : {{ $product->weight ? $product->weight . ' kg' : 'N/A' }}</p>
        <p class="text-muted">Dimensions : {{ $product->dimensions ? $product->dimensions : 'N/A' }}</p>
        <p class="text-muted">Marque : {{ $product->brand ? $product->brand : 'N/A' }}</p>
        <a href="{{ route('products.edit', $product) }}" class="btn btn-primary">Modifier</a>
    </div>
@endsection