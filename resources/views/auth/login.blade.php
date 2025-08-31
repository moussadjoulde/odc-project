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

        .custom-checkbox {
            position: relative;
        }

        .custom-checkbox .form-check-input {
            width: 20px;
            height: 20px;
            border: 2px solid rgba(102, 126, 234, 0.3);
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .custom-checkbox .form-check-input:checked {
            background: var(--primary-gradient);
            border-color: transparent;
        }

        .custom-checkbox .form-check-label {
            font-weight: 500;
            color: #495057;
            margin-left: 0.5rem;
        }

        .alert-custom {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.2);
            border-radius: 12px;
            color: #dc3545;
            padding: 1rem;
            margin-bottom: 1.5rem;
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

        .btn-facebook {
            color: #4267B2;
            border-color: rgba(66, 103, 178, 0.2);
        }

        .btn-facebook:hover {
            background: #4267B2;
            color: white;
            border-color: #4267B2;
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
                <div class="col-lg-5 col-md-7">
                    <div class="auth-card">
                        <!-- Header -->
                        <div class="auth-header">
                            <div class="mb-3">
                                <i class="bi bi-person-circle display-4 text-primary"></i>
                            </div>
                            <h2 class="auth-title">Bienvenue !</h2>
                            <p class="auth-subtitle mb-0">Connectez-vous à votre compte</p>
                        </div>

                        <!-- Body -->
                        <div class="auth-body">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <!-- Email -->
                                <div class="form-floating">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus
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
                                        required autocomplete="current-password" placeholder="Password">
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
                                </div>

                                <!-- Remember Me -->
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <div class="custom-checkbox">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                                {{ old('remember') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="remember">
                                                {{ __('Se souvenir de moi') }}
                                            </label>
                                        </div>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a class="btn-link-custom" href="{{ route('password.request') }}">
                                            {{ __('Mot de passe oublié ?') }}
                                        </a>
                                    @endif
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-auth">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        {{ __('Se connecter') }}
                                    </button>
                                </div>
                            </form>

                            {{-- @foreach (['x', 'facebook', 'github', 'apple'] as $provider)
                                <a href="{{ route('oauth.redirect', $provider) }}"
                                    class="inline-flex items-center justify-center p-3 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200 hover:text-gray-800 dark:bg-white/5 dark:text-white/90 dark:hover:bg-white/10">
                                    <svg width="21" class="fill-current" height="20" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        @if ($provider == 'x')
                                            <path
                                                d="M15.6705 1.875H18.4272L12.4047 8.75833L19.4897 18.125H13.9422L9.59717 12.4442L4.62554 18.125H1.86721L8.30887 10.7625L1.51221 1.875H7.20054L11.128 7.0675L15.6705 1.875ZM14.703 16.475H16.2305L6.37054 3.43833H4.73137L14.703 16.475Z" />
                                        @elseif ($provider == 'facebook')
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M22 12.073C22 6.504 17.523 2 12 2S2 6.504 2 12.073c0 4.996 3.657 9.128 8.438 9.879v-6.987H7.898v-2.892h2.54V9.845c0-2.506 1.492-3.89 3.774-3.89 1.095 0 2.24.195 2.24.195v2.46h-1.262c-1.243 0-1.63.775-1.63 1.568v1.881h2.773l-.443 2.892h-2.33v6.987C18.343 21.201 22 17.07 22 12.073z" />
                                        @elseif ($provider == 'github')
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M12 0C5.37 0 0 5.37 0 12c0 5.302 3.438 9.8 8.207 11.387.6.111.82-.261.82-.577 0-.287-.01-1.046-.02-2.053-3.338.727-4.04-1.588-4.04-1.588-.546-1.384-1.333-1.757-1.333-1.757-.99-.676.074-.662.074-.662 1.095.078 1.672 1.129 1.672 1.129.975 1.674 2.561 1.188 3.18.91.099-.706.38-1.188.693-1.462-2.37-.269-4.844-1.185-4.844-5.29 0-1.167.417-2.122 1.104-2.869-.111-.269-.478-1.353.104-2.822 0 0 .91-.296 2.98 1.118.866-.24 1.793-.359 2.713-.363.92.004 1.848.122 2.713.363 2.068-1.414 2.979-1.118 2.979-1.118.583 1.469.215 2.553.104 2.822.687.747 1.104 1.702 1.104 2.869 0 4.111-2.475 5.018-4.85 5.286.395.343.742.999.742 1.997 0 1.443-.02 2.607-.02 2.964 0 .316.218.693.82.577C20.563 21.8 24 17.302 24 12c0-6.63-5.37-12-12-12z"
                                                fill="currentColor" />
                                        @elseif ($provider == 'apple')
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M16.3 3.6c-.8 1-1.9 1.7-3.2 1.7-.2-1.3.4-2.6 1.2-3.5C15.2.8 16.5 0 17.9 0c.2 1.4-.4 2.6-1.1 3.6-.2.2-.3.4-.5.5zm3.9 16c-.6 1.2-1.3 2.4-2.2 3.4-.8.9-1.5 1.2-2.4 1.2s-1.7-.4-2.6-.4-1.8.4-2.6.4-1.6-.3-2.4-1.2c-.9-1-1.6-2.2-2.2-3.4-1.5-2.6-2.2-4.6-2.3-6.5 0-2.2.8-4 2.2-5.1C6.2 6 7.8 5.6 9.2 6s2.3 1.2 2.8 1.3c.6-.1 1.6-.8 2.9-1.3 1.9-.7 3.5-.2 4.6.7-1.8 1.1-2.6 3-2.5 4.8.1 2.9 2.4 4.2 2.5 4.3z" />
                                        @endif
                                    </svg>
                                </a>
                            @endforeach --}}
                            <!-- Social Login -->
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
