@extends('layouts.product')

@section('title', 'Créer un Produit')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h1 class="h4 mb-0">
                            <i class="bi bi-plus-circle me-2"></i>Créer un Nouveau Produit
                        </h1>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                            @csrf
                            
                            <div class="row">
                                <!-- Informations de base -->
                                <div class="col-lg-8">
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Informations de base</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="name" class="form-label">
                                                            Nom du produit <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" 
                                                               name="name" 
                                                               id="name" 
                                                               class="form-control @error('name') is-invalid @enderror"
                                                               value="{{ old('name') }}"
                                                               placeholder="Entrez le nom du produit"
                                                               required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="sku" class="form-label">
                                                            SKU <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" 
                                                               name="sku" 
                                                               id="sku" 
                                                               class="form-control @error('sku') is-invalid @enderror"
                                                               value="{{ old('sku') }}"
                                                               placeholder="Code produit unique"
                                                               required>
                                                        @error('sku')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="slug" class="form-label">
                                                            Slug <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="text" 
                                                               name="slug" 
                                                               id="slug" 
                                                               class="form-control @error('slug') is-invalid @enderror"
                                                               value="{{ old('slug') }}"
                                                               placeholder="url-friendly-name"
                                                               required>
                                                        @error('slug')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="brand" class="form-label">Marque</label>
                                                        <input type="text" 
                                                               name="brand" 
                                                               id="brand" 
                                                               class="form-control @error('brand') is-invalid @enderror"
                                                               value="{{ old('brand') }}"
                                                               placeholder="Nom de la marque">
                                                        @error('brand')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group mb-3">
                                                <label for="short_description" class="form-label">Description courte</label>
                                                <textarea name="short_description" 
                                                          id="short_description" 
                                                          class="form-control @error('short_description') is-invalid @enderror"
                                                          rows="3"
                                                          maxlength="500"
                                                          placeholder="Description courte du produit (max 500 caractères)">{{ old('short_description') }}</textarea>
                                                <small class="text-muted">Caractères restants: <span id="shortDescCount">500</span></small>
                                                @error('short_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group mb-3">
                                                <label for="description" class="form-label">Description détaillée</label>
                                                <textarea name="description" 
                                                          id="description" 
                                                          class="form-control @error('description') is-invalid @enderror"
                                                          rows="5"
                                                          placeholder="Description complète du produit">{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Prix et stock -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Prix et Stock</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group mb-3">
                                                        <label for="price" class="form-label">
                                                            Prix actuel <span class="text-danger">*</span>
                                                        </label>
                                                        <div class="input-group">
                                                            <input type="number" 
                                                                   name="price" 
                                                                   id="price" 
                                                                   class="form-control @error('price') is-invalid @enderror"
                                                                   value="{{ old('price') }}"
                                                                   step="0.01"
                                                                   min="0"
                                                                   placeholder="0.00"
                                                                   required>
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                        @error('price')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group mb-3">
                                                        <label for="old_price" class="form-label">Ancien prix</label>
                                                        <div class="input-group">
                                                            <input type="number" 
                                                                   name="old_price" 
                                                                   id="old_price" 
                                                                   class="form-control @error('old_price') is-invalid @enderror"
                                                                   value="{{ old('old_price') }}"
                                                                   step="0.01"
                                                                   min="0"
                                                                   placeholder="0.00">
                                                            <span class="input-group-text">€</span>
                                                        </div>
                                                        @error('old_price')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-4">
                                                    <div class="form-group mb-3">
                                                        <label for="discount_percentage" class="form-label">Pourcentage de remise</label>
                                                        <div class="input-group">
                                                            <input type="number" 
                                                                   name="discount_percentage" 
                                                                   id="discount_percentage" 
                                                                   class="form-control @error('discount_percentage') is-invalid @enderror"
                                                                   value="{{ old('discount_percentage') }}"
                                                                   min="0"
                                                                   max="100"
                                                                   placeholder="0">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                        @error('discount_percentage')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="stock_quantity" class="form-label">
                                                            Quantité en stock <span class="text-danger">*</span>
                                                        </label>
                                                        <input type="number" 
                                                               name="stock_quantity" 
                                                               id="stock_quantity" 
                                                               class="form-control @error('stock_quantity') is-invalid @enderror"
                                                               value="{{ old('stock_quantity', 0) }}"
                                                               min="0"
                                                               placeholder="0"
                                                               required>
                                                        @error('stock_quantity')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="category_id" class="form-label">Catégorie</label>
                                                        <select name="category_id" 
                                                                id="category_id" 
                                                                class="form-select @error('category_id') is-invalid @enderror">
                                                            <option value="">Sélectionner une catégorie</option>
                                                            @if(isset($categories))
                                                                @foreach($categories as $category)
                                                                    <option value="{{ $category->id }}" 
                                                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                                        {{ $category->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                        @error('category_id')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Caractéristiques physiques -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Caractéristiques physiques</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="weight" class="form-label">Poids</label>
                                                        <div class="input-group">
                                                            <input type="number" 
                                                                   name="weight" 
                                                                   id="weight" 
                                                                   class="form-control @error('weight') is-invalid @enderror"
                                                                   value="{{ old('weight') }}"
                                                                   step="0.01"
                                                                   min="0"
                                                                   placeholder="0.00">
                                                            <span class="input-group-text">kg</span>
                                                        </div>
                                                        @error('weight')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label for="dimensions" class="form-label">Dimensions</label>
                                                        <input type="text" 
                                                               name="dimensions" 
                                                               id="dimensions" 
                                                               class="form-control @error('dimensions') is-invalid @enderror"
                                                               value="{{ old('dimensions') }}"
                                                               placeholder="L x l x H (en cm)">
                                                        <small class="text-muted">Format: Longueur x Largeur x Hauteur en centimètres</small>
                                                        @error('dimensions')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- SEO et Métadonnées -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">SEO et Métadonnées</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="meta_title" class="form-label">Titre META</label>
                                                <input type="text" 
                                                       name="meta_title" 
                                                       id="meta_title" 
                                                       class="form-control @error('meta_title') is-invalid @enderror"
                                                       value="{{ old('meta_title') }}"
                                                       maxlength="255"
                                                       placeholder="Titre pour les moteurs de recherche">
                                                <small class="text-muted">Recommandé: 50-60 caractères</small>
                                                @error('meta_title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group mb-3">
                                                <label for="meta_description" class="form-label">Description META</label>
                                                <textarea name="meta_description" 
                                                          id="meta_description" 
                                                          class="form-control @error('meta_description') is-invalid @enderror"
                                                          rows="3"
                                                          placeholder="Description pour les moteurs de recherche">{{ old('meta_description') }}</textarea>
                                                <small class="text-muted">Recommandé: 150-160 caractères</small>
                                                @error('meta_description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Sidebar droite -->
                                <div class="col-lg-4">
                                    <!-- Image du produit -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Image du produit</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" 
                                                       name="image" 
                                                       id="image" 
                                                       class="form-control @error('image') is-invalid @enderror"
                                                       accept="image/*">
                                                <small class="text-muted">Formats acceptés: JPG, PNG, WebP (max: 2MB)</small>
                                                @error('image')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                            <!-- Prévisualisation d'image -->
                                            <div id="imagePreview" class="mt-3" style="display: none;">
                                                <img id="previewImg" src="" alt="Aperçu" class="img-fluid rounded border">
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Évaluations -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Évaluations</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group mb-3">
                                                        <label for="rating" class="form-label">Note</label>
                                                        <input type="number" 
                                                               name="rating" 
                                                               id="rating" 
                                                               class="form-control @error('rating') is-invalid @enderror"
                                                               value="{{ old('rating', 0) }}"
                                                               step="0.01"
                                                               min="0"
                                                               max="5"
                                                               placeholder="0.00">
                                                        <small class="text-muted">Sur 5 étoiles</small>
                                                        @error('rating')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                
                                                <div class="col-6">
                                                    <div class="form-group mb-3">
                                                        <label for="review_count" class="form-label">Nombre d'avis</label>
                                                        <input type="number" 
                                                               name="review_count" 
                                                               id="review_count" 
                                                               class="form-control @error('review_count') is-invalid @enderror"
                                                               value="{{ old('review_count', 0) }}"
                                                               min="0"
                                                               placeholder="0">
                                                        @error('review_count')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Statuts et options -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="mb-0">Statuts et Options</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check mb-3">
                                                <input type="hidden" name="in_stock" value="0">
                                                <input type="checkbox" 
                                                       name="in_stock" 
                                                       id="in_stock" 
                                                       class="form-check-input"
                                                       value="1"
                                                       {{ old('in_stock', 1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="in_stock">
                                                    En stock
                                                </label>
                                            </div>
                                            
                                            <div class="form-check mb-3">
                                                <input type="hidden" name="is_featured" value="0">
                                                <input type="checkbox" 
                                                       name="is_featured" 
                                                       id="is_featured" 
                                                       class="form-check-input"
                                                       value="1"
                                                       {{ old('is_featured') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_featured">
                                                    Produit mis en avant
                                                </label>
                                            </div>
                                            
                                            <div class="form-check mb-3">
                                                <input type="hidden" name="is_active" value="0">
                                                <input type="checkbox" 
                                                       name="is_active" 
                                                       id="is_active" 
                                                       class="form-check-input"
                                                       value="1"
                                                       {{ old('is_active', 1) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="is_active">
                                                    Produit actif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Boutons d'action -->
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                            <i class="bi bi-arrow-left me-1"></i>Retour
                                        </a>
                                        <div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="bi bi-check-lg me-1"></i>Créer le produit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript pour améliorer l'UX -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Génération automatique du slug depuis le nom
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            
            nameInput.addEventListener('input', function() {
                const slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.value = slug;
            });
            
            // Compteur de caractères pour la description courte
            const shortDescInput = document.getElementById('short_description');
            const shortDescCount = document.getElementById('shortDescCount');
            
            shortDescInput.addEventListener('input', function() {
                const remaining = 500 - this.value.length;
                shortDescCount.textContent = remaining;
                shortDescCount.className = remaining < 50 ? 'text-danger' : 'text-muted';
            });
            
            // Prévisualisation d'image
            const imageInput = document.getElementById('image');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.style.display = 'none';
                }
            });
            
            // Calcul automatique du pourcentage de remise
            const priceInput = document.getElementById('price');
            const oldPriceInput = document.getElementById('old_price');
            const discountInput = document.getElementById('discount_percentage');
            
            function calculateDiscount() {
                const price = parseFloat(priceInput.value) || 0;
                const oldPrice = parseFloat(oldPriceInput.value) || 0;
                
                if (price > 0 && oldPrice > price) {
                    const discount = Math.round(((oldPrice - price) / oldPrice) * 100);
                    discountInput.value = discount;
                } else if (oldPrice <= price) {
                    discountInput.value = 0;
                }
            }
            
            priceInput.addEventListener('input', calculateDiscount);
            oldPriceInput.addEventListener('input', calculateDiscount);
            
            // Validation en temps réel
            const form = document.getElementById('productForm');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Vérification des champs requis
                const requiredFields = ['name', 'price', 'sku', 'slug', 'stock_quantity'];
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Veuillez remplir tous les champs obligatoires.');
                }
            });
        });
    </script>
@endsection