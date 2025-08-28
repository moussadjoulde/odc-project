@extends('layouts.product')
@section('title', 'Modifier le Produit')
@section('content')
    <h1 class="my-4">Modifier le Produit</h1>
    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Nom</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="price">Prix</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}">
            @error('price')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="weight">Poids (en kg)</label>
            <input type="number" name="weight" id="weight" class="form-control" step="0.01" value="{{ old('weight', $product->weight) }}">
            @error('weight')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="dimensions">Dimensions (L x l x H en cm)</label>
            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ old('dimensions', $product->dimensions) }}">
            @error('dimensions')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <label for="brand">Marque</label>
            <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $product->brand) }}">
            @error('brand')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Modifier le Produit</button>
    </form>
@endsection