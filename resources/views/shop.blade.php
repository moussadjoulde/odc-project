@extends('layouts.app')

@section('title', 'Shop')

@section('content')
    <style>
        .hero-section {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.9) 0%, rgba(118, 75, 162, 0.9) 100%),
                url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100"><polygon fill="rgba(255,255,255,0.1)" points="0,0 1000,100 1000,0"/></svg>');
            color: white;
            padding: 3rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 80px;
            background: linear-gradient(to right bottom, transparent 49%, white 50%);
        }

        .filter-sidebar {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 120px;
            padding: 2rem;
            height: fit-content;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .product-card {
            background: white;
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            position: relative;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-15px) scale(1.03);
            box-shadow: 0 25px 50px rgba(102, 126, 234, 0.2);
        }

        .product-image {
            height: 280px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.1);
        }

        .product-placeholder {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.2) 0%, rgba(118, 75, 162, 0.2) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: #667eea;
        }

        .product-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            color: white;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            z-index: 3;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.95) 0%, rgba(118, 75, 162, 0.95) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.4s ease;
            backdrop-filter: blur(5px);
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .overlay-buttons {
            display: flex;
            gap: 1rem;
            transform: translateY(30px);
            transition: transform 0.4s ease;
        }

        .product-card:hover .overlay-buttons {
            transform: translateY(0);
        }

        .btn-overlay {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            padding: 12px 16px;
            border-radius: 50%;
            transition: all 0.3s ease;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-overlay:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
            color: white;
        }

        .product-info {
            padding: 1.8rem;
        }

        .product-category {
            color: #667eea;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 0.5rem;
        }

        .product-title {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0.8rem;
            font-size: 1.2rem;
            line-height: 1.4;
        }

        .product-description {
            color: #6c757d;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .product-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: #667eea;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .old-price {
            color: #adb5bd;
            text-decoration: line-through;
            font-size: 1rem;
            font-weight: 500;
        }

        .discount-badge {
            background: linear-gradient(135deg, #10ac84 0%, #1dd1a1 100%);
            color: white;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 0.7rem;
            font-weight: 600;
        }

        .product-rating {
            display: flex;
            align-items: center;
            margin-bottom: 1.2rem;
        }

        .stars {
            color: #ffc107;
            margin-right: 0.8rem;
        }

        .rating-count {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            padding: 14px 24px;
            border-radius: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .btn-add-cart::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-add-cart:hover::before {
            left: 100%;
        }

        .btn-add-cart:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .wishlist-btn {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            z-index: 3;
        }

        .wishlist-btn:hover {
            background: #ff6b6b;
            color: white;
            transform: scale(1.15);
        }

        .search-filter-bar {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            padding: 2rem;
            margin-bottom: 3rem;
        }

        .search-box {
            position: relative;
            flex: 1;
        }

        .search-box .form-control {
            border-radius: 15px;
            padding: 16px 60px 16px 24px;
            border: 2px solid rgba(102, 126, 234, 0.15);
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .search-box .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .search-box .btn {
            position: absolute;
            right: 8px;
            top: 8px;
            border-radius: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 16px;
        }

        .filter-section {
            margin-bottom: 2rem;
        }

        .filter-title {
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .category-btn {
            background: transparent;
            border: 2px solid rgba(102, 126, 234, 0.15);
            color: #667eea;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 0.8rem;
            width: 100%;
            text-align: left;
            position: relative;
            overflow: hidden;
        }

        .category-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: left 0.3s ease;
            z-index: -1;
        }

        .category-btn:hover::before,
        .category-btn.active::before {
            left: 0;
        }

        .category-btn:hover,
        .category-btn.active {
            border-color: transparent;
            color: white;
            transform: translateX(8px);
        }

        .price-range-container {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            padding: 1.5rem;
            border-radius: 15px;
            border: 2px solid rgba(102, 126, 234, 0.1);
        }

        .sort-dropdown {
            min-width: 200px;
        }

        .sort-dropdown .dropdown-toggle {
            background: white;
            border: 2px solid rgba(102, 126, 234, 0.15);
            color: #667eea;
            border-radius: 12px;
            padding: 14px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .sort-dropdown .dropdown-toggle:hover {
            border-color: #667eea;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 4rem;
        }

        .pagination .page-link {
            border: none;
            color: #667eea;
            font-weight: 600;
            padding: 14px 18px;
            margin: 0 6px;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        .pagination .page-link:hover,
        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        }

        .results-info {
            color: #6c757d;
            font-weight: 500;
        }

        .animate-fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.6s ease forwards;
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .filter-sidebar {
                position: relative;
                top: 0;
                margin-bottom: 2rem;
                padding: 1.5rem;
            }

            .product-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .product-image {
                height: 220px;
            }

            .search-filter-bar {
                padding: 1.5rem;
            }

            .hero-section {
                padding: 2rem 0;
            }
        }
    </style>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Notre Boutique</h1>
                    <p class="lead mb-0">Découvrez notre collection soigneusement sélectionnée de produits premium. 
                        Qualité garantie, livraison rapide et service client exceptionnel.</p>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="position-relative">
                        <i class="bi bi-shop display-1" style="opacity: 0.3;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">
        <!-- Barre de recherche et filtres -->
        <div class="search-filter-bar">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Rechercher un produit, une marque...">
                        <button class="btn btn-primary">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="sort-dropdown">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                                <i class="bi bi-funnel me-2"></i>Trier par
                            </button>
                            <ul class="dropdown-menu w-100">
                                <li><a class="dropdown-item" href="#">Prix croissant</a></li>
                                <li><a class="dropdown-item" href="#">Prix décroissant</a></li>
                                <li><a class="dropdown-item" href="#">Popularité</a></li>
                                <li><a class="dropdown-item" href="#">Nouveautés</a></li>
                                <li><a class="dropdown-item" href="#">Meilleures notes</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="results-info text-end">
                        <span>124 produits trouvés</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Sidebar Filtres -->
            <div class="col-lg-3">
                <div class="filter-sidebar">
                    <!-- Catégories -->
                    <div class="filter-section">
                        <h5 class="filter-title">
                            <i class="bi bi-grid-3x3-gap me-2"></i>Catégories
                        </h5>
                        <button class="category-btn active">
                            <i class="bi bi-stars me-2"></i>Tous les produits
                        </button>
                        <button class="category-btn">
                            <i class="bi bi-laptop me-2"></i>Électronique
                        </button>
                        <button class="category-btn">
                            <i class="bi bi-palette me-2"></i>Mode & Beauté
                        </button>
                        <button class="category-btn">
                            <i class="bi bi-house me-2"></i>Maison & Jardin
                        </button>
                        <button class="category-btn">
                            <i class="bi bi-controller me-2"></i>Sport & Loisirs
                        </button>
                        <button class="category-btn">
                            <i class="bi bi-book me-2"></i>Livres & Culture
                        </button>
                    </div>

                    <!-- Gamme de prix -->
                    <div class="filter-section">
                        <h5 class="filter-title">
                            <i class="bi bi-currency-euro me-2"></i>Prix
                        </h5>
                        <div class="price-range-container">
                            <div class="mb-3">
                                <label class="form-label">Prix minimum</label>
                                <input type="range" class="form-range" min="0" max="1000" value="0">
                                <div class="d-flex justify-content-between">
                                    <span>0€</span>
                                    <span>1000€</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Marques -->
                    <div class="filter-section">
                        <h5 class="filter-title">
                            <i class="bi bi-award me-2"></i>Marques
                        </h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="brand1">
                            <label class="form-check-label" for="brand1">Apple</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="brand2">
                            <label class="form-check-label" for="brand2">Samsung</label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="checkbox" id="brand3">
                            <label class="form-check-label" for="brand3">Nike</label>
                        </div>
                    </div>

                    <!-- Note -->
                    <div class="filter-section">
                        <h5 class="filter-title">
                            <i class="bi bi-star me-2"></i>Note minimum
                        </h5>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="rating" id="rating5">
                            <label class="form-check-label" for="rating5">
                                <span class="stars">★★★★★</span>
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="rating" id="rating4">
                            <label class="form-check-label" for="rating4">
                                <span class="stars">★★★★☆</span> et plus
                            </label>
                        </div>
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="rating" id="rating3">
                            <label class="form-check-label" for="rating3">
                                <span class="stars">★★★☆☆</span> et plus
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grille de produits -->
            <div class="col-lg-9">
                <div class="product-grid">
                    <!-- Produit 1 -->
                    <div class="product-card animate-fade-in">
                        <div class="product-image">
                            <div class="product-placeholder">
                                <i class="bi bi-laptop"></i>
                            </div>
                            <button class="wishlist-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                            <div class="product-badge">-25%</div>
                            <div class="product-overlay">
                                <div class="overlay-buttons">
                                    <button class="btn-overlay" title="Aperçu rapide">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-overlay" title="Ajouter au panier">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                    <button class="btn-overlay" title="Comparer">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Photo</div>
                            <h5 class="product-title">Canon EOS R6 Mark II</h5>
                            <p class="product-description">Appareil photo hybride plein format avec autofocus intelligent et stabilisation 8 stops.</p>
                            <div class="product-price">
                                2399€ 
                                <span class="old-price">2799€</span>
                                <span class="discount-badge">-15%</span>
                            </div>
                            <div class="product-rating">
                                <div class="stars">★★★★★</div>
                                <span class="rating-count">(78 avis)</span>
                            </div>
                            <button class="btn-add-cart">
                                <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                            </button>
                        </div>
                    </div>

                    <!-- Produit 6 -->
                    <div class="product-card animate-fade-in">
                        <div class="product-image">
                            <div class="product-placeholder">
                                <i class="bi bi-tablet"></i>
                            </div>
                            <button class="wishlist-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                            <div class="product-overlay">
                                <div class="overlay-buttons">
                                    <button class="btn-overlay" title="Aperçu rapide">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-overlay" title="Ajouter au panier">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                    <button class="btn-overlay" title="Comparer">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Tablettes</div>
                            <h5 class="product-title">iPad Pro 12.9" M2</h5>
                            <p class="product-description">Tablette professionnelle avec écran Liquid Retina XDR et puce M2 ultra-rapide.</p>
                            <div class="product-price">1449€</div>
                            <div class="product-rating">
                                <div class="stars">★★★★☆</div>
                                <span class="rating-count">(156 avis)</span>
                            </div>
                            <button class="btn-add-cart">
                                <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                            </button>
                        </div>
                    </div>

                    <!-- Produit 7 -->
                    <div class="product-card animate-fade-in">
                        <div class="product-image">
                            <div class="product-placeholder">
                                <i class="bi bi-speaker"></i>
                            </div>
                            <button class="wishlist-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                            <div class="product-badge">Promo</div>
                            <div class="product-overlay">
                                <div class="overlay-buttons">
                                    <button class="btn-overlay" title="Aperçu rapide">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-overlay" title="Ajouter au panier">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                    <button class="btn-overlay" title="Comparer">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Audio</div>
                            <h5 class="product-title">HomePod 2ème génération</h5>
                            <p class="product-description">Enceinte intelligente avec son immersif et assistant vocal Siri intégré.</p>
                            <div class="product-price">349€</div>
                            <div class="product-rating">
                                <div class="stars">★★★★☆</div>
                                <span class="rating-count">(94 avis)</span>
                            </div>
                            <button class="btn-add-cart">
                                <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                            </button>
                        </div>
                    </div>

                    <!-- Produit 8 -->
                    <div class="product-card animate-fade-in">
                        <div class="product-image">
                            <div class="product-placeholder">
                                <i class="bi bi-keyboard"></i>
                            </div>
                            <button class="wishlist-btn">
                                <i class="bi bi-heart"></i>
                            </button>
                            <div class="product-overlay">
                                <div class="overlay-buttons">
                                    <button class="btn-overlay" title="Aperçu rapide">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-overlay" title="Ajouter au panier">
                                        <i class="bi bi-cart-plus"></i>
                                    </button>
                                    <button class="btn-overlay" title="Comparer">
                                        <i class="bi bi-arrow-left-right"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="product-info">
                            <div class="product-category">Accessoires</div>
                            <h5 class="product-title">Magic Keyboard pour iPad Pro</h5>
                            <p class="product-description">Clavier avec trackpad intégré, rétroéclairage et port USB-C pour charge directe.</p>
                            <div class="product-price">399€</div>
                            <div class="product-rating">
                                <div class="stars">★★★★★</div>
                                <span class="rating-count">(201 avis)</span>
                            </div>
                            <button class="btn-add-cart">
                                <i class="bi bi-cart-plus me-2"></i>Ajouter au panier
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="pagination-container">
                    <nav aria-label="Navigation des produits">
                        <ul class="pagination">
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="bi bi-chevron-left"></i>
                                </span>
                            </li>
                            <li class="page-item active">
                                <span class="page-link">1</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">2</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">3</a>
                            </li>
                            <li class="page-item">
                                <span class="page-link">...</span>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">12</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <!-- Section Newsletter -->
    <div class="container-fluid bg-light py-5 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-3">
                        <i class="bi bi-envelope-heart me-2"></i>
                        Ne manquez aucune promotion
                    </h3>
                    <p class="text-muted mb-0">Inscrivez-vous à notre newsletter et recevez en exclusivité nos meilleures 
                        offres, nouveautés et conseils d'experts directement dans votre boîte mail.</p>
                </div>
                <div class="col-lg-6">
                    <div class="input-group">
                        <input type="email" class="form-control form-control-lg" placeholder="Votre adresse email">
                        <button class="btn btn-primary btn-lg px-4" type="button">
                            <i class="bi bi-send me-2"></i>S'abonner
                        </button>
                    </div>
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-shield-check me-1"></i>
                        Vos données sont protégées et ne seront jamais partagées
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animation des cartes produits avec Intersection Observer
            const productCards = document.querySelectorAll('.product-card');
            
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.style.opacity = '1';
                            entry.target.style.transform = 'translateY(0)';
                        }, index * 150);
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            productCards.forEach(card => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(50px)';
                card.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
                observer.observe(card);
            });

            // Gestion des boutons catégories
            const categoryButtons = document.querySelectorAll('.category-btn');
            categoryButtons.forEach(button => {
                button.addEventListener('click', function() {
                    categoryButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Animation de feedback
                    this.style.transform = 'translateX(8px) scale(0.98)';
                    setTimeout(() => {
                        this.style.transform = 'translateX(8px) scale(1)';
                    }, 150);
                });
            });

            // Gestion des favoris avec animation
            const wishlistButtons = document.querySelectorAll('.wishlist-btn');
            wishlistButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    e.preventDefault();
                    
                    const icon = this.querySelector('i');
                    
                    // Animation de pulsation
                    this.style.transform = 'scale(1.3)';
                    
                    setTimeout(() => {
                        if (icon.classList.contains('bi-heart')) {
                            icon.classList.remove('bi-heart');
                            icon.classList.add('bi-heart-fill');
                            this.style.background = '#ff6b6b';
                            this.style.color = 'white';
                        } else {
                            icon.classList.remove('bi-heart-fill');
                            icon.classList.add('bi-heart');
                            this.style.background = 'rgba(255, 255, 255, 0.95)';
                            this.style.color = '#2c3e50';
                        }
                        
                        this.style.transform = 'scale(1)';
                    }, 200);
                });
            });

            // Gestion de la barre de recherche
            const searchInput = document.querySelector('.search-box .form-control');
            const searchButton = document.querySelector('.search-box .btn');
            
            searchInput.addEventListener('focus', function() {
                this.style.transform = 'scale(1.02)';
                this.style.boxShadow = '0 8px 25px rgba(102, 126, 234, 0.15)';
            });
            
            searchInput.addEventListener('blur', function() {
                this.style.transform = 'scale(1)';
                this.style.boxShadow = '';
            });

            // Gestion du range de prix
            const priceRange = document.querySelector('.form-range');
            if (priceRange) {
                priceRange.addEventListener('input', function() {
                    const value = this.value;
                    const max = this.max;
                    const percentage = (value / max) * 100;
                    
                    this.style.background = `linear-gradient(to right, #667eea 0%, #667eea ${percentage}%, #e9ecef ${percentage}%, #e9ecef 100%)`;
                });
            }

            // Animation des boutons "Ajouter au panier"
            const addToCartButtons = document.querySelectorAll('.btn-add-cart');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Animation de succès
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-check2 me-2"></i>Ajouté !';
                    this.style.background = 'linear-gradient(135deg, #10ac84 0%, #1dd1a1 100%)';
                    
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.background = 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
                    }, 2000);
                });
            });

            // Smooth scroll pour les liens d'ancrage
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Gestion responsive du sidebar
            function handleResponsive() {
                const sidebar = document.querySelector('.filter-sidebar');
                const windowWidth = window.innerWidth;
                
                if (windowWidth <= 768) {
                    sidebar.style.position = 'relative';
                    sidebar.style.top = '0';
                } else {
                    sidebar.style.position = 'sticky';
                    sidebar.style.top = '120px';
                }
            }

            window.addEventListener('resize', handleResponsive);
            handleResponsive(); // Appel initial

            // Lazy loading pour les images (si vous en ajoutez)
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy');
                                imageObserver.unobserve(img);
                            }
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
@endsection>