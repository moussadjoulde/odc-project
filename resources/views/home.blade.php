@extends('layouts.app')

@section('content')
    <style>
        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100"><polygon fill="rgba(255,255,255,0.1)" points="0,0 1000,100 1000,0"/></svg>');
            color: white;
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to right bottom, transparent 49%, white 50%);
        }

        .filter-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 100px;
        }

        .product-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.4s ease;
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .product-image {
            height: 250px;
            background: linear-gradient(45deg, #f8f9fa, #e9ecef);
            position: relative;
            overflow: hidden;
        }

        .product-image::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60%;
            height: 60%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%);
            border-radius: 50%;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(102, 126, 234, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .btn-quick-view {
            background: white;
            color: #667eea;
            border: none;
            padding: 12px 24px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            transform: translateY(20px);
        }

        .product-card:hover .btn-quick-view {
            transform: translateY(0);
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 1.1rem;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: #667eea;
            margin-bottom: 1rem;
        }

        .product-price .old-price {
            color: #adb5bd;
            text-decoration: line-through;
            font-size: 0.9rem;
            margin-left: 0.5rem;
        }

        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .stars {
            color: #ffc107;
            margin-right: 0.5rem;
        }

        .rating-count {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 12px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .search-box {
            position: relative;
        }

        .search-box .form-control {
            border-radius: 25px;
            padding: 12px 50px 12px 20px;
            border: 2px solid rgba(102, 126, 234, 0.2);
            transition: all 0.3s ease;
        }

        .search-box .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .search-box .btn {
            position: absolute;
            right: 5px;
            top: 5px;
            border-radius: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }

        .category-btn {
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.2);
            color: #667eea;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
            width: 100%;
            text-align: left;
        }

        .category-btn:hover,
        .category-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: transparent;
            color: white;
            transform: translateX(5px);
        }

        .price-range {
            background: white;
            padding: 1.5rem;
            border-radius: 12px;
            border: 2px solid rgba(102, 126, 234, 0.1);
        }

        .pagination {
            justify-content: center;
        }

        .page-link {
            border: none;
            color: #667eea;
            font-weight: 600;
            padding: 12px 16px;
            margin: 0 4px;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .page-link:hover,
        .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .sort-dropdown .dropdown-toggle {
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.2);
            color: #667eea;
            border-radius: 12px;
            padding: 12px 20px;
            font-weight: 600;
        }

        .wishlist-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .wishlist-btn:hover {
            background: #ff6b6b;
            color: white;
            transform: scale(1.1);
        }

        .wishlist-btn.active i,
        .wishlist-btn:hover i {
            color: #dc3545;
        }

        .wishlist-btn.active i {
            animation: heartBeat 0.6s ease-in-out;
        }

        @keyframes heartBeat {
            0% {
                transform: scale(1);
            }

            14% {
                transform: scale(1.3);
            }

            28% {
                transform: scale(1);
            }

            42% {
                transform: scale(1.3);
            }

            70% {
                transform: scale(1);
            }
        }

        @media (max-width: 768px) {
            .filter-card {
                position: relative;
                top: 0;
                margin-bottom: 2rem;
            }

            .product-image {
                height: 200px;
            }
        }
    </style>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Découvrez Notre Boutique</h1>
                    <p class="lead mb-4">Une sélection premium de produits pour tous vos besoins. Qualité, style et
                        innovation réunis en un seul endroit.</p>
                    <div class="search-box mb-4" style="max-width: 500px;">
                        <input type="text" class="form-control" placeholder="Rechercher un produit...">
                        <button class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="position-relative">
                        <i class="bi bi-bag-heart display-1" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewire('product-filter')

    <!-- Section Newsletter -->
    <div class="container-fluid bg-light py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-3">Restez informé des dernières nouveautés</h3>
                    <p class="text-muted mb-0">Inscrivez-vous à notre newsletter et recevez nos meilleures offres
                        directement dans votre boîte mail.</p>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-lg" placeholder="Votre adresse email">
                        <button class="btn btn-primary btn-lg px-4" type="button">
                            <i class="bi bi-send me-2"></i>S'abonner
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes produits
            const productCards = document.querySelectorAll('.product-card');

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 100);
                    }
                });
            });

            productCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                card.style.transition = 'all 0.6s ease';
                observer.observe(card);
            });

            // Gestion des boutons catégories
            const categoryButtons = document.querySelectorAll('.category-btn');
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    categoryButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            // Gestion des favoris
            const wishlistButtons = document.querySelectorAll('.wishlist-btn');
            wishlistButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const icon = this.querySelector('i');
                    if (icon.classList.contains('bi-heart')) {
                        icon.classList.remove('bi-heart');
                        icon.classList.add('bi-heart-fill', 'text-danger');
                    } else {
                        icon.classList.remove('bi-heart-fill', 'text-danger');
                        icon.classList.add('bi-heart');
                    }
                });
            });
        });
    </script>
@endsection
