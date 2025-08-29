@extends('layouts.product')
@section('content')
    <div class="page-header">
        <div class="page-header-content">
            <h1>Tableau de bord</h1>
            <p>Gérez votre boutique en ligne avec élégance et efficacité</p>
        </div>
        <div class="page-header-actions">
            <button class="btn-modern btn-secondary-modern me-2">
                <i class="bi bi-download"></i>
                Exporter
            </button>
            <button class="btn-modern btn-primary-modern">
                <i class="bi bi-plus-lg"></i>
                Nouveau produit
            </button>
        </div>
    </div>
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card animate-slide-in">
            <div class="stat-icon primary">
                <i class="bi bi-cart-check"></i>
            </div>
            <h3 class="stat-number">1,247</h3>
            <p class="stat-label">Commandes totales</p>
            <div class="stat-change positive">
                <i class="bi bi-arrow-up"></i>
                +12% ce mois
            </div>
        </div>

        <div class="stat-card animate-slide-in">
            <div class="stat-icon success">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <h3 class="stat-number">€47,392</h3>
            <p class="stat-label">Revenus</p>
            <div class="stat-change positive">
                <i class="bi bi-arrow-up"></i>
                +8.5% ce mois
            </div>
        </div>

        <div class="stat-card animate-slide-in">
            <div class="stat-icon warning">
                <i class="bi bi-people"></i>
            </div>
            <h3 class="stat-number">892</h3>
            <p class="stat-label">Clients actifs</p>
            <div class="stat-change positive">
                <i class="bi bi-arrow-up"></i>
                +15% ce mois
            </div>
        </div>

        <div class="stat-card animate-slide-in">
            <div class="stat-icon danger">
                <i class="bi bi-box"></i>
            </div>
            <h3 class="stat-number">124</h3>
            <p class="stat-label">Produits</p>
            <div class="stat-change negative">
                <i class="bi bi-arrow-down"></i>
                -2% ce mois
            </div>
        </div>
    </div>

    <!-- Content Cards -->
    <div class="row">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Commandes récentes</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">Voir tout</a>
                </div>
                <div class="admin-card-body p-0">
                    <div class="admin-table-container">
                        <table class="table admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Client</th>
                                    <th>Produits</th>
                                    <th>Total</th>
                                    <th>Statut</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><strong>#1247</strong></td>
                                    <td>Marie Dubois</td>
                                    <td>3 articles</td>
                                    <td><strong>€129.90</strong></td>
                                    <td><span class="badge bg-success">Livrée</span></td>
                                    <td>Il y a 2h</td>
                                </tr>
                                <tr>
                                    <td><strong>#1246</strong></td>
                                    <td>Pierre Martin</td>
                                    <td>1 article</td>
                                    <td><strong>€49.99</strong></td>
                                    <td><span class="badge bg-warning">En cours</span></td>
                                    <td>Il y a 4h</td>
                                </tr>
                                <tr>
                                    <td><strong>#1245</strong></td>
                                    <td>Sophie Laurent</td>
                                    <td>5 articles</td>
                                    <td><strong>€299.50</strong></td>
                                    <td><span class="badge bg-primary">Préparée</span></td>
                                    <td>Il y a 6h</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Activité récente</h5>
                </div>
                <div class="admin-card-body">
                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-primary rounded-circle p-2">
                                <i class="bi bi-plus text-white"></i>
                            </div>
                        </div>
                        <div>
                            <strong>Nouveau produit ajouté</strong>
                            <div class="text-muted small">iPhone 15 Pro Max</div>
                            <div class="text-muted small">Il y a 15 min</div>
                        </div>
                    </div>

                    <div class="d-flex mb-3">
                        <div class="me-3">
                            <div class="bg-success rounded-circle p-2">
                                <i class="bi bi-cart-check text-white"></i>
                            </div>
                        </div>
                        <div>
                            <strong>Nouvelle commande</strong>
                            <div class="text-muted small">Commande #1247 - €129.90</div>
                            <div class="text-muted small">Il y a 32 min</div>
                        </div>
                    </div>

                    <div class="d-flex">
                        <div class="me-3">
                            <div class="bg-warning rounded-circle p-2">
                                <i class="bi bi-exclamation-triangle text-white"></i>
                            </div>
                        </div>
                        <div>
                            <strong>Stock faible</strong>
                            <div class="text-muted small">MacBook Air M2 - 3 restants</div>
                            <div class="text-muted small">Il y a 1h</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Statistiques rapides</h5>
                </div>
                <div class="admin-card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">23</h4>
                                <small class="text-muted">Commandes aujourd'hui</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <h4 class="text-success mb-1">€1,247</h4>
                            <small class="text-muted">Revenus aujourd'hui</small>
                        </div>
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-warning mb-1">12</h4>
                                <small class="text-muted">Produits en rupture</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-info mb-1">4.8</h4>
                            <small class="text-muted">Note moyenne</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques et données supplémentaires -->
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Top des produits</h5>
                </div>
                <div class="admin-card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded me-3" style="width: 40px; height: 40px;"></div>
                            <div>
                                <strong>iPhone 15 Pro</strong>
                                <div class="text-muted small">Smartphones</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <strong>47 ventes</strong>
                            <div class="text-success small">+12%</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-success rounded me-3" style="width: 40px; height: 40px;"></div>
                            <div>
                                <strong>MacBook Air M2</strong>
                                <div class="text-muted small">Ordinateurs</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <strong>23 ventes</strong>
                            <div class="text-success small">+8%</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning rounded me-3" style="width: 40px; height: 40px;"></div>
                            <div>
                                <strong>AirPods Pro</strong>
                                <div class="text-muted small">Audio</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <strong>19 ventes</strong>
                            <div class="text-danger small">-3%</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="bg-info rounded me-3" style="width: 40px; height: 40px;"></div>
                            <div>
                                <strong>iPad Air</strong>
                                <div class="text-muted small">Tablettes</div>
                            </div>
                        </div>
                        <div class="text-end">
                            <strong>15 ventes</strong>
                            <div class="text-success small">+5%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h5 class="admin-card-title">Actions rapides</h5>
                </div>
                <div class="admin-card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <button
                                class="btn btn-gradient btn-gradient-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                style="min-height: 80px;">
                                <i class="bi bi-plus-lg fs-4 mb-2"></i>
                                <span>Ajouter produit</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button
                                class="btn btn-gradient btn-gradient-success w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                style="min-height: 80px;">
                                <i class="bi bi-receipt fs-4 mb-2"></i>
                                <span>Nouvelle commande</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button
                                class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                style="min-height: 80px;">
                                <i class="bi bi-people fs-4 mb-2"></i>
                                <span>Gérer clients</span>
                            </button>
                        </div>
                        <div class="col-6">
                            <button
                                class="btn btn-outline-secondary w-100 h-100 d-flex flex-column align-items-center justify-content-center"
                                style="min-height: 80px;">
                                <i class="bi bi-bar-chart fs-4 mb-2"></i>
                                <span>Voir rapports</span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="mb-3">Raccourcis clavier</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Nouveau produit</span>
                            <kbd>Ctrl + N</kbd>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Recherche</span>
                            <kbd>Ctrl + K</kbd>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Menu sidebar</span>
                            <kbd>Ctrl + B</kbd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
