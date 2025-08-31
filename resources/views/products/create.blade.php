@extends('layouts.product')

@section('title', 'Créer un Produit')

@section('content')
    <div class="product-create-container">
        <div class="create-header">
            <div class="header-content">
                <div class="header-icon">
                    <i class="bi bi-plus-circle"></i>
                </div>
                <div class="header-text">
                    <h1>Créer un Nouveau Produit</h1>
                    <p>Ajoutez un nouveau produit à votre catalogue</p>
                </div>
            </div>
        </div>

        <div class="form-container">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" id="productForm" class="modern-form">
                @csrf
                
                <div class="form-grid">
                    <!-- Section principale -->
                    <div class="form-main">
                        <!-- Informations de base -->
                        <div class="form-section">
                            <div class="section-header">
                                <h2>
                                    <i class="bi bi-info-circle"></i>
                                    Informations de base
                                </h2>
                            </div>
                            <div class="section-content">
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="name" class="form-label">
                                            Nom du produit <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="text" 
                                                   name="name" 
                                                   id="name" 
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   value="{{ old('name') }}"
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
                                                   value="{{ old('brand') }}"
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
                                                  placeholder="Description courte du produit (max 500 caractères)">{{ old('short_description') }}</textarea>
                                        <div class="char-count">Caractères restants: <span id="shortDescCount">500</span></div>
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
                                                  placeholder="Description complète du produit">{{ old('description') }}</textarea>
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
                                <h2>
                                    <i class="bi bi-currency-euro"></i>
                                    Prix et Stock
                                </h2>
                            </div>
                            <div class="section-content">
                                <div class="form-row three-cols">
                                    <div class="form-group">
                                        <label for="price" class="form-label">
                                            Prix actuel <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <div class="input-with-addon">
                                                <input type="number" 
                                                       name="price" 
                                                       id="price" 
                                                       class="form-control @error('price') is-invalid @enderror"
                                                       value="{{ old('price') }}"
                                                       step="0.01"
                                                       min="0"
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
                                                       value="{{ old('old_price') }}"
                                                       step="0.01"
                                                       min="0"
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
                                                       value="{{ old('discount_percentage') }}"
                                                       min="0"
                                                       max="100"
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
                                        <label for="stock_quantity" class="form-label">
                                            Quantité en stock <span class="required">*</span>
                                        </label>
                                        <div class="input-wrapper">
                                            <input type="number" 
                                                   name="stock_quantity" 
                                                   id="stock_quantity" 
                                                   class="form-control @error('stock_quantity') is-invalid @enderror"
                                                   value="{{ old('stock_quantity', 0) }}"
                                                   min="0"
                                                   placeholder="0"
                                                   required>
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
                                <h2>
                                    <i class="bi bi-box"></i>
                                    Caractéristiques physiques
                                </h2>
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
                                                       value="{{ old('weight') }}"
                                                       step="0.01"
                                                       min="0"
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
                                                   value="{{ old('dimensions') }}"
                                                   placeholder="L x l x H (en cm)">
                                            <div class="input-help">Format: Longueur x Largeur x Hauteur</div>
                                            @error('dimensions')
                                                <div class="error-message">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SEO et Métadonnées -->
                        <div class="form-section">
                            <div class="section-header">
                                <h2>
                                    <i class="bi bi-search"></i>
                                    SEO et Métadonnées
                                </h2>
                            </div>
                            <div class="section-content">
                                <div class="form-group full-width">
                                    <label for="meta_title" class="form-label">Titre META</label>
                                    <div class="input-wrapper">
                                        <input type="text" 
                                               name="meta_title" 
                                               id="meta_title" 
                                               class="form-control @error('meta_title') is-invalid @enderror"
                                               value="{{ old('meta_title') }}"
                                               maxlength="255"
                                               placeholder="Titre pour les moteurs de recherche">
                                        <div class="input-help">Recommandé: 50-60 caractères</div>
                                        @error('meta_title')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="form-group full-width">
                                    <label for="meta_description" class="form-label">Description META</label>
                                    <div class="input-wrapper">
                                        <textarea name="meta_description" 
                                                  id="meta_description" 
                                                  class="form-control @error('meta_description') is-invalid @enderror"
                                                  rows="3"
                                                  placeholder="Description pour les moteurs de recherche">{{ old('meta_description') }}</textarea>
                                        <div class="input-help">Recommandé: 150-160 caractères</div>
                                        @error('meta_description')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Sidebar droite -->
                    <div class="form-sidebar">
                        <!-- Image du produit -->
                        <div class="form-section">
                            <div class="section-header">
                                <h2>
                                    <i class="bi bi-image"></i>
                                    Image du produit
                                </h2>
                            </div>
                            <div class="section-content">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image</label>
                                    <div class="input-wrapper">
                                        <div class="file-upload-area" id="fileUploadArea">
                                            <div class="upload-placeholder" id="uploadPlaceholder">
                                                <i class="bi bi-cloud-upload"></i>
                                                <p>Cliquez pour sélectionner une image</p>
                                                <small>JPG, PNG, WebP (max: 2MB)</small>
                                            </div>
                                            <div class="image-preview" id="imagePreview" style="display: none;">
                                                <img id="previewImg" src="" alt="Aperçu">
                                                <button type="button" class="remove-image" id="removeImage">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <input type="file" 
                                               name="image" 
                                               id="image" 
                                               class="file-input @error('image') is-invalid @enderror"
                                               accept="image/*">
                                        @error('image')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Statuts et options -->
                        <div class="form-section">
                            <div class="section-header">
                                <h2>
                                    <i class="bi bi-gear"></i>
                                    Statuts et Options
                                </h2>
                            </div>
                            <div class="section-content">
                                <div class="toggle-group">
                                    <div class="toggle-item">
                                        <input type="hidden" name="in_stock" value="0">
                                        <input type="checkbox" 
                                               name="in_stock" 
                                               id="in_stock" 
                                               class="toggle-input"
                                               value="1"
                                               {{ old('in_stock', 1) ? 'checked' : '' }}>
                                        <label class="toggle-label" for="in_stock">
                                            <span class="toggle-switch"></span>
                                            <span class="toggle-text">En stock</span>
                                        </label>
                                    </div>
                                    
                                    <div class="toggle-item">
                                        <input type="hidden" name="is_featured" value="0">
                                        <input type="checkbox" 
                                               name="is_featured" 
                                               id="is_featured" 
                                               class="toggle-input"
                                               value="1"
                                               {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="toggle-label" for="is_featured">
                                            <span class="toggle-switch"></span>
                                            <span class="toggle-text">Produit mis en avant</span>
                                        </label>
                                    </div>
                                    
                                    <div class="toggle-item">
                                        <input type="hidden" name="is_active" value="0">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               id="is_active" 
                                               class="toggle-input"
                                               value="1"
                                               {{ old('is_active', 1) ? 'checked' : '' }}>
                                        <label class="toggle-label" for="is_active">
                                            <span class="toggle-switch"></span>
                                            <span class="toggle-text">Produit actif</span>
                                        </label>
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
                            <i class="bi bi-arrow-left"></i>
                            Retour
                        </a>
                    </div>
                    <div class="actions-right">
                        <button type="button" class="btn btn-outline" id="draftBtn">
                            <i class="bi bi-file-earmark"></i>
                            Sauvegarder en brouillon
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg"></i>
                            Créer le produit
                        </button>
                    </div>
                </div>
            </form>
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
                    .normalize("NFD")
                    .replace(/[\u0300-\u036f]/g, "")
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
                shortDescCount.className = remaining < 50 ? 'text-danger' : '';
            });
            
            // Gestion de l'upload d'image
            const imageInput = document.getElementById('image');
            const fileUploadArea = document.getElementById('fileUploadArea');
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');
            const imagePreview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');
            const removeImage = document.getElementById('removeImage');
            
            fileUploadArea.addEventListener('click', () => imageInput.click());
            
            fileUploadArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                fileUploadArea.classList.add('drag-over');
            });
            
            fileUploadArea.addEventListener('dragleave', () => {
                fileUploadArea.classList.remove('drag-over');
            });
            
            fileUploadArea.addEventListener('drop', (e) => {
                e.preventDefault();
                fileUploadArea.classList.remove('drag-over');
                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    imageInput.files = files;
                    handleImageUpload(files[0]);
                }
            });
            
            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    handleImageUpload(this.files[0]);
                }
            });
            
            removeImage.addEventListener('click', (e) => {
                e.stopPropagation();
                imageInput.value = '';
                uploadPlaceholder.style.display = 'flex';
                imagePreview.style.display = 'none';
            });
            
            function handleImageUpload(file) {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImg.src = e.target.result;
                        uploadPlaceholder.style.display = 'none';
                        imagePreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            }
            
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
                } else {
                    discountInput.value = '';
                }
            }
            
            priceInput.addEventListener('input', calculateDiscount);
            oldPriceInput.addEventListener('input', calculateDiscount);
            
            // Validation en temps réel
            const form = document.getElementById('productForm');
            const requiredFields = ['name', 'price', 'sku', 'slug', 'stock_quantity'];
            
            requiredFields.forEach(field => {
                const input = document.getElementById(field);
                input.addEventListener('blur', function() {
                    validateField(this);
                });
            });
            
            function validateField(input) {
                if (input.hasAttribute('required') && !input.value.trim()) {
                    input.classList.add('is-invalid');
                    return false;
                } else {
                    input.classList.remove('is-invalid');
                    return true;
                }
            }
            
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                requiredFields.forEach(field => {
                    const input = document.getElementById(field);
                    if (!validateField(input)) {
                        isValid = false;
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    const firstInvalid = form.querySelector('.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
                }
            });
        });
    </script>
@endsection