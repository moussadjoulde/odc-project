@extends('layouts.app')

@section('title', 'À propos de nous')

@section('content')
<!-- Hero Section -->
<div class="page-header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="position-relative">
                    <h1 class="display-3 fw-bold mb-4">Notre Histoire</h1>
                    <p class="lead mb-4">Depuis 2018, nous révolutionnons l'expérience shopping en ligne avec passion, innovation et un service client d'exception.</p>
                    <div class="d-flex gap-3">
                        <div class="text-center">
                            <div class="h2 fw-bold mb-0">50K+</div>
                            <small class="opacity-75">Clients satisfaits</small>
                        </div>
                        <div class="text-center">
                            <div class="h2 fw-bold mb-0">15K+</div>
                            <small class="opacity-75">Produits vendus</small>
                        </div>
                        <div class="text-center">
                            <div class="h2 fw-bold mb-0">99%</div>
                            <small class="opacity-75">Satisfaction client</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image position-relative">
                    <div class="floating-shape"></div>
                    <div class="hero-card floating-card p-4 text-center">
                        <i class="bi bi-heart-fill text-danger display-4 mb-3"></i>
                        <h5 class="fw-bold-passion">Passion du E-commerce</h5>
                        <p class="text-muted mb-0">Nous créons des expériences shopping inoubliables</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container py-5">
    <!-- Notre Mission -->
    <section class="mb-5">
        <div class="row align-items-center g-5">
            <div class="col-lg-6">
                <div class="floating-card p-5 h-100">
                    <div class="mission-icon mb-4">
                        <i class="bi bi-bullseye display-4 text-primary"></i>
                    </div>
                    <h2 class="h3 fw-bold mb-3">Notre Mission</h2>
                    <p class="text-muted mb-4">
                        Rendre le shopping en ligne accessible, agréable et sécurisé pour tous. Nous nous engageons à proposer des produits de qualité au meilleur prix, avec un service client irréprochable.
                    </p>
                    <ul class="list-unstyled">
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill text-success me-3"></i>
                            <span>Qualité garantie sur tous nos produits</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i class="bi bi-check-circle-fill text-success me-3"></i>
                            <span>Livraison rapide et sécurisée</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="bi bi-check-circle-fill text-success me-3"></i>
                            <span>Support client 24/7</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="floating-card p-5 h-100">
                    <div class="vision-icon mb-4">
                        <i class="bi bi-lightbulb display-4 text-warning"></i>
                    </div>
                    <h2 class="h3 fw-bold mb-3">Notre Vision</h2>
                    <p class="text-muted mb-4">
                        Devenir la référence du e-commerce en France, reconnue pour son innovation, sa fiabilité et son engagement envers la satisfaction client.
                    </p>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="stat-card text-center p-3 rounded-3">
                                <div class="h4 fw-bold text-primary mb-1">6 ans</div>
                                <small class="text-muted">D'expérience</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-card text-center p-3 rounded-3">
                                <div class="h4 fw-bold text-primary mb-1">25+</div>
                                <small class="text-muted">Employés</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nos Valeurs -->
    <section class="mb-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Nos Valeurs</h2>
            <p class="lead text-muted">Les principes qui guident chacune de nos actions</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="floating-card p-4 text-center h-100 value-card">
                    <div class="value-icon mb-3">
                        <i class="bi bi-shield-check display-4 text-primary"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Confiance</h4>
                    <p class="text-muted">
                        La transparence et la fiabilité sont au cœur de notre relation avec nos clients. Chaque produit est soigneusement sélectionné.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="floating-card p-4 text-center h-100 value-card">
                    <div class="value-icon mb-3">
                        <i class="bi bi-lightning display-4 text-warning"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Innovation</h4>
                    <p class="text-muted">
                        Nous investissons constamment dans les dernières technologies pour améliorer votre expérience shopping.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="floating-card p-4 text-center h-100 value-card">
                    <div class="value-icon mb-3">
                        <i class="bi bi-people display-4 text-success"></i>
                    </div>
                    <h4 class="fw-bold mb-3">Proximité</h4>
                    <p class="text-muted">
                        Notre équipe est toujours à votre écoute. Nous construisons des relations durables avec nos clients.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Notre Équipe -->
    <section class="mb-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Notre Équipe</h2>
            <p class="lead text-muted">Les visages derrière votre expérience exceptionnelle</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <div class="floating-card p-4 text-center team-card">
                    <div class="team-avatar mb-3">
                        <div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill display-4 text-primary"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">DIALLO Moussa Djouldé</h5>
                    <p class="text-primary mb-2">Développeur full-stack, Designer</p>
                    <p class="text-muted small mb-3">Passionnée par l'innovation et l'expérience client depuis plus de 4 ans.</p>
                    <div class="social-links">
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle me-1">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-outline-primary btn-sm rounded-circle">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="floating-card p-4 text-center team-card">
                    <div class="team-avatar mb-3">
                        <div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill display-4 text-success"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">BAH Abdoulaye</h5>
                    <p class="text-success mb-2">Développeur full-stack</p>
                    <p class="text-muted small mb-3">Expert en développement web, il pilote nos innovations technologiques.</p>
                    <div class="social-links">
                        <a href="#" class="btn btn-outline-success btn-sm rounded-circle me-1">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-outline-success btn-sm rounded-circle">
                            <i class="bi bi-github"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="floating-card p-4 text-center team-card">
                    <div class="team-avatar mb-3">
                        <div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill display-4 text-warning"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">DIALLO Mamadou Oury</h5>
                    <p class="text-warning mb-2">Responsable Marketing</p>
                    <p class="text-muted small mb-3">Il crée des campagnes créatives qui connectent nos produits à vos besoins.</p>
                    <div class="social-links">
                        <a href="#" class="btn btn-outline-warning btn-sm rounded-circle me-1">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-outline-warning btn-sm rounded-circle">
                            <i class="bi bi-instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="floating-card p-4 text-center team-card">
                    <div class="team-avatar mb-3">
                        <div class="avatar-placeholder rounded-circle mx-auto d-flex align-items-center justify-content-center">
                            <i class="bi bi-person-fill display-4 text-danger"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold mb-1">DIALLO Boubacar Chérif</h5>
                    <p class="text-danger mb-2">Service Client</p>
                    <p class="text-muted small mb-3">Votre satisfaction est sa priorité. Il résout vos questions avec le sourire.</p>
                    <div class="social-links">
                        <a href="#" class="btn btn-outline-danger btn-sm rounded-circle me-1">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-outline-danger btn-sm rounded-circle">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Timeline -->
    <section class="mb-5">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold mb-3">Notre Parcours</h2>
            <p class="lead text-muted">Les étapes clés de notre développement</p>
        </div>
        
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-marker">
                    <i class="bi bi-rocket-takeoff"></i>
                </div>
                <div class="timeline-content floating-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Création de l'entreprise</h5>
                        <span class="badge bg-primary">2018</span>
                    </div>
                    <p class="text-muted mb-0">Lancement avec une équipe de 3 personnes et un catalogue de 100 produits.</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-marker">
                    <i class="bi bi-graph-up-arrow"></i>
                </div>
                <div class="timeline-content floating-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Première expansion</h5>
                        <span class="badge bg-success">2020</span>
                    </div>
                    <p class="text-muted mb-0">Atteinte des 10 000 clients et agrandissement de l'équipe à 15 personnes.</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-marker">
                    <i class="bi bi-award"></i>
                </div>
                <div class="timeline-content floating-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">Prix "Meilleur E-commerce"</h5>
                        <span class="badge bg-warning">2022</span>
                    </div>
                    <p class="text-muted mb-0">Reconnaissance de l'excellence de notre service client et de notre innovation.</p>
                </div>
            </div>
            
            <div class="timeline-item">
                <div class="timeline-marker">
                    <i class="bi bi-stars"></i>
                </div>
                <div class="timeline-content floating-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="fw-bold mb-0">50 000 clients satisfaits</h5>
                        <span class="badge bg-info">2024</span>
                    </div>
                    <p class="text-muted mb-0">Franchissement du cap des 50K clients avec 99% de satisfaction.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="text-center">
        <div class="floating-card p-5">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto">
                    <i class="bi bi-heart-fill text-danger display-4 mb-3"></i>
                    <h2 class="fw-bold mb-3">Rejoignez notre communauté</h2>
                    <p class="lead text-muted mb-4">
                        Découvrez pourquoi plus de 50 000 clients nous font confiance pour leurs achats en ligne.
                    </p>
                    <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                        <a href="{{ route('products.index') }}" class="btn btn-modern btn-lg">
                            <i class="bi bi-shop me-2"></i>Découvrir nos produits
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg">
                            <i class="bi bi-chat-dots me-2"></i>Nous contacter
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    .hero-image {
        position: relative;
        height: 100%;
        min-height: 300px;
    }

    .floating-shape {
        position: absolute;
        top: 20%;
        right: 10%;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        animation: float 6s ease-in-out infinite;
    }

    .fw-bold-passion {
        color : #ff6b6b;
    }

    .hero-card {
        position: relative;
        z-index: 2;
        max-width: 300px;
        margin: 2rem auto;
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
    }

    .value-card {
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .value-card:hover {
        border-color: var(--bs-primary);
        transform: translateY(-10px) scale(1.02);
    }

    .value-icon {
        transition: all 0.3s ease;
    }

    .value-card:hover .value-icon i {
        transform: scale(1.2);
    }

    .team-card {
        transition: all 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-15px);
    }

    .avatar-placeholder {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
        border: 3px solid #e9ecef;
    }

    .stat-card {
        background: linear-gradient(135deg, #f8f9ff 0%, #e8ebff 100%);
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.15);
    }

    .timeline {
        position: relative;
        padding: 2rem 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        bottom: 0;
        width: 2px;
        background: linear-gradient(to bottom, #667eea, #764ba2);
        transform: translateX(-50%);
    }

    .timeline-item {
        position: relative;
        margin-bottom: 3rem;
        display: flex;
        align-items: center;
    }

    .timeline-item:nth-child(odd) .timeline-content {
        margin-right: calc(50% + 40px);
        text-align: right;
    }

    .timeline-item:nth-child(even) .timeline-content {
        margin-left: calc(50% + 40px);
    }

    .timeline-marker {
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        width: 50px;
        height: 50px;
        background: var(--primary-gradient);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.2rem;
        z-index: 2;
        box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
    }

    .timeline-content {
        flex: 1;
        max-width: 400px;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }

    @media (max-width: 768px) {
        .timeline::before {
            left: 30px;
        }

        .timeline-marker {
            left: 30px;
        }

        .timeline-item:nth-child(odd) .timeline-content,
        .timeline-item:nth-child(even) .timeline-content {
            margin-left: 80px;
            margin-right: 0;
            text-align: left;
        }

        .hero-card {
            margin: 1rem auto;
        }

        .page-header {
            padding: 2rem 0;
        }

        .display-3 {
            font-size: 2.5rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    
    // Observer pour les cartes
    document.querySelectorAll('.floating-card, .value-card, .team-card').forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
    
    // Animation spéciale pour la timeline
    const timelineObserver = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }, index * 200);
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.timeline-item').forEach(item => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-50px)';
        item.style.transition = 'all 0.6s ease';
        timelineObserver.observe(item);
    });
    
    // Compteurs animés
    function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
            current += increment;
            if (current >= target) {
                element.textContent = target.toString().includes('K') ? target : target + '%';
                clearInterval(timer);
            } else {
                const value = Math.floor(current);
                element.textContent = target.toString().includes('K') ? 
                    (value / 1000).toFixed(0) + 'K+' : 
                    value + (target.toString().includes('%') ? '%' : '');
            }
        }, 50);
    }
    
    // Observer pour les statistiques
    const statsObserver = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const text = entry.target.textContent;
                if (text.includes('50K')) {
                    animateCounter(entry.target, 50000);
                } else if (text.includes('15K')) {
                    animateCounter(entry.target, 15000);
                } else if (text.includes('99%')) {
                    animateCounter(entry.target, 99);
                }
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    document.querySelectorAll('.page-header .h2').forEach(stat => {
        statsObserver.observe(stat);
    });
});
</script>
@endsection