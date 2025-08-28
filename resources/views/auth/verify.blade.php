@extends('layouts.app')

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
        max-width: 500px;
    }

    .auth-header {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
        padding: 3rem 2rem;
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

    .email-icon {
        width: 100px;
        height: 100px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        position: relative;
        z-index: 1;
        animation: pulse 2s infinite;
    }

    .email-icon i {
        font-size: 3rem;
        color: white;
    }

    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.4);
        }
        70% {
            box-shadow: 0 0 0 20px rgba(102, 126, 234, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
        }
    }

    .auth-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .auth-subtitle {
        color: #6c757d;
        font-weight: 500;
        position: relative;
        z-index: 1;
        line-height: 1.6;
    }

    .auth-body {
        padding: 2.5rem;
        text-align: center;
    }

    .success-alert {
        background: rgba(25, 135, 84, 0.1);
        border: 1px solid rgba(25, 135, 84, 0.2);
        border-radius: 12px;
        color: #198754;
        padding: 1rem;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        animation: slideDown 0.5s ease-out;
    }

    .success-alert i {
        font-size: 1.25rem;
        margin-right: 0.75rem;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .btn-auth {
        background: var(--primary-gradient);
        border: none;
        border-radius: 15px;
        padding: 15px 30px;
        font-weight: 600;
        font-size: 1rem;
        color: white;
        transition: all 0.4s ease;
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        position: relative;
        overflow: hidden;
        margin: 0.5rem;
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

    .btn-outline-custom {
        background: transparent;
        border: 2px solid rgba(102, 126, 234, 0.3);
        border-radius: 15px;
        padding: 13px 30px;
        font-weight: 600;
        font-size: 1rem;
        color: #667eea;
        transition: all 0.3s ease;
        margin: 0.5rem;
    }

    .btn-outline-custom:hover {
        background: rgba(102, 126, 234, 0.1);
        border-color: #667eea;
        color: #5a67d8;
        transform: translateY(-2px);
    }

    .countdown-timer {
        background: rgba(102, 126, 234, 0.1);
        border-radius: 12px;
        padding: 1rem;
        margin: 1.5rem 0;
        font-weight: 600;
        color: #667eea;
    }

    .countdown-number {
        font-size: 1.25rem;
        color: #5a67d8;
    }

    .email-illustration {
        margin: 2rem 0;
        position: relative;
    }

    .floating-envelope {
        display: inline-block;
        font-size: 4rem;
        color: rgba(102, 126, 234, 0.2);
        animation: floatEnvelope 3s ease-in-out infinite;
    }

    @keyframes floatEnvelope {
        0%, 100% {
            transform: translateY(0px) rotate(-5deg);
        }
        50% {
            transform: translateY(-15px) rotate(5deg);
        }
    }

    .steps-container {
        background: rgba(102, 126, 234, 0.05);
        border-radius: 15px;
        padding: 1.5rem;
        margin: 1.5rem 0;
        text-align: left;
    }

    .step-item {
        display: flex;
        align-items: center;
        margin-bottom: 1rem;
        opacity: 0;
        animation: fadeInUp 0.6s ease-out forwards;
    }

    .step-item:nth-child(1) { animation-delay: 0.2s; }
    .step-item:nth-child(2) { animation-delay: 0.4s; }
    .step-item:nth-child(3) { animation-delay: 0.6s; }

    .step-number {
        width: 30px;
        height: 30px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .step-text {
        color: #495057;
        font-weight: 500;
        line-height: 1.5;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
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
        right: 15%;
        animation-delay: 3s;
    }

    .shape:nth-child(3) {
        bottom: 20%;
        left: 20%;
        animation-delay: 1.5s;
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
            padding: 2rem 1.5rem;
        }
        
        .auth-title {
            font-size: 1.5rem;
        }

        .email-icon {
            width: 80px;
            height: 80px;
        }

        .email-icon i {
            font-size: 2.5rem;
        }
    }
</style>

<div class="auth-background d-flex align-items-center justify-content-center py-5">
    <!-- Formes flottantes -->
    <div class="floating-shapes">
        <div class="shape">
            <i class="bi bi-envelope" style="font-size: 3rem;"></i>
        </div>
        <div class="shape">
            <i class="bi bi-check-circle" style="font-size: 2.5rem;"></i>
        </div>
        <div class="shape">
            <i class="bi bi-shield-check" style="font-size: 2rem;"></i>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="auth-card mx-auto">
                    <!-- Header -->
                    <div class="auth-header">
                        <div class="email-icon">
                            <i class="bi bi-envelope-check"></i>
                        </div>
                        <h2 class="auth-title">Vérifiez votre email</h2>
                        <p class="auth-subtitle mb-0">
                            Un email de vérification a été envoyé à votre adresse email
                        </p>
                    </div>

                    <!-- Body -->
                    <div class="auth-body">
                        @if (session('resent'))
                            <div class="success-alert">
                                <i class="bi bi-check-circle-fill"></i>
                                <div>
                                    <strong>Email envoyé !</strong><br>
                                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                                </div>
                            </div>
                        @endif

                        <div class="email-illustration">
                            <i class="bi bi-envelope-heart floating-envelope"></i>
                        </div>

                        <p class="text-muted mb-4">
                            Avant de continuer, veuillez vérifier vos emails et cliquer sur le lien de vérification que nous venons de vous envoyer.
                        </p>

                        <div class="steps-container">
                            <h6 class="fw-bold mb-3 text-center">
                                <i class="bi bi-list-ol me-2"></i>Étapes à suivre
                            </h6>
                            <div class="step-item">
                                <div class="step-number">1</div>
                                <div class="step-text">Ouvrez votre boîte email</div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">2</div>
                                <div class="step-text">Recherchez un email de notre part (vérifiez aussi les spams)</div>
                            </div>
                            <div class="step-item">
                                <div class="step-number">3</div>
                                <div class="step-text">Cliquez sur le lien de vérification dans l'email</div>
                            </div>
                        </div>

                        <div class="text-muted mb-4">
                            <small>
                                <i class="bi bi-info-circle me-1"></i>
                                Si vous ne recevez pas l'email dans les prochaines minutes, vérifiez votre dossier spam ou demandez un nouveau lien.
                            </small>
                        </div>

                        <!-- Countdown Timer (optionnel) -->
                        <div class="countdown-timer" id="countdown-timer" style="display: none;">
                            <i class="bi bi-clock me-2"></i>
                            Vous pourrez demander un nouveau lien dans 
                            <span class="countdown-number" id="countdown">60</span> secondes
                        </div>

                        <!-- Actions -->
                        <div class="d-flex flex-column flex-sm-row justify-content-center">
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-auth" id="resend-btn">
                                    <i class="bi bi-arrow-clockwise me-2"></i>
                                    {{ __('Renvoyer l\'email') }}
                                </button>
                            </form>
                            
                            <a href="{{ route('login') }}" class="btn btn-outline-custom">
                                <i class="bi bi-arrow-left me-2"></i>
                                Retour à la connexion
                            </a>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <p class="text-muted mb-0">
                                <small>
                                    <i class="bi bi-shield-lock me-1"></i>
                                    Cette étape garantit la sécurité de votre compte
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation des formes au chargement
    const shapes = document.querySelectorAll('.shape');
    shapes.forEach((shape, index) => {
        setTimeout(() => {
            shape.style.opacity = '0.1';
            shape.style.transform = 'translateY(0)';
        }, index * 500);
    });

    // Countdown timer après envoi d'un email
    @if (session('resent'))
        let countdown = 60;
        const countdownTimer = document.getElementById('countdown-timer');
        const countdownElement = document.getElementById('countdown');
        const resendBtn = document.getElementById('resend-btn');
        
        countdownTimer.style.display = 'block';
        resendBtn.disabled = true;
        resendBtn.style.opacity = '0.6';
        
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                countdownTimer.style.display = 'none';
                resendBtn.disabled = false;
                resendBtn.style.opacity = '1';
            }
        }, 1000);
    @endif

    // Animation de succès pour les alertes
    const successAlert = document.querySelector('.success-alert');
    if (successAlert) {
        setTimeout(() => {
            successAlert.style.transform = 'scale(1.02)';
            setTimeout(() => {
                successAlert.style.transform = 'scale(1)';
            }, 200);
        }, 500);
    }
});
</script>
@endsection