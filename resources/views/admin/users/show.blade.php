@extends('layouts.product')

@section('title', 'Profil de ' . $user->name)

@section('content')
    <style>
        /* Styles personnalisés pour la page de profil utilisateur */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .profile-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
            border-radius: 0 0 40px 40px;
            margin-bottom: 2rem;
        }

        .profile-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: pulse 6s ease-in-out infinite;
        }

        .profile-hero::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 40px;
            background: url("data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M20 20.5V18H0v-2h20v2.5L0 18.5H0V21h20v-0.5zM0 21h20v2H0v-2z' fill='%23ffffff' fill-opacity='0.05'/%3E%3C/svg%3E") repeat-x;
        }

        @keyframes pulse {
            0%, 100% { opacity: 0.3; transform: scale(1) rotate(0deg); }
            50% { opacity: 0.7; transform: scale(1.1) rotate(180deg); }
        }

        .profile-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            overflow: hidden;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 6px solid white;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            margin-top: -75px;
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.1);
        }

        .avatar-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: bold;
            color: white;
            border: 6px solid white;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
            margin-top: -75px;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
            transition: all 0.3s ease;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            line-height: 1;
        }

        .stat-label {
            color: #718096;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.75rem 1.5rem;
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

        .info-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
            margin-bottom: 2rem;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f7fafc;
        }

        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }

        .info-label {
            font-weight: 600;
            color: #4a5568;
            display: flex;
            align-items: center;
        }

        .info-label i {
            margin-right: 0.5rem;
            color: #667eea;
            width: 20px;
            text-align: center;
        }

        .info-value {
            font-weight: 500;
            color: #2d3748;
        }

        .role-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
            margin: 0.25rem;
            transition: all 0.3s ease;
        }

        .role-badge:hover {
            transform: translateY(-2px);
        }

        .role-admin {
            background: linear-gradient(135deg, #e53e3e 0%, #c53030 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.4);
        }

        .role-moderator {
            background: linear-gradient(135deg, #dd6b20 0%, #c05621 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(221, 107, 32, 0.4);
        }

        .role-editor {
            background: linear-gradient(135deg, #38a169 0%, #2f855a 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(56, 161, 105, 0.4);
        }

        .role-user {
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(66, 153, 225, 0.4);
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .status-verified {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .status-unverified {
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);
            color: white;
        }

        .status-active {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(135deg, #a0aec0 0%, #718096 100%);
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

        .timeline {
            position: relative;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 30px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            padding-left: 4rem;
        }

        .timeline-icon {
            position: absolute;
            left: 0;
            top: 0;
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .timeline-content {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
        }

        .activity-card {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 16px;
            padding: 2rem;
            border: 2px solid #e2e8f0;
            margin-bottom: 2rem;
        }

        .permission-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .permission-item {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .permission-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .permission-item.granted {
            border-color: #48bb78;
            background: linear-gradient(135deg, rgba(72, 187, 120, 0.1) 0%, rgba(56, 161, 105, 0.1) 100%);
        }

        .permission-item.denied {
            border-color: #a0aec0;
            background: #f7fafc;
        }

        @media (max-width: 768px) {
            .profile-hero {
                padding: 2rem 0;
            }
            
            .profile-avatar,
            .avatar-placeholder {
                width: 120px;
                height: 120px;
                margin-top: -60px;
            }
            
            .avatar-placeholder {
                font-size: 2.5rem;
            }
            
            .stat-number {
                font-size: 2rem;
            }
            
            .timeline-item {
                padding-left: 3rem;
            }
            
            .timeline-icon {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }
            
            .timeline::before {
                left: 20px;
            }
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

        .alert-warning {
            background: linear-gradient(135deg, #f6ad55 0%, #ed8936 100%);
            color: white;
        }

        .floating-actions {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 1000;
        }

        .floating-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 20px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }

        .floating-btn:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 8px 30px rgba(102, 126, 234, 0.6);
            color: white;
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
                    <i class="bi bi-person me-1"></i>{{ $user->name }}
                </li>
            </ol>
        </nav>

        <!-- Hero Section -->
        <div class="profile-hero">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="me-4">
                                @if($user->profile_picture)
                                    <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                                         alt="{{ $user->name }}" 
                                         class="profile-avatar">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h1 class="display-4 fw-bold mb-2">{{ $user->name }}</h1>
                                <p class="lead mb-3 opacity-75">{{ $user->email }}</p>
                                <div class="d-flex flex-wrap align-items-center gap-2">
                                    @if($user->email_verified_at)
                                        <span class="status-badge status-verified">
                                            <i class="bi bi-shield-check me-2"></i>Email vérifié
                                        </span>
                                    @else
                                        <span class="status-badge status-unverified">
                                            <i class="bi bi-shield-exclamation me-2"></i>Email non vérifié
                                        </span>
                                    @endif

                                    @if(isset($user->is_active))
                                        @if($user->is_active)
                                            <span class="status-badge status-active">
                                                <i class="bi bi-check-circle me-2"></i>Compte actif
                                            </span>
                                        @else
                                            <span class="status-badge status-inactive">
                                                <i class="bi bi-pause-circle me-2"></i>Compte suspendu
                                            </span>
                                        @endif
                                    @endif

                                    @if($user->provider)
                                        <span class="provider-badge">
                                            <i class="bi bi-link-45deg me-1"></i>
                                            {{ ucfirst($user->provider) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <div class="d-flex flex-column gap-2">
                            @can('update', $user)
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-light btn-lg">
                                <i class="bi bi-pencil me-2"></i>
                                Modifier le profil
                            </a>
                            @endcan
                            
                            @if(!$user->email_verified_at && auth()->user()->hasRole('admin'))
                            <form action="{{ route('users.sendVerification', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-light w-100">
                                    <i class="bi bi-envelope-check me-2"></i>
                                    Envoyer vérification
                                </button>
                            </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistiques -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-label">ID Utilisateur</div>
                    <div class="stat-number">{{ $user->id }}</div>
                    <small class="text-muted">
                        <i class="bi bi-hash me-1"></i>Identifiant unique
                    </small>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-label">Rôles attribués</div>
                    <div class="stat-number">{{ $user->getRoleNames()->count() }}</div>
                    <small class="text-muted">
                        <i class="bi bi-shield me-1"></i>Permissions actives
                    </small>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-label">Membre depuis</div>
                    <div class="stat-number">{{ $user->created_at->diffInDays() }}</div>
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>Jours
                    </small>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card text-center">
                    <div class="stat-label">Dernière activité</div>
                    <div class="stat-number">{{ $user->updated_at->diffInDays() }}</div>
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>Jours
                    </small>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Informations principales -->
            <div class="col-lg-8">
                <!-- Informations personnelles -->
                <div class="info-card">
                    <h4 class="fw-bold mb-4">
                        <i class="bi bi-person-circle text-primary me-2"></i>
                        Informations personnelles
                    </h4>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-person"></i>
                            Nom complet
                        </div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-envelope"></i>
                            Adresse email
                        </div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-calendar-plus"></i>
                            Date d'inscription
                        </div>
                        <div class="info-value">
                            {{ $user->created_at->format('d/m/Y à H:i') }}
                            <small class="text-muted">({{ $user->created_at->diffForHumans() }})</small>
                        </div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-clock-history"></i>
                            Dernière modification
                        </div>
                        <div class="info-value">
                            {{ $user->updated_at->format('d/m/Y à H:i') }}
                            <small class="text-muted">({{ $user->updated_at->diffForHumans() }})</small>
                        </div>
                    </div>

                    @if($user->email_verified_at)
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-shield-check"></i>
                            Email vérifié le
                        </div>
                        <div class="info-value">
                            {{ $user->email_verified_at->format('d/m/Y à H:i') }}
                            <small class="text-muted">({{ $user->email_verified_at->diffForHumans() }})</small>
                        </div>
                    </div>
                    @endif

                    @if($user->provider)
                    <div class="info-row">
                        <div class="info-label">
                            <i class="bi bi-link-45deg"></i>
                            Connexion externe
                        </div>
                        <div class="info-value">
                            <span class="provider-badge">
                                {{ ucfirst($user->provider) }}
                            </span>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Rôles et Permissions -->
                @if($user->getRoleNames()->count() > 0)
                <div class="info-card">
                    <h4 class="fw-bold mb-4">
                        <i class="bi bi-shield-check text-success me-2"></i>
                        Rôles et Permissions
                    </h4>

                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">Rôles attribués :</h6>
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($user->getRoleNames() as $roleName)
                                <span class="role-badge role-{{ strtolower($roleName) }}">
                                    <i class="bi bi-shield-fill me-2"></i>
                                    {{ ucfirst($roleName) }}
                                </span>
                            @endforeach
                        </div>
                    </div>

                    @if($user->getAllPermissions()->count() > 0)
                    <div>
                        <h6 class="fw-bold mb-3">Permissions accordées :</h6>
                        <div class="permission-grid">
                            @foreach($user->getAllPermissions() as $permission)
                                <div class="permission-item granted">
                                    <i class="bi bi-check-circle text-success me-2"></i>
                                    <span>{{ $permission->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Activité récente -->
                <div class="activity-card">
                    <h4 class="fw-bold mb-4">
                        <i class="bi bi-activity text-info me-2"></i>
                        Chronologie du compte
                    </h4>

                    <div class="timeline">
                        <!-- Inscription -->
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-person-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold mb-2">Création du compte</h6>
                                <p class="text-muted mb-2">L'utilisateur s'est inscrit sur la plateforme</p>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $user->created_at->format('d/m/Y à H:i') }}
                                    ({{ $user->created_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>

                        <!-- Vérification email -->
                        @if($user->email_verified_at)
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-shield-check"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold mb-2">Email vérifié</h6>
                                <p class="text-muted mb-2">L'adresse email a été confirmée avec succès</p>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $user->email_verified_at->format('d/m/Y à H:i') }}
                                    ({{ $user->email_verified_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                        @endif

                        <!-- Attribution de rôles -->
                        @if($user->getRoleNames()->count() > 0)
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-shield-plus"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold mb-2">Rôles attribués</h6>
                                <p class="text-muted mb-2">Des rôles ont été assignés à cet utilisateur</p>
                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    @foreach($user->getRoleNames() as $roleName)
                                        <span class="badge bg-primary">{{ ucfirst($roleName) }}</span>
                                    @endforeach
                                </div>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    Gestion des permissions active
                                </small>
                            </div>
                        </div>
                        @endif

                        <!-- Dernière mise à jour -->
                        @if($user->updated_at->gt($user->created_at))
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="timeline-content">
                                <h6 class="fw-bold mb-2">Profil mis à jour</h6>
                                <p class="text-muted mb-2">Les informations du profil ont été modifiées</p>
                                <small class="text-muted">
                                    <i class="bi bi-calendar me-1"></i>
                                    {{ $user->updated_at->format('d/m/Y à H:i') }}
                                    ({{ $user->updated_at->diffForHumans() }})
                                </small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Actions rapides -->
                <div class="profile-card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-lightning text-warning me-2"></i>
                            Actions rapides
                        </h5>

                        <div class="d-grid gap-3">
                            @can('update', $user)
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-gradient-primary">
                                <i class="bi bi-pencil me-2"></i>
                                Modifier le profil
                            </a>
                            @endcan

                            @if(!$user->email_verified_at && auth()->user()->hasRole('admin'))
                            <form action="{{ route('users.sendVerification', $user) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-success w-100">
                                    <i class="bi bi-envelope-check me-2"></i>
                                    Envoyer vérification email
                                </button>
                            </form>
                            @endif

                            @if(auth()->user()->hasRole('admin'))
                            <form action="{{ route('users.resetPassword', $user) }}" method="POST" 
                                  onsubmit="return confirm('Envoyer un lien de réinitialisation à {{ $user->name }} ?')">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-key me-2"></i>
                                    Réinitialiser mot de passe
                                </button>
                            </form>

                            @if($user->id !== auth()->id())
                            <form action="{{ route('users.toggleStatus', $user) }}" method="POST"
                                  onsubmit="return confirm('{{ isset($user->is_active) && $user->is_active ? 'Suspendre' : 'Activer' }} le compte ?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-outline-{{ isset($user->is_active) && $user->is_active ? 'warning' : 'success' }} w-100">
                                    <i class="bi bi-{{ isset($user->is_active) && $user->is_active ? 'pause-circle' : 'play-circle' }} me-2"></i>
                                    {{ isset($user->is_active) && $user->is_active ? 'Suspendre compte' : 'Activer compte' }}
                                </button>
                            </form>
                            @endif
                            @endif

                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour à la liste
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Informations système -->
                <div class="profile-card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-gear text-secondary me-2"></i>
                            Informations système
                        </h5>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="bi bi-hash"></i>
                                ID Base de données
                            </div>
                            <div class="info-value">
                                <code class="bg-light px-2 py-1 rounded">{{ $user->id }}</code>
                            </div>
                        </div>

                        @if($user->remember_token)
                        <div class="info-row">
                            <div class="info-label">
                                <i class="bi bi-key-fill"></i>
                                Token de session
                            </div>
                            <div class="info-value">
                                <span class="badge bg-success">Actif</span>
                            </div>
                        </div>
                        @endif

                        @if($user->provider_id)
                        <div class="info-row">
                            <div class="info-label">
                                <i class="bi bi-link"></i>
                                ID Fournisseur
                            </div>
                            <div class="info-value">
                                <code class="bg-light px-2 py-1 rounded">{{ $user->provider_id }}</code>
                            </div>
                        </div>
                        @endif

                        <div class="info-row">
                            <div class="info-label">
                                <i class="bi bi-clock"></i>
                                Timezone
                            </div>
                            <div class="info-value">
                                {{ config('app.timezone', 'UTC') }}
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-label">
                                <i class="bi bi-database"></i>
                                Table
                            </div>
                            <div class="info-value">
                                <code class="bg-light px-2 py-1 rounded">users</code>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques détaillées -->
                <div class="profile-card">
                    <div class="card-body">
                        <h5 class="fw-bold mb-4">
                            <i class="bi bi-graph-up text-info me-2"></i>
                            Statistiques détaillées
                        </h5>

                        <div class="row">
                            <div class="col-6 text-center mb-3">
                                <div class="stat-number">{{ strlen($user->name) }}</div>
                                <div class="stat-label">Caractères nom</div>
                            </div>
                            <div class="col-6 text-center mb-3">
                                <div class="stat-number">{{ strlen($user->email) }}</div>
                                <div class="stat-label">Caractères email</div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 text-center mb-3">
                                <div class="stat-number">{{ $user->created_at->format('G') }}</div>
                                <div class="stat-label">Heure inscription</div>
                            </div>
                            <div class="col-6 text-center mb-3">
                                <div class="stat-number">{{ $user->created_at->dayOfWeek }}</div>
                                <div class="stat-label">Jour semaine</div>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="text-center">
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Compte créé {{ $user->created_at->format('l d F Y') }}
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Zone de danger (si admin et pas soi-même) -->
                @if(auth()->user()->hasRole('admin') && $user->id !== auth()->id())
                <div class="profile-card border-danger">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3 text-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Zone de danger
                        </h5>

                        <p class="text-muted small mb-4">
                            <i class="bi bi-info-circle me-1"></i>
                            Ces actions sont définitives et ne peuvent pas être annulées.
                        </p>

                        <div class="d-grid gap-2">
                            <button type="button" 
                                    class="btn btn-outline-danger"
                                    onclick="confirmDelete('{{ $user->name }}', '{{ route('users.destroy', $user) }}')">
                                <i class="bi bi-trash me-2"></i>
                                Supprimer définitivement
                            </button>

                            <button type="button" 
                                    class="btn btn-outline-warning btn-sm"
                                    onclick="confirmAction('Révoquer toutes les permissions de {{ $user->name }} ?', '{{ route('users.revokeAllPermissions', $user) }}')">
                                <i class="bi bi-shield-x me-2"></i>
                                Révoquer permissions
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions flottantes pour mobile -->
    <div class="floating-actions d-lg-none">
        @can('update', $user)
        <a href="{{ route('users.edit', $user) }}" class="floating-btn" title="Modifier">
            <i class="bi bi-pencil"></i>
        </a>
        @endcan
        
        <a href="{{ route('users.index') }}" class="floating-btn" title="Retour">
            <i class="bi bi-arrow-left"></i>
        </a>
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

    <!-- Modal de confirmation d'action générique -->
    <div class="modal fade" id="actionModal" tabindex="-1" aria-labelledby="actionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-warning" id="actionModalLabel">
                        <i class="bi bi-question-circle me-2"></i>
                        Confirmer l'action
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <div class="text-center mb-4">
                        <i class="bi bi-exclamation-triangle" style="font-size: 3rem; color: #f6ad55;"></i>
                    </div>
                    <p class="text-center mb-4" id="actionMessage">
                        Êtes-vous sûr de vouloir effectuer cette action ?
                    </p>
                </div>
                <div class="modal-footer border-0 justify-content-center">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <form id="actionForm" method="POST" style="display: inline;">
                        @csrf
                        @method('POST')
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check me-1"></i>Confirmer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation d'entrée pour les cartes
            const cards = document.querySelectorAll('.profile-card, .stat-card, .info-card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    card.style.transition = 'all 0.6s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });

            // Gestion des tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Modal de suppression avec confirmation textuelle
            const confirmText = document.getElementById('confirmText');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');

            if (confirmText && confirmDeleteBtn) {
                confirmText.addEventListener('input', function() {
                    confirmDeleteBtn.disabled = this.value !== 'SUPPRIMER';
                });
            }

            // Animation parallax subtile pour le hero
            window.addEventListener('scroll', function() {
                const hero = document.querySelector('.profile-hero');
                if (hero) {
                    const scrolled = window.pageYOffset;
                    const parallax = scrolled * 0.5;
                    hero.style.transform = `translateY(${parallax}px)`;
                }
            });
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

        // Fonction pour confirmer une action générique
        function confirmAction(message, actionUrl, method = 'POST') {
            document.getElementById('actionMessage').textContent = message;
            document.getElementById('actionForm').action = actionUrl;
            document.getElementById('actionForm').querySelector('[name="_method"]').value = method;

            const modal = new bootstrap.Modal(document.getElementById('actionModal'));
            modal.show();
        }

        // Copier l'ID utilisateur dans le presse-papier
        function copyUserId(userId) {
            navigator.clipboard.writeText(userId).then(function() {
                // Créer une notification de succès
                const notification = document.createElement('div');
                notification.className = 'alert alert-success alert-modern position-fixed';
                notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 250px;';
                notification.innerHTML = `
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle me-2"></i>
                        <small>ID utilisateur copié !</small>
                    </div>
                `;
                
                document.body.appendChild(notification);
                
                setTimeout(() => {
                    notification.remove();
                }, 3000);
            });
        }

        // Ajouter un écouteur sur l'ID utilisateur pour le copier
        document.addEventListener('DOMContentLoaded', function() {
            const userIdElements = document.querySelectorAll('code');
            userIdElements.forEach(element => {
                if (element.textContent === '{{ $user->id }}') {
                    element.style.cursor = 'pointer';
                    element.title = 'Cliquer pour copier';
                    element.addEventListener('click', () => copyUserId('{{ $user->id }}'));
                }
            });
        });

        // Confirmation automatique pour certaines actions sensibles
        document.addEventListener('DOMContentLoaded', function() {
            const sensitiveButtons = document.querySelectorAll('button[type="submit"], a[href*="delete"]');
            sensitiveButtons.forEach(button => {
                if (button.textContent.toLowerCase().includes('supprimer') || 
                    button.textContent.toLowerCase().includes('delete')) {
                    button.addEventListener('click', function(e) {
                        const form = this.closest('form');
                        if (form && !form.hasAttribute('data-confirmed')) {
                            e.preventDefault();
                            
                            const confirmMessage = this.getAttribute('data-confirm') || 
                                                 'Êtes-vous sûr de vouloir effectuer cette action ?';
                            
                            if (confirm(confirmMessage)) {
                                form.setAttribute('data-confirmed', 'true');
                                form.submit();
                            }
                        }
                    });
                }
            });
        });
    </script>
@endsection