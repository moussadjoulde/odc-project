@extends('layouts.product')

@section('title', 'Créer une Catégorie')

@section('content')
    <style>
        /* Styles personnalisés pour la création de catégorie */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .form-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .form-header h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .form-header p {
            font-size: 1.1rem;
            opacity: 0.9;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .form-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }

        .form-body {
            padding: 2.5rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
        }

        .form-floating > .form-control {
            height: 60px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .form-floating > .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .form-floating > label {
            color: #718096;
            font-weight: 600;
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            color: #667eea;
            font-weight: 700;
        }

        .form-control.is-invalid {
            border-color: #e53e3e;
            background: #fef5f5;
        }

        .form-control.is-valid {
            border-color: #38a169;
            background: #f0fff4;
        }

        .textarea-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .textarea-floating > textarea {
            min-height: 120px;
            resize: vertical;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #fafafa;
        }

        .textarea-floating > textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            background: white;
            transform: translateY(-2px);
        }

        .textarea-floating > label {
            position: absolute;
            top: 1rem;
            left: 1rem;
            color: #718096;
            font-weight: 600;
            transition: all 0.3s ease;
            background: white;
            padding: 0 0.5rem;
            pointer-events: none;
        }

        .textarea-floating > textarea:focus ~ label,
        .textarea-floating > textarea:not(:placeholder-shown) ~ label {
            top: -0.5rem;
            font-size: 0.875rem;
            color: #667eea;
            font-weight: 700;
        }

        .file-input-wrapper {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .file-input-custom {
            position: relative;
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 2px dashed #e2e8f0;
            border-radius: 12px;
            background: #fafafa;
            transition: all 0.3s ease;
            cursor: pointer;
            min-height: 80px;
        }

        .file-input-custom:hover {
            border-color: #667eea;
            background: #f7fafc;
            transform: translateY(-2px);
        }

        .file-input-custom.dragover {
            border-color: #667eea;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        }

        .file-input-real {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-content {
            text-align: center;
            width: 100%;
        }

        .file-input-icon {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 0.5rem;
        }

        .switch-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.5rem;
            background: #f8fafc;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            border: 2px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .switch-container:hover {
            background: #f1f5f9;
            transform: translateY(-1px);
        }

        .switch-label {
            font-weight: 600;
            color: #2d3748;
            margin: 0;
        }

        .switch-description {
            font-size: 0.875rem;
            color: #718096;
            margin: 0.25rem 0 0 0;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 30px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cbd5e0;
            transition: 0.4s;
            border-radius: 30px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 22px;
            width: 22px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: 0.4s;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        input:checked + .slider {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        input:checked + .slider:before {
            transform: translateX(30px);
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-gradient-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .btn-outline-secondary {
            border: 2px solid #e2e8f0;
            color: #718096;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e0;
            color: #4a5568;
            transform: translateY(-2px);
        }

        .button-group {
            display: flex;
            gap: 1rem;
            padding-top: 1rem;
            border-top: 1px solid #e2e8f0;
        }

        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-danger {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            color: white;
        }

        .preview-image {
            max-width: 150px;
            max-height: 150px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 1rem;
        }

        .breadcrumb-modern {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-modern .breadcrumb-item {
            font-weight: 600;
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: #667eea;
        }

        .breadcrumb-modern a {
            color: #718096;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-modern a:hover {
            color: #667eea;
        }

        @media (max-width: 768px) {
            .form-header h1 {
                font-size: 2rem;
            }

            .form-body {
                padding: 1.5rem;
            }

            .button-group {
                flex-direction: column;
            }

            .button-group .btn {
                width: 100%;
            }
        }

        /* Animation de chargement */
        .form-card {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slug-preview {
            background: #f1f5f9;
            border: 1px solid #cbd5e0;
            border-radius: 8px;
            padding: 0.75rem 1rem;
            margin-top: 0.5rem;
            font-family: 'Monaco', 'Menlo', monospace;
            font-size: 0.875rem;
            color: #4a5568;
        }

        .slug-preview strong {
            color: #667eea;
        }
    </style>

    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-modern">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}">
                        <i class="bi bi-grid-3x3-gap me-1"></i>
                        Catégories
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="bi bi-plus-circle me-1"></i>
                    Nouvelle Catégorie
                </li>
            </ol>
        </nav>

        <!-- Messages d'erreur -->
        @if ($errors->any())
            <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>Erreurs détectées !</strong>
                    </div>
                </div>
                <ul class="mb-0 ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="form-card">
                    <!-- Header du formulaire -->
                    <div class="form-header">
                        <div class="form-icon">
                            <i class="bi bi-folder-plus"></i>
                        </div>
                        <h1>Nouvelle Catégorie</h1>
                        <p>Créez une nouvelle catégorie pour organiser vos produits</p>
                    </div>

                    <!-- Corps du formulaire -->
                    <div class="form-body">
                        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data" id="categoryForm">
                            @csrf
                            
                            <!-- Nom de la catégorie -->
                            <div class="form-floating">
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       placeholder="Nom de la catégorie"
                                       value="{{ old('name') }}"
                                       required>
                                <label for="name">
                                    <i class="bi bi-tag me-2"></i>
                                    Nom de la catégorie
                                </label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Aperçu du slug -->
                            <div class="slug-preview" id="slugPreview" style="display: none;">
                                <i class="bi bi-link-45deg me-2"></i>
                                URL: <strong id="slugText"></strong>
                            </div>

                            <!-- Champ slug caché -->
                            <input type="hidden" name="slug" id="slug" value="{{ old('slug') }}">

                            <!-- Description -->
                            <div class="textarea-floating">
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          placeholder="Description de la catégorie"
                                          rows="4">{{ old('description') }}</textarea>
                                <label for="description">
                                    <i class="bi bi-card-text me-2"></i>
                                    Description (optionnelle)
                                </label>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Upload d'image -->
                            <div class="file-input-wrapper">
                                <label class="form-label fw-bold text-muted mb-2">
                                    <i class="bi bi-image me-2"></i>
                                    Image de la catégorie (optionnelle)
                                </label>
                                <div class="file-input-custom" id="fileInputCustom">
                                    <input type="file" 
                                           class="file-input-real @error('image') is-invalid @enderror" 
                                           id="image" 
                                           name="image" 
                                           accept="image/*">
                                    <div class="file-input-content">
                                        <div class="file-input-icon">
                                            <i class="bi bi-cloud-upload"></i>
                                        </div>
                                        <div>
                                            <strong>Cliquez pour sélectionner</strong> ou glissez une image ici
                                        </div>
                                        <small class="text-muted">PNG, JPG, JPEG (Max: 2MB)</small>
                                    </div>
                                </div>
                                <div id="imagePreview"></div>
                                @error('image')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ordre -->
                            <div class="form-floating">
                                <input type="number" 
                                       class="form-control @error('order') is-invalid @enderror" 
                                       id="order" 
                                       name="order" 
                                       placeholder="Ordre d'affichage"
                                       value="{{ old('order', 0) }}"
                                       min="0"
                                       required>
                                <label for="order">
                                    <i class="bi bi-arrow-up-down me-2"></i>
                                    Ordre d'affichage
                                </label>
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Statut actif -->
                            <div class="switch-container">
                                <div>
                                    <label class="switch-label">
                                        <i class="bi bi-eye me-2"></i>
                                        Catégorie active
                                    </label>
                                    <p class="switch-description">
                                        Cette catégorie sera visible sur votre site
                                    </p>
                                </div>
                                <label class="switch">
                                    <!-- Champ caché pour envoyer 0 si la case est décochée -->
                                    <input type="hidden" name="is_active" value="0">

                                    <input type="checkbox" 
                                           name="is_active" 
                                           id="is_active" 
                                           {{ old('is_active', true) ? 'checked' : '' }}>
                                    <span class="slider"></span>
                                </label>
                            </div>

                            <!-- Boutons d'action -->
                            <div class="button-group">
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary flex-fill">
                                    <i class="bi bi-arrow-left me-2"></i>
                                    Retour
                                </a>
                                <button type="submit" class="btn btn-gradient-primary flex-fill">
                                    <i class="bi bi-check-circle me-2"></i>
                                    Créer la Catégorie
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Génération automatique du slug
            const nameInput = document.getElementById('name');
            const slugInput = document.getElementById('slug');
            const slugPreview = document.getElementById('slugPreview');
            const slugText = document.getElementById('slugText');

            function generateSlug(text) {
                return text
                    .toLowerCase()
                    .trim()
                    .replace(/[àáâãäå]/g, 'a')
                    .replace(/[èéêë]/g, 'e')
                    .replace(/[ìíîï]/g, 'i')
                    .replace(/[òóôõö]/g, 'o')
                    .replace(/[ùúûü]/g, 'u')
                    .replace(/[ç]/g, 'c')
                    .replace(/[ñ]/g, 'n')
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-|-$/g, '');
            }

            nameInput.addEventListener('input', function() {
                const name = this.value;
                if (name.trim()) {
                    const slug = generateSlug(name);
                    slugInput.value = slug;
                    slugText.textContent = slug || 'slug-auto-genere';
                    slugPreview.style.display = 'block';
                    
                    // Animation
                    slugPreview.style.opacity = '0';
                    setTimeout(() => {
                        slugPreview.style.transition = 'opacity 0.3s ease';
                        slugPreview.style.opacity = '1';
                    }, 100);
                } else {
                    slugPreview.style.display = 'none';
                }
            });

            // Gestion de l'upload d'image avec drag & drop
            const fileInput = document.getElementById('image');
            const fileInputCustom = document.getElementById('fileInputCustom');
            const imagePreview = document.getElementById('imagePreview');

            // Événements de drag & drop
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                fileInputCustom.addEventListener(eventName, preventDefaults, false);
            });

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            ['dragenter', 'dragover'].forEach(eventName => {
                fileInputCustom.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                fileInputCustom.addEventListener(eventName, unhighlight, false);
            });

            function highlight(e) {
                fileInputCustom.classList.add('dragover');
            }

            function unhighlight(e) {
                fileInputCustom.classList.remove('dragover');
            }

            fileInputCustom.addEventListener('drop', handleDrop, false);

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    fileInput.files = files;
                    previewImage(files[0]);
                }
            }

            // Prévisualisation de l'image
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    previewImage(this.files[0]);
                }
            });

            function previewImage(file) {
                if (!file.type.startsWith('image/')) {
                    showError('Veuillez sélectionner un fichier image valide.');
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    showError('La taille du fichier ne doit pas dépasser 2MB.');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <div class="text-center mt-3">
                            <img src="${e.target.result}" class="preview-image" alt="Aperçu">
                            <div class="mt-2">
                                <small class="text-success">
                                    <i class="bi bi-check-circle me-1"></i>
                                    Image sélectionnée: ${file.name}
                                </small>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger mt-2" onclick="removeImage()">
                                <i class="bi bi-trash me-1"></i>Supprimer
                            </button>
                        </div>
                    `;
                    
                    // Update file input display
                    fileInputCustom.querySelector('.file-input-content').innerHTML = `
                        <div class="file-input-icon text-success">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div>
                            <strong class="text-success">Image sélectionnée</strong>
                            <div>${file.name}</div>
                        </div>
                        <small class="text-muted">Cliquez pour changer</small>
                    `;
                };
                reader.readAsDataURL(file);
            }

            window.removeImage = function() {
                fileInput.value = '';
                imagePreview.innerHTML = '';
                fileInputCustom.querySelector('.file-input-content').innerHTML = `
                    <div class="file-input-icon">
                        <i class="bi bi-cloud-upload"></i>
                    </div>
                    <div>
                        <strong>Cliquez pour sélectionner</strong> ou glissez une image ici
                    </div>
                    <small class="text-muted">PNG, JPG, JPEG (Max: 2MB)</small>
                `;
            };

            function showError(message) {
                // Vous pouvez implémenter un système de notifications ici
                alert(message);
            }

            // Animation des champs lors du focus
            const formControls = document.querySelectorAll('.form-control, textarea');
            formControls.forEach(control => {
                control.addEventListener('focus', function() {
                    this.parentElement.style.transform = 'translateY(-2px)';
                });

                control.addEventListener('blur', function() {
                    this.parentElement.style.transform = 'translateY(0)';
                });
            });

            // Validation en temps réel
            const form = document.getElementById('categoryForm');
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Vérification du nom
                if (!nameInput.value.trim()) {
                    nameInput.classList.add('is-invalid');
                    isValid = false;
                } else {
                    nameInput.classList.remove('is-invalid');
                    nameInput.classList.add('is-valid');
                }

                // Vérification de l'ordre
                const orderInput = document.getElementById('order');
                if (!orderInput.value || orderInput.value < 0) {
                    orderInput.classList.add('is-invalid');
                    isValid = false;
                } else {
                    orderInput.classList.remove('is-invalid');
                    orderInput.classList.add('is-valid');
                }

                if (!isValid) {
                    e.preventDefault();
                    // Scroll vers le premier champ invalide
                    const firstInvalid = document.querySelector('.form-control.is-invalid');
                    if (firstInvalid) {
                        firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        firstInvalid.focus();
                    }
                }
            });
        });
    </script>
@endsection