@extends('layouts.auth')

@section('content')
<style>
    .auth-background {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: calc(100vh - 76px);
        position: relative;
        overflow: hidden;
    }

    .auth-background::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 20"><defs><pattern id="grain" width="100" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="5" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="15" r="1.5" fill="rgba(255,255,255,0.05)"/><circle cx="80" cy="3" r="0.8" fill="rgba(255,255,255,0.08)"/></pattern></defs><rect width="100%" height="100%" fill="url(%23grain)"/></svg>');
        opacity: 0.3;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 25px;
        box-shadow: 0 30px 80px rgba(0, 0, 0, 0.2);
        overflow: hidden;
        position: relative;
        z-index: 2;
    }

    .auth-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        padding: 2rem;
        text-align: center;
        border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        position: relative;
    }

    .auth-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(102,126,234,0.1)"/><circle cx="20" cy="20" r="1" fill="rgba(118,75,162,0.08)"/><circle cx="80" cy="30" r="1.5" fill="rgba(102,126,234,0.06)"/></svg>');
        opacity: 0.5;
    }

    .auth-title {
        font-size: 2rem;
        font-weight: 700;
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .auth-subtitle {
        color: #6c757d;
        font-weight: 500;
        position: relative;
        z-index: 1;
    }

    .auth-body {
        padding: 2.5rem;
    }

    .form-floating {
        margin-bottom: 1.5rem;
    }

    .form-floating > .form-control {
        border: 2px solid rgba(102, 126, 234, 0.15);
        border-radius: 15px;
        padding: 1rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }

    .form-floating > .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
        background: white;
        transform: translateY(-2px);
    }

    .form-floating > label {
        color: #6c757d;
        font-weight: 500;
        padding: 1rem 1rem;
    }

    .btn-auth {
        background: var(--primary-gradient);
        border: none;
        border-radius: 15px;
        padding: 15px 40px;
        font-weight: 600;
        font-size: 1.1rem;
        color: white;
        transition: all 0.4s ease;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
    }

    .btn-auth::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-auth:hover::before {
        left: 100%;
    }

    .btn-auth:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
        color: white;
    }

    .btn-auth:active {
        transform: translateY(-1px);
    }

    .btn-link-custom {
        color: #667eea;
        text-decoration: none;
        font-weight: 500;
        position: relative;
        transition: all 0.3s ease;
    }

    .btn-link-custom::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 2px;
        background: var(--primary-gradient);
        transition: width 0.3s ease;
    }

    .btn-link-custom:hover::after {
        width: 100%;
    }

    .btn-link-custom:hover {
        color: #5a67d8;
        transform: translateX(3px);
    }

    .alert-custom {
        background: rgba(25, 135, 84, 0.1);
        border: 1px solid rgba(25, 135, 84, 0.2);
        border-radius: 12px;
        color: #198754;
        padding: 1rem;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }

    .alert-custom::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: #198754;
    }

    .alert-custom .alert-icon {
        margin-right: 0.5rem;
    }

    .info-card {
        background: rgba(13, 110, 253, 0.1);
        border: 1px solid rgba(13, 110, 253, 0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .info-card .info-icon {
        font-size: 2.5rem;
        color: #0d6efd;
        margin-bottom: 1rem;
    }

    .info-card p {
        color: #6c757d;
        margin: 0;
        line-height: 1.6;
    }

    .auth-footer {
        text-align: center;
        padding: 1.5rem;
        background: rgba(102, 126, 234, 0.05);
        color: #6c757d;
        font-weight: 500;
    }

    .floating-shapes {
        position: absolute;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .shape {
        position: absolute;
        opacity: 0.1;
        animation: float 6s ease-in-out infinite;
    }

    .shape:nth-child(1) {
        top: 20%;
        left: 10%;
        animation-delay: 0s;
    }

    .shape:nth-child(2) {
        top: 60%;
        right: 10%;
        animation-delay: 2s;
    }

    .shape:nth-child(3) {
        bottom: 20%;
        left: 20%;
        animation-delay: 4s;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(10deg); }
    }

    @media (max-width: 768px) {
        .auth-card {
            margin: 1rem;
            border-radius: 20px;
        }
        
        .auth-header, .auth-body {
            padding: 1.5rem;
        }
        
        .auth-title {
            font-size: 1.5rem;
        }
    }
</style>

<div class="auth-background d-flex align-items-center justify-content-center py-5">
    <!-- Formes flottantes -->
    <div class="floating-shapes">
        <div class="shape">
            <i class="bi bi-circle" style="font-size: 3rem;"></i>
        </div>
        <div class="shape">
            <i class="bi bi-triangle" style="font-size: 2.5rem;"></i>
        </div>
        <div class="shape">
            <i class="bi bi-square" style="font-size: 2rem;"></i>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="auth-card">
                    <!-- Header -->
                    <div class="auth-header">
                        <div class="mb-3">
                            <i class="bi bi-key-fill display-4 text-primary"></i>
                        </div>
                        <h2 class="auth-title">Mot de passe oublié ?</h2>
                        <p class="auth-subtitle mb-0">Réinitialisez votre mot de passe</p>
                    </div>

                    <!-- Body -->
                    <div class="auth-body">
                        @if (session('status'))
                            <div class="alert-custom">
                                <i class="bi bi-check-circle alert-icon"></i>
                                <strong>Email envoyé !</strong><br>
                                {{ session('status') }}
                            </div>
                        @else
                            <!-- Information Card -->
                            <div class="info-card">
                                <div class="info-icon">
                                    <i class="bi bi-envelope-paper"></i>
                                </div>
                                <p>
                                    Saisissez votre adresse email et nous vous enverrons un lien pour réinitialiser votre mot de passe.
                                </p>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email -->
                            <div class="form-floating">
                                <input id="email" type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       name="email" value="{{ old('email') }}" 
                                       required autocomplete="email" autofocus
                                       placeholder="name@example.com">
                                <label for="email">
                                    <i class="bi bi-envelope me-2"></i>{{ __('Adresse Email') }}
                                </label>
                                
                                @error('email')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-auth">
                                    <i class="bi bi-send me-2"></i>
                                    {{ __('Envoyer le lien de réinitialisation') }}
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div class="auth-footer">
                        <p class="mb-2">
                            <a href="{{ route('login') }}" class="btn-link-custom">
                                <i class="bi bi-arrow-left me-1"></i>
                                <strong>Retour à la connexion</strong>
                            </a>
                        </p>
                        <p class="mb-0">
                            Pas encore de compte ? 
                            <a href="{{ route('register') }}" class="btn-link-custom">
                                <strong>Créer un compte</strong>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Animation des formes au chargement
document.addEventListener('DOMContentLoaded', function() {
    const shapes = document.querySelectorAll('.shape');
    shapes.forEach((shape, index) => {
        setTimeout(() => {
            shape.style.opacity = '0.1';
            shape.style.transform = 'translateY(0)';
        }, index * 500);
    });

    // Auto-focus sur le champ email après animation
    setTimeout(() => {
        document.getElementById('email').focus();
    }, 1000);
});

// Animation de succès après envoi
@if(session('status'))
document.addEventListener('DOMContentLoaded', function() {
    // Effet de pulsation sur l'alerte
    const alert = document.querySelector('.alert-custom');
    if (alert) {
        alert.style.animation = 'pulse 0.6s ease-in-out';
    }
});

// Animation CSS pour le pulse
const style = document.createElement('style');
style.textContent = `
    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.02); }
        100% { transform: scale(1); }
    }
`;
document.head.appendChild(style);
@endif
</script>
@endsection