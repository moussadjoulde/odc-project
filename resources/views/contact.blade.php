@extends('layouts.app')

@section('title', 'Contactez-nous')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center position-relative">
                <h1 class="display-4 fw-bold mb-3">Contactez-nous</h1>
                <p class="lead mb-0">Nous sommes là pour vous aider. N'hésitez pas à nous contacter !</p>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Section principale -->
    <div class="row g-5">
        <!-- Formulaire de contact -->
        <div class="col-lg-8">
            <div class="floating-card p-4 p-md-5">
                <div class="mb-4">
                    <h2 class="h3 fw-bold mb-2">Envoyez-nous un message</h2>
                    <p class="text-muted">Remplissez le formulaire ci-dessous et nous vous répondrons dans les plus brefs délais.</p>
                </div>

                <form id="contactForm" method="POST" action="#a">
                    @csrf
                    <div class="row g-3">
                        <!-- Prénom et Nom -->
                        <div class="col-md-6">
                            <label for="first_name" class="form-label fw-semibold">
                                <i class="bi bi-person me-2 text-primary"></i>Prénom
                            </label>
                            <input type="text" class="form-control form-control-lg @error('first_name') is-invalid @enderror" 
                                   id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label fw-semibold">
                                <i class="bi bi-person me-2 text-primary"></i>Nom
                            </label>
                            <input type="text" class="form-control form-control-lg @error('last_name') is-invalid @enderror" 
                                   id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                            @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email et Téléphone -->
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">
                                <i class="bi bi-envelope me-2 text-primary"></i>Email
                            </label>
                            <input type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-semibold">
                                <i class="bi bi-telephone me-2 text-primary"></i>Téléphone
                            </label>
                            <input type="tel" class="form-control form-control-lg @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Sujet -->
                        <div class="col-12">
                            <label for="subject" class="form-label fw-semibold">
                                <i class="bi bi-chat-dots me-2 text-primary"></i>Sujet
                            </label>
                            <select class="form-select form-select-lg @error('subject') is-invalid @enderror" 
                                    id="subject" name="subject" required>
                                <option value="">Sélectionnez un sujet</option>
                                <option value="support" {{ old('subject') == 'support' ? 'selected' : '' }}>Support technique</option>
                                <option value="order" {{ old('subject') == 'order' ? 'selected' : '' }}>Question sur une commande</option>
                                <option value="product" {{ old('subject') == 'product' ? 'selected' : '' }}>Question sur un produit</option>
                                <option value="partnership" {{ old('subject') == 'partnership' ? 'selected' : '' }}>Partenariat</option>
                                <option value="other" {{ old('subject') == 'other' ? 'selected' : '' }}>Autre</option>
                            </select>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Message -->
                        <div class="col-12">
                            <label for="message" class="form-label fw-semibold">
                                <i class="bi bi-chat-left-text me-2 text-primary"></i>Message
                            </label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="6" required 
                                      placeholder="Décrivez votre demande en détail...">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bouton d'envoi -->
                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-modern btn-lg">
                                <i class="bi bi-send me-2"></i>Envoyer le message
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="col-lg-4">
            <!-- Coordonnées -->
            <div class="floating-card p-4 mb-4">
                <h3 class="h5 fw-bold mb-3">
                    <i class="bi bi-geo-alt text-primary me-2"></i>Nos coordonnées
                </h3>
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-start">
                        <i class="bi bi-building text-primary me-3 mt-1"></i>
                        <div>
                            <strong>Adresse</strong><br>
                            <span class="text-muted">123 Rue du Commerce<br>75001 Paris, France</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone text-primary me-3"></i>
                        <div>
                            <strong>Téléphone</strong><br>
                            <a href="tel:+33123456789" class="text-decoration-none">+33 1 23 45 67 89</a>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-envelope text-primary me-3"></i>
                        <div>
                            <strong>Email</strong><br>
                            <a href="mailto:contact@monstore.com" class="text-decoration-none">contact@monstore.com</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Horaires -->
            <div class="floating-card p-4 mb-4">
                <h3 class="h5 fw-bold mb-3">
                    <i class="bi bi-clock text-primary me-2"></i>Horaires d'ouverture
                </h3>
                <div class="d-flex flex-column gap-2">
                    <div class="d-flex justify-content-between">
                        <span>Lundi - Vendredi</span>
                        <span class="text-muted">9h00 - 18h00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Samedi</span>
                        <span class="text-muted">10h00 - 17h00</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Dimanche</span>
                        <span class="text-muted">Fermé</span>
                    </div>
                </div>
            </div>

            <!-- Réseaux sociaux -->
            <div class="floating-card p-4">
                <h3 class="h5 fw-bold mb-3">
                    <i class="bi bi-share text-primary me-2"></i>Suivez-nous
                </h3>
                <div class="d-flex gap-3">
                    <a href="#" class="btn btn-outline-primary btn-social rounded-circle" title="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-social rounded-circle" title="Twitter">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-social rounded-circle" title="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-primary btn-social rounded-circle" title="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="floating-card p-4 p-md-5">
                <div class="text-center mb-5">
                    <h2 class="h3 fw-bold mb-2">Questions fréquentes</h2>
                    <p class="text-muted">Trouvez rapidement des réponses aux questions les plus posées</p>
                </div>

                <div class="accordion" id="faqAccordion">
                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                <i class="bi bi-question-circle text-primary me-2"></i>
                                Comment puis-je suivre ma commande ?
                            </button>
                        </h2>
                        <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Vous pouvez suivre votre commande en utilisant le numéro de suivi qui vous a été envoyé par email après validation de votre commande.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                <i class="bi bi-question-circle text-primary me-2"></i>
                                Quels sont les délais de livraison ?
                            </button>
                        </h2>
                        <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Les délais de livraison varient entre 2 à 5 jours ouvrés selon votre localisation et le mode de livraison choisi.
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item border-0 mb-3 rounded-3 overflow-hidden shadow-sm">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                <i class="bi bi-question-circle text-primary me-2"></i>
                                Comment retourner un produit ?
                            </button>
                        </h2>
                        <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                Vous disposez de 30 jours pour retourner un produit. Contactez notre service client pour obtenir une étiquette de retour gratuite.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .form-label {
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .btn-social {
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .btn-social:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
    }

    .accordion-button {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
        border: none;
        border-radius: 12px !important;
    }

    .accordion-button:not(.collapsed) {
        background: var(--primary-gradient);
        color: white;
        box-shadow: none;
    }

    .accordion-button:not(.collapsed) i {
        color: white !important;
    }

    .accordion-button:focus {
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .accordion-body {
        background: #fff;
        border-radius: 0 0 12px 12px;
    }

    @media (max-width: 768px) {
        .floating-card {
            margin-bottom: 2rem;
        }
        
        .page-header {
            padding: 2rem 0;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validation du formulaire
    const form = document.getElementById('contactForm');
    
    form.addEventListener('submit', function(e) {
        // Validation basique côté client
        const requiredFields = form.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                isValid = false;
                field.classList.add('is-invalid');
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Validation email
        const emailField = document.getElementById('email');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailField.value)) {
            isValid = false;
            emailField.classList.add('is-invalid');
        }
        
        if (!isValid) {
            e.preventDefault();
            showToast('error', 'Veuillez remplir tous les champs obligatoires correctement.');
        }
    });
    
    // Animation des cartes au scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.floating-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
});
</script>
@endsection