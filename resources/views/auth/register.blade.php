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

        .form-floating>.form-control {
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 15px;
            padding: 1rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
        }

        .form-floating>.form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.15);
            background: white;
            transform: translateY(-2px);
        }

        .form-floating>label {
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

        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .strength-bar {
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            margin-top: 0.25rem;
        }

        .strength-fill {
            height: 100%;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-weak {
            background: #dc3545;
            width: 25%;
        }

        .strength-fair {
            background: #fd7e14;
            width: 50%;
        }

        .strength-good {
            background: #ffc107;
            width: 75%;
        }

        .strength-strong {
            background: #198754;
            width: 100%;
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

        .social-login {
            padding: 1.5rem 0;
            border-top: 1px solid rgba(102, 126, 234, 0.1);
            margin-top: 2rem;
        }

        .btn-social {
            border: 2px solid rgba(102, 126, 234, 0.15);
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin: 0.25rem;
            flex: 1;
        }

        .btn-social:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .btn-google {
            color: #db4437;
            border-color: rgba(219, 68, 55, 0.2);
        }

        .btn-google:hover {
            background: #db4437;
            color: white;
            border-color: #db4437;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(10deg);
            }
        }

        @media (max-width: 768px) {
            .auth-card {
                margin: 1rem;
                border-radius: 20px;
            }

            .auth-header,
            .auth-body {
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
                <div class="col-lg-6 col-md-8">
                    <div class="auth-card">
                        <!-- Header -->
                        <div class="auth-header">
                            <div class="mb-3">
                                <i class="bi bi-person-plus-fill display-4 text-primary"></i>
                            </div>
                            <h2 class="auth-title">Créer un compte</h2>
                            <p class="auth-subtitle mb-0">Rejoignez-nous et découvrez notre plateforme</p>
                        </div>

                        <!-- Body -->
                        <div class="auth-body">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <!-- Name -->
                                <div class="form-floating">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="name" autofocus
                                        placeholder="Votre nom">
                                    <label for="name">
                                        <i class="bi bi-person me-2"></i>{{ __('Nom complet') }}
                                    </label>

                                    @error('name')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="form-floating">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email"
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

                                <!-- Password -->
                                <div class="form-floating position-relative">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder="Password"
                                        onkeyup="checkPasswordStrength()">
                                    <label for="password">
                                        <i class="bi bi-lock me-2"></i>{{ __('Mot de passe') }}
                                    </label>

                                    <button type="button"
                                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-3"
                                        style="z-index: 5; border: none; background: none;"
                                        onclick="togglePassword('password')">
                                        <i class="bi bi-eye" id="password-toggle"></i>
                                    </button>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            <strong>{{ $message }}</strong>
                                        </div>
                                    @enderror

                                    <!-- Password Strength Indicator -->
                                    <div class="password-strength">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Force du mot de passe:</small>
                                            <small id="strength-text" class="text-muted">Faible</small>
                                        </div>
                                        <div class="strength-bar">
                                            <div id="strength-fill" class="strength-fill strength-weak"></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="form-floating position-relative">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="Confirm Password" onkeyup="checkPasswordMatch()">
                                    <label for="password-confirm">
                                        <i class="bi bi-lock-fill me-2"></i>{{ __('Confirmer le mot de passe') }}
                                    </label>

                                    <button type="button"
                                        class="btn btn-link position-absolute end-0 top-50 translate-middle-y me-3"
                                        style="z-index: 5; border: none; background: none;"
                                        onclick="togglePassword('password-confirm')">
                                        <i class="bi bi-eye" id="password-confirm-toggle"></i>
                                    </button>

                                    <div id="password-match" class="mt-2" style="display: none;">
                                        <small class="text-success">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Les mots de passe correspondent
                                        </small>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-auth">
                                        <i class="bi bi-person-check me-2"></i>
                                        {{ __('Créer mon compte') }}
                                    </button>
                                </div>

                            </form>
                            <div class="social-login">
                                <div class="text-center mb-3">
                                    <small class="text-muted">Ou connectez-vous avec</small>
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('oauth.redirect', 'google') }}" class="btn btn-social btn-google">
                                        <i class="bi bi-google me-2"></i>Google
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="auth-footer">
                            <p class="mb-0">
                                Déjà un compte ?
                                <a href="{{ route('login') }}" class="btn-link-custom">
                                    <strong>Se connecter</strong>
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const toggle = document.getElementById(inputId + '-toggle');

            if (input.type === 'password') {
                input.type = 'text';
                toggle.classList.remove('bi-eye');
                toggle.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                toggle.classList.remove('bi-eye-slash');
                toggle.classList.add('bi-eye');
            }
        }

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');

            let strength = 0;
            let text = 'Faible';

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            strengthFill.className = 'strength-fill';

            switch (strength) {
                case 0:
                case 1:
                    strengthFill.classList.add('strength-weak');
                    text = 'Faible';
                    break;
                case 2:
                    strengthFill.classList.add('strength-fair');
                    text = 'Moyen';
                    break;
                case 3:
                case 4:
                    strengthFill.classList.add('strength-good');
                    text = 'Bon';
                    break;
                case 5:
                    strengthFill.classList.add('strength-strong');
                    text = 'Fort';
                    break;
            }

            strengthText.textContent = text;
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;
            const matchIndicator = document.getElementById('password-match');

            if (confirmPassword.length > 0) {
                if (password === confirmPassword) {
                    matchIndicator.style.display = 'block';
                    matchIndicator.innerHTML =
                        '<small class="text-success"><i class="bi bi-check-circle me-1"></i>Les mots de passe correspondent</small>';
                } else {
                    matchIndicator.style.display = 'block';
                    matchIndicator.innerHTML =
                        '<small class="text-danger"><i class="bi bi-x-circle me-1"></i>Les mots de passe ne correspondent pas</small>';
                }
            } else {
                matchIndicator.style.display = 'none';
            }
        }

        // Animation des formes au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const shapes = document.querySelectorAll('.shape');
            shapes.forEach((shape, index) => {
                setTimeout(() => {
                    shape.style.opacity = '0.1';
                    shape.style.transform = 'translateY(0)';
                }, index * 500);
            });
        });
    </script>
@endsection
