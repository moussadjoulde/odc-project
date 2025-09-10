@extends('layouts.product')

@section('title', 'Tableau de bord')

@section('content')
    <style>
        /* Styles personnalisés pour le dashboard */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
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
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            line-height: 1;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #718096;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
        }

        .stat-change {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .stat-change.positive { 
            color: #38a169; 
        }

        .stat-change.negative { 
            color: #e53e3e; 
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
        }

        .stat-icon.primary { 
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
        }

        .stat-icon.success { 
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%); 
        }

        .stat-icon.warning { 
            background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%); 
        }

        .stat-icon.info { 
            background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%); 
        }

        .page-header {
            position: relative;
            padding: 3rem 0;
            margin-bottom: 2rem;
            text-center;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            right: -100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 20px;
            z-index: -1;
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        .chart-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #f0f0f0;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .chart-card-header {
            padding: 1.5rem 2rem;
            border-bottom: 1px solid #e2e8f0;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .chart-card-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
            display: flex;
            align-items: center;
        }

        .chart-card-body {
            padding: 2rem;
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 350px;
            margin-bottom: 1rem;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: white;
        }

        .top-product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .top-product-item:last-child {
            border-bottom: none;
        }

        .product-avatar {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            margin-right: 1rem;
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
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .progress-modern {
            height: 8px;
            border-radius: 10px;
            background: #e2e8f0;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .progress-bar-modern {
            height: 100%;
            border-radius: 10px;
            transition: width 1.5s ease;
        }

        .animate-slide-in {
            animation: slideIn 0.6s ease-out forwards;
            opacity: 0;
            transform: translateY(30px);
        }

        .animate-slide-in:nth-child(1) { animation-delay: 0.1s; }
        .animate-slide-in:nth-child(2) { animation-delay: 0.2s; }
        .animate-slide-in:nth-child(3) { animation-delay: 0.3s; }
        .animate-slide-in:nth-child(4) { animation-delay: 0.4s; }

        @keyframes slideIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .stat-number {
                font-size: 2rem;
            }

            .page-header {
                padding: 2rem 0;
            }

            .chart-container {
                height: 250px;
            }
        }
    </style>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="float-animation mb-4">
                <i class="bi bi-graph-up" style="font-size: 4rem; color: #667eea;"></i>
            </div>
            <h1 class="display-4 fw-bold mb-3" style="color: #2d3748;">Tableau de bord</h1>
            <p class="lead" style="color: #718096;">Gérez votre boutique avec élégance et suivez vos performances en temps réel</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="container-fluid">
        <div class="row mb-5">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card animate-slide-in">
                    <div class="stat-icon primary">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <h3 class="stat-number">{{ $orders->count() }}</h3>
                    <p class="stat-label">Commandes totales</p>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up me-1"></i>
                        +12% ce mois
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card animate-slide-in">
                    <div class="stat-icon success">
                        <i class="bi bi-currency-euro"></i>
                    </div>
                    <h3 class="stat-number">€47,392</h3>
                    <p class="stat-label">Revenus</p>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up me-1"></i>
                        +8.5% ce mois
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card animate-slide-in">
                    <div class="stat-icon warning">
                        <i class="bi bi-people"></i>
                    </div>
                    <h3 class="stat-number">3</h3>
                    <p class="stat-label">Clients actifs</p>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up me-1"></i>
                        +15% ce mois
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4">
                <div class="stat-card animate-slide-in">
                    <div class="stat-icon info">
                        <i class="bi bi-box"></i>
                    </div>
                    <h3 class="stat-number">{{ $products->count() }}</h3>
                    <p class="stat-label">Produits</p>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up me-1"></i>
                        +3% ce mois
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="row">
            <div class="col-lg-8">
                <!-- Revenue Chart -->
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">
                            <i class="bi bi-graph-up me-2 text-primary"></i>
                            Évolution des revenus (6 derniers mois)
                        </h5>
                    </div>
                    <div class="chart-card-body">
                        <div class="chart-container">
                            <canvas id="revenueChart"></canvas>
                        </div>
                        <div class="row text-center mt-3">
                            <div class="col-4">
                                <h6 class="text-muted mb-1">Aujourd'hui</h6>
                                <h5 class="text-success mb-0">€1,247</h5>
                            </div>
                            <div class="col-4">
                                <h6 class="text-muted mb-1">Cette semaine</h6>
                                <h5 class="text-primary mb-0">€8,392</h5>
                            </div>
                            <div class="col-4">
                                <h6 class="text-muted mb-1">Ce mois</h6>
                                <h5 class="text-warning mb-0">€47,392</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sales by Category Chart -->
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">
                            <i class="bi bi-pie-chart me-2 text-success"></i>
                            Répartition des ventes par catégorie
                        </h5>
                    </div>
                    <div class="chart-card-body">
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Top Products -->
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">
                            <i class="bi bi-star me-2 text-warning"></i>
                            Top Produits
                        </h5>
                    </div>
                    <div class="chart-card-body">
                        <div class="top-product-item">
                            <div class="d-flex align-items-center">
                                <div class="product-avatar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                    IP
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">iPhone 15 Pro</h6>
                                    <small class="text-muted">Smartphones</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-1 fw-bold">47 ventes</h6>
                                <small class="text-success">+12%</small>
                            </div>
                        </div>

                        <div class="top-product-item">
                            <div class="d-flex align-items-center">
                                <div class="product-avatar" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                                    MB
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">MacBook Air M2</h6>
                                    <small class="text-muted">Ordinateurs</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-1 fw-bold">23 ventes</h6>
                                <small class="text-success">+8%</small>
                            </div>
                        </div>

                        <div class="top-product-item">
                            <div class="d-flex align-items-center">
                                <div class="product-avatar" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);">
                                    AP
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">AirPods Pro</h6>
                                    <small class="text-muted">Audio</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-1 fw-bold">19 ventes</h6>
                                <small class="text-danger">-3%</small>
                            </div>
                        </div>

                        <div class="top-product-item">
                            <div class="d-flex align-items-center">
                                <div class="product-avatar" style="background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);">
                                    IA
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold">iPad Air</h6>
                                    <small class="text-muted">Tablettes</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <h6 class="mb-1 fw-bold">15 ventes</h6>
                                <small class="text-success">+5%</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Feed -->
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">
                            <i class="bi bi-activity me-2 text-info"></i>
                            Activité récente
                        </h5>
                    </div>
                    <div class="chart-card-body">
                        <div class="activity-item">
                            <div class="activity-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                                <i class="bi bi-plus"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Nouveau produit ajouté</h6>
                                <p class="mb-1 text-muted">iPhone 15 Pro Max</p>
                                <small class="text-muted">Il y a 15 min</small>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon" style="background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);">
                                <i class="bi bi-cart-check"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Nouvelle commande</h6>
                                <p class="mb-1 text-muted">Commande #1247 - €129.90</p>
                                <small class="text-muted">Il y a 32 min</small>
                            </div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon" style="background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);">
                                <i class="bi bi-exclamation-triangle"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Stock faible</h6>
                                <p class="mb-1 text-muted">MacBook Air M2 - 3 restants</p>
                                <small class="text-muted">Il y a 1h</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h5 class="chart-card-title">
                            <i class="bi bi-speedometer me-2 text-danger"></i>
                            Performance en temps réel
                        </h5>
                    </div>
                    <div class="chart-card-body">
                        <div class="row text-center">
                            <div class="col-6 mb-3">
                                <div class="border-end pe-3">
                                    <h4 class="text-primary mb-1">23</h4>
                                    <small class="text-muted">Commandes aujourd'hui</small>
                                </div>
                            </div>
                            <div class="col-6 mb-3">
                                <div class="ps-3">
                                    <h4 class="text-success mb-1">€1,247</h4>
                                    <small class="text-muted">Revenus aujourd'hui</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="border-end pe-3">
                                    <h4 class="text-warning mb-1">12</h4>
                                    <small class="text-muted">Produits en rupture</small>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="ps-3">
                                    <h4 class="text-info mb-1">4.8</h4>
                                    <small class="text-muted">Note moyenne</small>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <h6 class="mb-3">Objectifs mensuels</h6>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small text-muted">Ventes</span>
                                    <span class="small fw-bold">78%</span>
                                </div>
                                <div class="progress-modern">
                                    <div class="progress-bar-modern" style="width: 78%; background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);"></div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small text-muted">Revenus</span>
                                    <span class="small fw-bold">65%</span>
                                </div>
                                <div class="progress-modern">
                                    <div class="progress-bar-modern" style="width: 65%; background: linear-gradient(135deg, #4299e1 0%, #3182ce 100%);"></div>
                                </div>
                            </div>

                            <div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="small text-muted">Clients</span>
                                    <span class="small fw-bold">89%</span>
                                </div>
                                <div class="progress-modern">
                                    <div class="progress-bar-modern" style="width: 89%; background: linear-gradient(135deg, #ed8936 0%, #dd6b20 100%);"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.0/chart.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuration globale des graphiques
            Chart.defaults.font.family = 'Inter';
            Chart.defaults.color = '#718096';
            
            // Graphique des revenus (Line Chart)
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            const revenueChart = new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: ['Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre'],
                    datasets: [{
                        label: 'Revenus (€)',
                        data: [28500, 32400, 31200, 35800, 42100, 47392],
                        borderColor: '#667eea',
                        backgroundColor: 'rgba(102, 126, 234, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#667eea',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0,0,0,0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return '€' + value.toLocaleString();
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    }
                }
            });

            // Graphique des ventes par catégorie (Doughnut Chart)
            const salesCtx = document.getElementById('salesChart').getContext('2d');
            const salesChart = new Chart(salesCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Smartphones', 'Ordinateurs', 'Tablettes', 'Audio', 'Accessoires'],
                    datasets: [{
                        data: [35, 25, 15, 15, 10],
                        backgroundColor: [
                            '#667eea',
                            '#48bb78',
                            '#4299e1',
                            '#ed8936',
                            '#f56565'
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true,
                                pointStyle: 'circle'
                            }
                        }
                    }
                }
            });

            // Animation d'apparition des cartes
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

            // Observer tous les éléments avec la classe animate-slide-in
            document.querySelectorAll('.animate-slide-in').forEach(el => {
                observer.observe(el);
            });

            // Animation des barres de progression
            setTimeout(() => {
                document.querySelectorAll('.progress-bar-modern').forEach(bar => {
                    const width = bar.style.width;
                    bar.style.width = '0%';
                    setTimeout(() => {
                        bar.style.width = width;
                    }, 100);
                });
            }, 1000);
        });
    </script>
@endsection