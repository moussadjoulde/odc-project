@extends('layouts.product')

@section('title', 'Modifier le Produit')

@section('content')
    <div class="product-create-container">
        <div class="create-header">
            <div class="header-content">
                <div class="header-icon">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="header-text">
                    <h1>Modifier le Produit</h1>
                    <p>Modifiez les informations de votre produit</p>
                </div>
            </div>
        </div>

        <div class="form-container">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm" class="modern-form">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <!-- Section principale -->
                    <div class="form-main">
                        <!-- Informations de base -->
                        <div class="form-section">
                            <div class="section-header">
                                <h2><i class="bi bi-info-circle"></i> Informations de base</h2>
                            </div>
                            <div class="section-content">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Nom du produit <span class="required">*</span></label>
                                        <div class="input-wrapper">
                                            <input type="text" 
                                                   name="name" 
                                                   id="name" 
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name', $product->name) }}"
                                                   placeholder="Entrez le nom du produit"
                                                   required>
                                            @error('name')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="brand" class="form-label">Marque</label>
                                        <div class="input-wrapper">
                                            <input type="text" 
                                                   name="brand" 
                                                   id="brand" 
                                                   class="form-control @error('brand') is-invalid @enderror"
                                                   value="{{ old('brand', $product->brand) }}"
                                                   placeholder="Nom de la marque">
                                            @error('brand')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group full-width">
                                    <label for="short_description" class="form-label">Description courte</label>
                                    <div class="input-wrapper">
                                        <textarea name="short_description" 
                                                  id="short_description" 
                                                  class="form-control @error('short_description') is-invalid @enderror"
                                                  rows="3"
                                                  maxlength="500"
                                                  placeholder="Description courte du produit (max 500 caractères)">{{ old('short_description', $product->short_description) }}</textarea>
                                        @error('short_description')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group full-width">
                                    <label for="description" class="form-label">Description détaillée</label>
                                    <div class="input-wrapper">
                                        <textarea name="description" 
                                                  id="description" 
                                                  class="form-control @error('description') is-invalid @enderror"
                                                  rows="5"
                                                  placeholder="Description complète du produit">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Prix et stock -->
                        <div class="form-section">
                            <div class="section-header">
                                <h2><i class="bi bi-currency-euro"></i> Prix et Stock</h2>
                            </div>
                            <div class="section-content">
                                <div class="form-row three-cols">
                                    <div class="form-group">
                                        <label for="price" class="form-label">Prix actuel <span class="required">*</span></label>
                                        <div class="input-wrapper">
                                            <div class="input-with-addon">
                                                <input type="number" 
                                                       name="price" 
                                                       id="price" 
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       value="{{ old('price', $product->price) }}"
                                                       step="0.01" min="0"
                                                       placeholder="0.00"
                                                       required>
                                                <span class="input-addon">€</span>
                                            </div>
                                            @error('price')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="old_price" class="form-label">Ancien prix</label>
                                        <div class="input-wrapper">
                                            <div class="input-with-addon">
                                                <input type="number" 
                                                       name="old_price" 
                                                       id="old_price" 
                                                       class="form-control @error('old_price') is-invalid @enderror"
                                                       value="{{ old('old_price', $product->old_price) }}"
                                                       step="0.01" min="0"
                                                       placeholder="0.00">
                                                <span class="input-addon">€</span>
                                            </div>
                                            @error('old_price')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="discount_percentage" class="form-label">Remise</label>
                                        <div class="input-wrapper">
                                            <div class="input-with-addon">
                                                <input type="number" 
                                                       name="discount_percentage" 
                                                       id="discount_percentage" 
                                                       class="form-control @error('discount_percentage') is-invalid @enderror"
                                                       value="{{ old('discount_percentage', $product->discount_percentage) }}"
                                                       min="0" max="100"
                                                       placeholder="0">
                                                <span class="input-addon">%</span>
                                            </div>
                                            @error('discount_percentage')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="stock_quantity" class="form-label">Quantité en stock <span class="required">*</span></label>
                                        <div class="input-wrapper">
                                            <input type="number" 
                                                   name="stock_quantity" 
                                                   id="stock_quantity" 
                                                   class="form-control @error('stock_quantity') is-invalid @enderror"
                                                   value="{{ old('stock_quantity', $product->stock_quantity) }}"
                                                   min="0" placeholder="0" required>
                                            @error('stock_quantity')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="category_id" class="form-label">Catégorie</label>
                                        <div class="input-wrapper">
                                            <select name="category_id" 
                                                    id="category_id" 
                                                    class="form-select @error('category_id') is-invalid @enderror">
                                                <option value="">Sélectionner une catégorie</option>
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}" 
                                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Caractéristiques physiques -->
                        <div class="form-section">
                            <div class="section-header">
                                <h2><i class="bi bi-box"></i> Caractéristiques physiques</h2>
                            </div>
                            <div class="section-content">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="weight" class="form-label">Poids</label>
                                        <div class="input-wrapper">
                                            <div class="input-with-addon">
                                                <input type="number" 
                                                       name="weight" 
                                                       id="weight" 
                                                       class="form-control @error('weight') is-invalid @enderror"
                                                       value="{{ old('weight', $product->weight) }}"
                                                       step="0.01" min="0"
                                                       placeholder="0.00">
                                                <span class="input-addon">kg</span>
                                            </div>
                                            @error('weight')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="dimensions" class="form-label">Dimensions</label>
                                        <div class="input-wrapper">
                                            <input type="text" 
                                                   name="dimensions" 
                                                   id="dimensions" 
                                                   class="form-control @error('dimensions') is-invalid @enderror"
                                                   value="{{ old('dimensions', $product->dimensions) }}"
                                                   placeholder="L x l x H (en cm)">
                                            @error('dimensions')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEO -->
                        <div class="form-section">
                            <div class="section-header">
                                <h2><i class="bi bi-search"></i> SEO et Métadonnées</h2>
                            </div>
                            <div class="section-content">
                                <div class="form-group full-width">
                                    <label for="meta_title" class="form-label">Titre META</label>
                                    <input type="text" 
                                           name="meta_title" 
                                           id="meta_title" 
                                           class="form-control @error('meta_title') is-invalid @enderror"
                                           value="{{ old('meta_title', $product->meta_title) }}"
                                           maxlength="255"
                                           placeholder="Titre pour les moteurs de recherche">
                                    @error('meta_title')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group full-width">
                                    <label for="meta_description" class="form-label">Description META</label>
                                    <textarea name="meta_description" 
                                              id="meta_description" 
                                              class="form-control @error('meta_description') is-invalid @enderror"
                                              rows="3"
                                              placeholder="Description pour les moteurs de recherche">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar droite -->
                    <div class="form-sidebar">
                        <div class="form-section">
                            <div class="section-header">
                                <h2><i class="bi bi-image"></i> Image du produit</h2>
                            </div>
                            <div class="section-content">
                                <div class="form-group">
                                    @if($product->image)
                                        <div class="mb-3">
                                            <img src="{{ asset('storage/'.$product->image) }}" alt="Image actuelle" width="120">
                                        </div>
                                    @endif
                                    <input type="file" 
                                           name="image" 
                                           id="image" 
                                           accept="image/*">
                                    @error('image')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-section">
                            <div class="section-header">
                                <h2><i class="bi bi-gear"></i> Statuts et Options</h2>
                            </div>
                            <div class="section-content">
                                <div class="toggle-group">
                                    <div class="toggle-item">
                                        <input type="hidden" name="in_stock" value="0">
                                        <input type="checkbox" name="in_stock" id="in_stock" class="toggle-input" value="1" {{ old('in_stock', $product->in_stock) ? 'checked' : '' }}>
                                        <label class="toggle-label" for="in_stock"><span class="toggle-switch"></span> <span class="toggle-text">En stock</span></label>
                                    </div>
                                    <div class="toggle-item">
                                        <input type="hidden" name="is_featured" value="0">
                                        <input type="checkbox" name="is_featured" id="is_featured" class="toggle-input" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                        <label class="toggle-label" for="is_featured"><span class="toggle-switch"></span> <span class="toggle-text">Produit mis en avant</span></label>
                                    </div>
                                    <div class="toggle-item">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" name="is_active" id="is_active" class="toggle-input" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                                        <label class="toggle-label" for="is_active"><span class="toggle-switch"></span> <span class="toggle-text">Produit actif</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="form-actions">
                    <div class="actions-left">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Retour
                        </a>
                    </div>
                    <div class="actions-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i> Mettre à jour le produit
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
