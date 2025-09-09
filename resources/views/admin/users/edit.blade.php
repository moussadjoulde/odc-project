@extends('layouts.product')

@section('title', 'Modifier l\'utilisateur')

@section('content')
    <style>
        /* Styles personnalisés pour la page d'édition utilisateur */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .edit-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .edit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
            position: relative;
            overflow: hidden;
        }

        .btn-gradient-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-gradient-primary:hover::before {
            left: 100%;
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .btn-gradient-secondary {
            background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.75rem 2rem;
            transition: all 0.3s ease;
        }

        .btn-gradient-secondary:hover {
            transform: translateY(-2px);
            color: white;
        }

        .page-header {
            position: relative;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            right: -100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 20px;
            z-index: -1;
        }

        .form-floating {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-floating > .form-control,
        .form-floating > .form-select {
            height: calc(3.5rem + 2px);
            padding: 1rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #fafafa;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .form-floating > .form-control:focus,
        .form-floating > .form-select:focus {
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .form-floating > label {
            font-weight: 600;
            color: #4a5568;
            background: transparent;
        }

        .form-control::placeholder {
            color: #a0aec0;
            opacity: 0.8;
        }

        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #68d391 0%, #38a169 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            color: white;
        }

        .profile-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .profile-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.5; transform: scale(1); }
            50% { opacity: 1; transform: scale(1.1); }
        }

        .current-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .current-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        .avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: bold;
            border: 4px solid rgba(255, 255, 255, 0.3);
            color: white;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid rgba(255, 255, 255, 0.3);
            font-weight: 600;
        }

        .file-input-label:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .role-section {
            background: linear-gradient(135deg, #f7fafc 0%, #edf2f7 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 2px solid #e2e8f0;
        }

        .role-checkbox {
            position: relative;
        }

        .role-checkbox input[type="checkbox"] {
            display: none;
        }

        .role-checkbox label {
            display: block;
            padding: 1rem 1.5rem;
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            color: #4a5568;
            position: relative;
            margin-bottom: 1rem;
        }

        .role-checkbox label::before {
            content: '';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 4px;
            background: white;
            transition: all 0.3s ease;
        }

        .role-checkbox input[type="checkbox"]:checked + label {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .role-checkbox input[type="checkbox"]:checked + label::before {
            background: white;
            border-color: white;
        }

        .role-checkbox input[type="checkbox"]:checked + label::after {
            content: '✓';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-weight: bold;
            font-size: 14px;
        }

        .role-description {
            font-size: 0.875rem;
            opacity: 0.8;
            margin-top: 0.5rem;
        }

        .breadcrumb-modern {
            background: none;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-modern .breadcrumb-item {
            font-weight: 500;
        }

        .breadcrumb-modern .breadcrumb-item + .breadcrumb-item::before {
            content: "→";
            color: #667eea;
            font-weight: bold;
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: #667eea;
            font-weight: 600;
        }

        .stats-mini {
            background: white;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
            margin-bottom: 1rem;
        }

        .stats-mini .stat-value {
            font-size: 1.5rem;
            font-weight: 800;
            color: #2d3748;
        }

        .stats-mini .stat-label {
            font-size: 0.875rem;
            color: #718096;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .edit-card {
                margin: 0 1rem;
            }
            
            .profile-section {
                text-align: center;
            }
            
            .current-avatar {
                width: 100px;
                height: 100px;
            }
            
            .avatar-placeholder {
                width: 100px;
                height: 100px;
                font-size: 2rem;
            }
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .section-title i {
            margin-right: 0.5rem;
            color: #667eea;
        }

        .verification-status {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            margin-top: 1rem;
        }

        .verification-status.verified {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .verification-status.unverified {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            color: white;
        }

        .provider-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 0.8rem;
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
            border-radius: 15px;
            font-weight: 600;
            font-size: 0.75rem;
            margin-top: 0.5rem;
        }
    </style>

    <!-- Messages d'alerte -->
    @if (session('success'))
        <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Succès !</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Erreur !</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Erreurs de validation :</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="container-fluid">
        <!-- Fil d'Ariane -->
        <nav aria-label="breadcrumb" class="breadcrumb-modern">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.dashboard') }}" class="text-decoration-none">
                        <i class="bi bi-house-door me-1"></i>Tableau de bord
                    </a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('users.index') }}" class="text-decoration-none">
                        <i class="bi bi-people me-1"></i>Utilisateurs
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="bi bi-pencil me-1"></i>Modifier {{ $user->name }}
                </li>
            </ol>
        </nav>

        <!-- Header de la page -->
        <div class="page-header text-center">
            <div class="row align-items-center">
                <div class="col-md-6 text-md-start">
                    <h1 class="display-5 fw-bold mb-2" style="color: #2d3748;">
                        <i class="bi bi-pencil-square me-3" style="color: #667eea;"></i>
                        Modifier l'utilisateur
                    </h1>
                    <p class="lead mb-0" style="color: #718096;">
                        Gérez les informations et permissions de {{ $user->name }}
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-6">
                            <div class="stats-mini">
                                <div class="stat-value">{{ $user->created_at->diffForHumans() }}</div>
                                <div class="stat-label">
                                    <i class="bi bi-calendar-plus me-1"></i>Membre depuis
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-mini">
                                <div class="stat-value">{{ $user->updated_at->diffForHumans() }}</div>
                                <div class="stat-label">
                                    <i class="bi bi-clock-history me-1"></i>Dernière modif.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Formulaire principal -->
            <div class="col-lg-8">
                <div class="edit-card">
                    <div class="card-body p-4">
                        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" id="userEditForm">
                            @csrf
                            @method('PUT')

                            <!-- Section Informations personnelles -->
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="bi bi-person-circle"></i>
                                    Informations personnelles
                                </h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" 
                                                   class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" 
                                                   name="name" 
                                                   value="{{ old('name', $user->name) }}" 
                                                   placeholder="Nom complet"
                                                   required>
                                            <label for="name">
                                                <i class="bi bi-person me-2"></i>Nom complet
                                            </label>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" 
                                                   class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" 
                                                   name="email" 
                                                   value="{{ old('email', $user->email) }}" 
                                                   placeholder="Adresse email"
                                                   required>
                                            <label for="email">
                                                <i class="bi bi-envelope me-2"></i>Adresse email
                                            </label>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Photo de profil -->
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="bi bi-image"></i>
                                    Photo de profil
                                </h3>

                                <div class="row align-items-center">
                                    <div class="col-md-3 text-center">
                                        @if($user->profile_picture)
                                            <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                                 alt="Photo actuelle" 
                                                 class="current-avatar"
                                                 id="currentAvatar">
                                        @else
                                            <div class="avatar-placeholder">
                                                {{ strtoupper(substr($user->name, 0, 2)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-floating">
                                            <input type="file" 
                                                   class="form-control @error('profile_picture') is-invalid @enderror" 
                                                   id="profile_picture" 
                                                   name="profile_picture" 
                                                   accept="image/*"
                                                   onchange="previewImage(this)">
                                            <label for="profile_picture">
                                                <i class="bi bi-camera me-2"></i>Nouvelle photo de profil
                                            </label>
                                            @error('profile_picture')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <small class="text-muted">
                                            <i class="bi bi-info-circle me-1"></i>
                                            Formats acceptés: JPG, PNG, WebP. Taille max: 2MB
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <!-- Section Mot de passe -->
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="bi bi-shield-lock"></i>
                                    Sécurité du compte
                                </h3>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" 
                                                   name="password" 
                                                   placeholder="Nouveau mot de passe">
                                            <label for="password">
                                                <i class="bi bi-key me-2"></i>Nouveau mot de passe
                                            </label>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="password" 
                                                   class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                   id="password_confirmation" 
                                                   name="password_confirmation" 
                                                   placeholder="Confirmer le mot de passe">
                                            <label for="password_confirmation">
                                                <i class="bi bi-key-fill me-2"></i>Confirmer le mot de passe
                                            </label>
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Laissez vide pour conserver le mot de passe actuel. Minimum 8 caractères requis.
                                </small>
                            </div>

                            <!-- Section Rôles -->
                            @if(auth()->user()->hasRole('admin') && $user->id !== auth()->id())
                            <div class="form-section">
                                <h3 class="section-title">
                                    <i class="bi bi-shield-check"></i>
                                    Gestion des rôles et permissions
                                </h3>

                                <div class="role-section">
                                    <p class="text-muted mb-4">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Sélectionnez les rôles à attribuer à cet utilisateur. Les permissions seront appliquées automatiquement.
                                    </p>

                                    <div class="row">
                                        @forelse($roles as $role)
                                            <div class="col-md-6">
                                                <div class="role-checkbox">
                                                    <input type="checkbox" 
                                                           id="role_{{ $role->id }}" 
                                                           name="roles[]" 
                                                           value="{{ $role->name }}"
                                                           @if($user->hasRole($role->name)) checked @endif>
                                                    <label for="role_{{ $role->id }}">
                                                        <div class="d-flex align-items-center">
                                                            <div>
                                                                <div class="fw-bold">{{ ucfirst($role->name) }}</div>
                                                                @switch($role->name)
                                                                    @case('admin')
                                                                        <div class="role-description">Accès complet au système</div>
                                                                        @break
                                                                    @case('moderator')
                                                                        <div class="role-description">Gestion du contenu et des utilisateurs</div>
                                                                        @break
                                                                    @case('editor')
                                                                        <div class="role-description">Création et modification du contenu</div>
                                                                        @break
                                                                    @case('user')
                                                                        <div class="role-description">Accès utilisateur standard</div>
                                                                        @break
                                                                    @default
                                                                        <div class="role-description">{{ $role->description ?? 'Rôle personnalisé' }}</div>
                                                                @endswitch
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <div class="alert alert-warning">
                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                    Aucun rôle configuré dans le système.
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Boutons d'action -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-gradient-primary btn-lg w-100" id="saveBtn">
                                        <i class="bi bi-check-circle me-2"></i>
                                        <span id="saveText">Enregistrer les modifications</span>
                                        <span id="saveSpinner" class="spinner-border spinner-border-sm ms-2 d-none" role="status">
                                            <span class="visually-hidden">Sauvegarde...</span>
                                        </span>
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('users.index') }}" class="btn btn-gradient-secondary btn-lg w-100">
                                        <i class="bi bi-arrow-left me-2"></i>
                                        Annuler et retour
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sidebar avec informations -->
            <div class="col-lg-4">
                <!-- Profil utilisateur -->
                <div class="edit-card mb-4">
                    <div class="profile-section">
                        <div class="text-center">
                            @if($user->profile_picture)
                                <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                     alt="{{ $user->name }}" 
                                     class="current-avatar mb-3">
                            @else
                                <div class="avatar-placeholder mb-3">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                            @endif
                            <h4 class="fw-bold mb-2">{{ $user->name }}</h4>
                            <p class="mb-3 opacity-75">{{ $user->email }}</p>

                            @if($user->email_verified_at)
                                <span class="verification-status verified">
                                    <i class="bi bi-shield-check me-2"></i>Email vérifié
                                </span>
                            @else
                                <span class="verification-status unverified">
                                    <i class="bi bi-shield-exclamation me-2"></i>Email non vérifié
                                </span>
                            @endif

                            @if($user->provider)
                                <div class="mt-2">
                                    <span class="provider-badge">
                                        <i class="bi bi-link-45deg me-1"></i>
                                        Connecté via {{ ucfirst($user->provider) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-info-circle me-2 text-primary"></i>
                            Informations du compte
                        </h6>

                        <div class="row">
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="stat-value">{{ $user->id }}</div>
                                    <div class="stat-label">ID Utilisateur</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="text-center">
                                    <div class="stat-value">{{ $user->getRoleNames()->count() }}</div>
                                    <div class="stat-label">Rôles actifs</div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="mb-3">
                            <small class="text-muted fw-medium">Créé le</small>
                            <div class="fw-bold">{{ $user->created_at->format('d/m/Y à H:i') }}</div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted fw-medium">Dernière modification</small>
                            <div class="fw-bold">{{ $user->updated_at->format('d/m/Y à H:i') }}</div>
                        </div>

                        @if($user->email_verified_at)
                        <div class="mb-3">
                            <small class="text-muted fw-medium">Email vérifié le</small>
                            <div class="fw-bold">{{ $user->email_verified_at->format('d/m/Y à H:i') }}</div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Rôles actuels -->
                @if($user->getRoleNames()->count() > 0)
                <div class="edit-card mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-shield-check me-2 text-success"></i>
                            Rôles actuels
                        </h6>
                        
                        @foreach($user->getRoleNames() as $roleName)
                            <div class="d-flex align-items-center justify-content-between p-2 mb-2 bg-light rounded">
                                <div>
                                    <span class="fw-medium">{{ ucfirst($roleName) }}</span>
                                    <br>
                                    <small class="text-muted">
                                        @switch($roleName)
                                            @case('admin')
                                                Administrateur système
                                                @break
                                            @case('moderator')
                                                Modérateur de contenu
                                                @break
                                            @case('editor')
                                                Éditeur de contenu
                                                @break
                                            @case('user')
                                                Utilisateur standard
                                                @break
                                            @default
                                                Rôle personnalisé
                                        @endswitch
                                    </small>
                                </div>
                                <i class="bi bi-check-circle text-success"></i>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Actions rapides -->
                <div class="edit-card mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-lightning me-2 text-warning"></i>
                            Actions rapides
                        </h6>

                        <div class="d-grid gap-2">
                            <!-- Voir profil -->
                            <a href="{{ route('users.show', $user) }}" class="btn btn-outline-primary">
                                <i class="bi bi-eye me-2"></i>
                                Voir le profil
                            </a>

                            <!-- Envoyer email de vérification -->
                            @if(!$user->email_verified_at)
                            <form action="{{ route('users.sendVerification', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-info w-100">
                                    <i class="bi bi-envelope-check me-2"></i>
                                    Renvoyer email de vérification
                                </button>
                            </form>
                            @endif

                            <!-- Réinitialiser mot de passe -->
                            <form action="{{ route('users.resetPassword', $user) }}" method="POST" 
                                  onsubmit="return confirm('Envoyer un lien de réinitialisation de mot de passe à {{ $user->name }} ?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-key me-2"></i>
                                    Réinitialiser mot de passe
                                </button>
                            </form>

                            <!-- Suspendre/Activer compte -->
                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.toggleStatus', $user) }}" method="POST"
                                  onsubmit="return confirm('{{ $user->is_active ? 'Suspendre' : 'Activer' }} le compte de {{ $user->name }} ?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-{{ $user->is_active ? 'warning' : 'success' }} w-100">
                                    <i class="bi bi-{{ $user->is_active ? 'pause-circle' : 'play-circle' }} me-2"></i>
                                    {{ $user->is_active ? 'Suspendre compte' : 'Activer compte' }}
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Zone de danger -->
                @if($user->id !== auth()->id() && auth()->user()->hasRole('admin'))
                <div class="edit-card border-danger">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3 text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Zone de danger
                        </h6>

                        <p class="text-muted small mb-3">
                            Les actions suivantes sont irréversibles. Procédez avec prudence.
                        </p>

                        <div class="d-grid">
                            <button type="button" 
                                    class="btn btn-outline-danger"
                                    onclick="confirmDelete('{{ $user->name }}', '{{ route('users.destroy', $user) }}')">
                                <i class="bi bi-trash me-2"></i>
                                Supprimer définitivement
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal de confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-danger" id="deleteModalLabel">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        Supprimer l'utilisateur
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-x" style="font-size: 4rem; color: #e53e3e;"></i>
                    </div>
                    <p class="text-center mb-4">
                        Êtes-vous absolument certain de vouloir supprimer le compte de 
                        <strong id="userToDelete"></strong> ?
                    </p>
                    <div class="alert alert-danger border-0" style="border-radius: 12px;">
                        <div class="d-flex">
                            <i class="bi bi-exclamation-triangle text-danger me-3 mt-1"></i>
                            <div>
                                <strong>Cette action est irréversible !</strong>
                                <ul class="mb-0 mt-2">
                                    <li>Toutes les données utilisateur seront supprimées</li>
                                    <li>L'accès au compte sera définitivement révoqué</li>
                                    <li>Cette action ne peut pas être annulée</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <p class="text-muted text-center mb-0">
                        Tapez <strong>"SUPPRIMER"</strong> pour confirmer
                    </p>
                    <input type="text" id="confirmText" class="form-control text-center fw-bold mt-2" placeholder="SUPPRIMER">
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" id="confirmDeleteBtn" class="btn btn-danger px-4" disabled>
                            <i class="bi bi-trash me-1"></i>Supprimer définitivement
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Prévisualisation de l'image
            window.previewImage = function(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        const currentAvatar = document.getElementById('currentAvatar');
                        if (currentAvatar) {
                            currentAvatar.src = e.target.result;
                        } else {
                            // Créer une nouvelle image si pas d'avatar actuel
                            const avatarContainer = document.querySelector('.avatar-placeholder');
                            if (avatarContainer) {
                                avatarContainer.innerHTML = `<img src="${e.target.result}" class="current-avatar" id="currentAvatar">`;
                            }
                        }
                    };
                    
                    reader.readAsDataURL(input.files[0]);
                }
            };

            // Gestion du formulaire
            const form = document.getElementById('userEditForm');
            const saveBtn = document.getElementById('saveBtn');
            const saveText = document.getElementById('saveText');
            const saveSpinner = document.getElementById('saveSpinner');

            form.addEventListener('submit', function(e) {
                // Animation du bouton de sauvegarde
                saveBtn.disabled = true;
                saveText.textContent = 'Sauvegarde en cours...';
                saveSpinner.classList.remove('d-none');
            });

            // Validation en temps réel des mots de passe
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirmation');

            function validatePasswords() {
                if (password.value && passwordConfirm.value) {
                    if (password.value !== passwordConfirm.value) {
                        passwordConfirm.setCustomValidity('Les mots de passe ne correspondent pas');
                        passwordConfirm.classList.add('is-invalid');
                    } else {
                        passwordConfirm.setCustomValidity('');
                        passwordConfirm.classList.remove('is-invalid');
                    }
                }
            }

            password.addEventListener('input', validatePasswords);
            passwordConfirm.addEventListener('input', validatePasswords);

            // Confirmation pour changements de rôle critiques
            const roleCheckboxes = document.querySelectorAll('input[name="roles[]"]');
            roleCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    if (this.value === 'admin' && this.checked) {
                        if (!confirm('Attention ! Vous êtes sur le point de donner des droits administrateur complets. Êtes-vous sûr ?')) {
                            this.checked = false;
                        }
                    }
                });
            });

            // Modal de suppression avec confirmation textuelle
            const confirmText = document.getElementById('confirmText');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            if (confirmText && confirmDeleteBtn) {
                confirmText.addEventListener('input', function() {
                    confirmDeleteBtn.disabled = this.value !== 'SUPPRIMER';
                });
            }
        });

        // Fonction pour la confirmation de suppression
        function confirmDelete(userName, deleteUrl) {
            document.getElementById('userToDelete').textContent = userName;
            document.getElementById('deleteForm').action = deleteUrl;
            document.getElementById('confirmText').value = '';
            document.getElementById('confirmDeleteBtn').disabled = true;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Animation d'entrée pour les cartes
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.edit-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 150);
            });
        });

        // Sauvegarde automatique des préférences (optionnel)
        function autoSave() {
            const formData = new FormData(document.getElementById('userEditForm'));
            const preferences = {};
            
            // Sauvegarder les données non sensibles en localStorage pour une restauration en cas de problème
            ['name', 'email'].forEach(field => {
                if (formData.get(field)) {
                    preferences[field] = formData.get(field);
                }
            });
            
            localStorage.setItem('userEditDraft_{{ $user->id }}', JSON.stringify(preferences));
        }

        // Auto-save toutes les 30 secondes (optionnel)
        setInterval(autoSave, 30000);

        // Restaurer le brouillon au chargement (optionnel)
        window.addEventListener('load', function() {
            const draft = localStorage.getItem('userEditDraft_{{ $user->id }}');
            if (draft) {
                const preferences = JSON.parse(draft);
                
                // Demander si l'utilisateur veut restaurer
                if (confirm('Un brouillon de modifications a été trouvé. Souhaitez-vous le restaurer ?')) {
                    Object.keys(preferences).forEach(field => {
                        const input = document.getElementById(field);
                        if (input && input.value === input.defaultValue) {
                            input.value = preferences[field];
                        }
                    });
                }
            }
        });

        // Nettoyer le brouillon après sauvegarde réussie
        document.getElementById('userEditForm').addEventListener('submit', function() {
            setTimeout(() => {
                localStorage.removeItem('userEditDraft_{{ $user->id }}');
            }, 1000);
        });
    </script>
@endsection