@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
    <div class="page-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Mon Profil</h1>
                    <p class="lead opacity-75">Gérez vos informations personnelles et paramètres de compte</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex align-items-center justify-content-lg-end">
                        <div class="bg-white bg-opacity-20 rounded-circle p-3 me-3">
                            <i class="bi bi-person-circle fs-1 text-primary"></i>
                        </div>
                        <div class="text-white">
                            <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                            <small class="opacity-75">Membre depuis {{ auth()->user()->created_at->format('M Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fermer"></button>
        </div>
    @endif

    <div class="container py-5">
        <div class="row g-4">
            <!-- Informations du profil -->
            <div class="col-lg-8">
                <div class="floating-card p-4 mb-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-person-lines-fill text-primary fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Informations personnelles</h4>
                            <p class="text-muted mb-0">Gérez vos informations de base</p>
                        </div>
                    </div>

                    <form action="{{ route('profile.update', auth()->user()->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person me-2"></i>Nom complet
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2"></i>Adresse email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', auth()->user()->email) }}" readonly
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-modern">
                                <i class="bi bi-check-circle me-2"></i>Mettre à jour le profil
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Changement de mot de passe -->
                <div class="floating-card p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                            <i class="bi bi-shield-lock text-warning fs-4"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">Sécurité du compte</h4>
                            <p class="text-muted mb-0">Modifiez votre mot de passe</p>
                        </div>
                    </div>

                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2"></i>Adresse email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                                    required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="current_password" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-2"></i>Mot de passe actuel
                                </label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-key me-2"></i>Nouveau mot de passe
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-key me-2"></i>Confirmer le mot de passe
                                </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-modern" style="background: var(--secondary-gradient);">
                                <i class="bi bi-shield-check me-2"></i>Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar avec informations du compte -->
            <div class="col-lg-4">
                <!-- Carte de profil -->
                <div class="floating-card p-4 mb-4 text-center">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="bg-primary bg-opacity-10 rounded-circle p-4 d-inline-flex">
                            <i class="bi bi-person-circle text-primary" style="font-size: 4rem;"></i>
                        </div>
                        <div class="position-absolute bottom-0 end-0 bg-success rounded-circle p-2">
                            <i class="bi bi-check text-white"></i>
                        </div>
                    </div>

                    <h4 class="fw-bold mb-2">{{ auth()->user()->name }}</h4>
                    <p class="text-muted mb-3">{{ auth()->user()->email }}</p>

                    <div class="border-top pt-3 mt-3">
                        <div class="row text-center">
                            <div class="col-6">
                                <div class="fw-bold text-primary fs-5">
                                    {{ auth()->user()->created_at->diffInDays() }}
                                </div>
                                <small class="text-muted">Jours</small>
                            </div>
                            <div class="col-6">
                                <div class="fw-bold text-success fs-5">
                                    @if (auth()->user()->email_verified_at)
                                        <i class="bi bi-patch-check-fill"></i>
                                    @else
                                        <i class="bi bi-patch-exclamation-fill text-warning"></i>
                                    @endif
                                </div>
                                <small class="text-muted">Statut</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informations du compte -->
                <div class="floating-card p-4 mb-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-info-circle text-info me-2"></i>Informations du compte
                    </h5>

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-muted">Compte créé</span>
                        <span class="fw-semibold">{{ auth()->user()->created_at->format('d/m/Y') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span class="text-muted">Dernière mise à jour</span>
                        <span class="fw-semibold">{{ auth()->user()->updated_at->format('d/m/Y') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center py-2">
                        <span class="text-muted">Email vérifié</span>
                        @if (auth()->user()->email_verified_at)
                            <span class="badge bg-success">
                                <i class="bi bi-check-circle me-1"></i>Vérifié
                            </span>
                        @else
                            <span class="badge bg-warning">
                                <i class="bi bi-exclamation-triangle me-1"></i>Non vérifié
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Actions rapides -->
                <div class="floating-card p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-lightning text-warning me-2"></i>Actions rapides
                    </h5>

                    @if (!auth()->user()->email_verified_at)
                        <div class="d-grid gap-2 mb-3">
                            <form action="#" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-envelope-check me-2"></i>Vérifier l'email
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <form action="{{ route('logout') }}" method="POST" class="d-grid">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-box-arrow-right me-2"></i>Se déconnecter
                            </button>
                        </form>
                        <form action="{{ route('profile.delete', auth()->id()) }}" method="POST"
                            onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte ? Cette action est irréversible.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash me-2"></i>Supprimer ce compte
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script pour les notifications -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Afficher les messages de session
            @if (session('success'))
                showToast('success', '{{ session('success') }}');
            @endif

            @if (session('error'))
                showToast('error', '{{ session('error') }}');
            @endif

            @if (session('warning'))
                showToast('warning', '{{ session('warning') }}');
            @endif

            @if (session('info'))
                showToast('info', '{{ session('info') }}');
            @endif
        });
    </script>
@endsection
