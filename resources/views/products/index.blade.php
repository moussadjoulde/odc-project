@extends('layouts.product')

@section('title', 'Gestion des Produits')

@section('content')
    <style>
        /* Styles personnalisés pour la page produits */
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
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: #2d3748;
            line-height: 1;
        }

        .stat-label {
            color: #718096;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
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

        .badge-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .page-header {
            position: relative;
            padding: 3rem 0;
            margin-bottom: 2rem;
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

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .search-box {
            background: white;
            border-radius: 50px;
            padding: 0.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #e2e8f0;
        }

        .search-box input {
            border: none;
            outline: none;
            background: transparent;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        .search-box .input-group-text {
            background: transparent;
            border: none;
            color: #667eea;
        }

        .table-modern {
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .table-modern thead {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .table-modern thead th {
            border: none;
            padding: 1.25rem 1rem;
            font-weight: 700;
            color: #2d3748;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-modern tbody tr {
            transition: all 0.3s ease;
            border: none;
        }

        .table-modern tbody tr:hover {
            background: #f7fafc;
            transform: scale(1.01);
        }

        .table-modern tbody td {
            padding: 1.25rem 1rem;
            border: none;
            vertical-align: middle;
        }

        .product-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .btn-group-modern .btn {
            border-radius: 8px;
            margin: 0 2px;
            padding: 0.5rem 0.75rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: #667eea;
            border-color: #667eea;
            transform: translateY(-1px);
        }

        .btn-outline-warning:hover {
            background: #f6ad55;
            border-color: #f6ad55;
            transform: translateY(-1px);
        }

        .btn-outline-info:hover {
            background: #4fd1c7;
            border-color: #4fd1c7;
            transform: translateY(-1px);
        }

        .btn-outline-danger:hover {
            background: #fc8181;
            border-color: #fc8181;
            transform: translateY(-1px);
        }

        .empty-state {
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-state-icon {
            font-size: 6rem;
            color: #e2e8f0;
            margin-bottom: 2rem;
        }

        .alert-modern {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #68d391 0%, #38a169 100%);
            color: white;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            color: white;
        }

        .price-badge {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.95rem;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .stat-number {
                font-size: 2rem;
            }

            .page-header {
                padding: 2rem 0;
            }

            .btn-group-modern {
                flex-direction: column;
                gap: 0.25rem;
            }
        }
    </style>

    <!-- Messages d'alerte -->
    @if (session('success'))
        <div class="alert alert-success alert-modern alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-check-circle me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Succès !</strong> {{ session('success') }}
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-modern alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <strong>Erreur !</strong> {{ session('error') }}
                </div>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Header de la page -->
    <div class="page-header text-center">
        <div class="container-fluid">
            <div class="float-animation mb-4">
                <i class="bi bi-box-seam" style="font-size: 4rem; color: #667eea;"></i>
            </div>
            <h1 class="display-4 fw-bold mb-3" style="color: #2d3748;">Gestion des Produits</h1>
            <p class="lead" style="color: #718096;">Gérez facilement votre catalogue de produits avec style</p>
        </div>
    </div>

    <!-- Statistiques et Actions -->
    <div class="container-fluid">
        <div class="row mb-5">
            <!-- Statistiques -->
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-4">
                                    <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                        <i class="bi bi-box text-primary" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="stat-label mb-2">Total Produits</h6>
                                    <div class="stat-number">{{ count($products) }}</div>
                                    <small class="text-muted">
                                        <i class="bi bi-graph-up text-success me-1"></i>
                                        Catalogue complet
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="stat-card">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0 me-4">
                                    <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                        <i class="bi bi-currency-euro text-success" style="font-size: 2.5rem;"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="stat-label mb-2">Valeur Totale</h6>
                                    <div class="stat-number">
                                        {{ number_format($products->sum('price'), 0, ',', ' ') }}€
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-trending-up text-success me-1"></i>
                                        Inventaire valorisé
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="col-lg-4 mb-4">
                <div class="stat-card d-flex flex-column justify-content-center">
                    <div class="text-center">
                        <h6 class="stat-label mb-4">Actions Rapides</h6>
                        <a href="{{ route('products.create') }}" class="btn btn-gradient-primary btn-lg mb-3 w-100">
                            <i class="bi bi-plus-circle me-2"></i>
                            Nouveau Produit
                        </a>
                        <a href="{{ route('products.exportCSV') }}" class="btn btn-outline-secondary w-100">
                            <i class="bi bi-download me-2"></i>
                            Exporter en CSV
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Table des produits -->
        <div class="card border-0 table-modern">
            <div class="card-header bg-white border-0 py-4">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="card-title mb-0 fw-bold d-flex align-items-center">
                            <i class="bi bi-list-ul me-3 text-primary"></i>
                            Liste des Produits
                            <span class="badge bg-primary bg-opacity-10 text-primary ms-3 rounded-pill px-3">
                                {{ count($products) }}
                            </span>
                        </h3>
                    </div>
                    <div class="col-md-6">
                        <div class="search-box">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control" placeholder="Rechercher un produit..."
                                    id="searchInput">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($products) > 0)
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" id="productsTable">
                            <thead>
                                <tr>
                                    <th style="width: 80px;">
                                        <i class="bi bi-hash me-1"></i>ID
                                    </th>
                                    <th>
                                        <i class="bi bi-tag me-2"></i>
                                        Produit
                                    </th>
                                    <th>
                                        <i class="bi bi-card-text me-2"></i>
                                        Description
                                    </th>
                                    <th>
                                        <i class="bi bi-currency-euro me-2"></i>
                                        Prix
                                    </th>
                                    <th class="text-center" style="width: 250px;">
                                        <i class="bi bi-gear me-2"></i>
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                    <tr>
                                        <!-- ID -->
                                        <td>
                                            <span class="badge badge-gradient-primary rounded-pill"
                                                style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 600;">
                                                {{ $product->id }}
                                            </span>
                                        </td>

                                        <!-- Produit -->
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="product-avatar me-3">
                                                    {{ strtoupper(substr($product->name, 0, 2)) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-1 fw-bold" style="color: #2d3748;">{{ $product->name }}
                                                    </h6>
                                                    <small class="text-muted d-flex align-items-center">
                                                        <i class="bi bi-tag me-1"></i>
                                                        SKU: {{ $product->sku ?? 'N/A' }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Description -->
                                        <td>
                                            <div class="description-cell">
                                                <p class="mb-1" style="color: #4a5568;">
                                                    {{ Str::limit($product->description, 60) }}
                                                </p>
                                                @if (strlen($product->description) > 60)
                                                    <small class="text-primary" style="cursor: pointer;"
                                                        onclick="showFullDescription('{{ addslashes($product->description) }}', '{{ $product->name }}')">
                                                        <i class="bi bi-eye me-1"></i>Voir plus
                                                    </small>
                                                @endif
                                            </div>
                                        </td>

                                        <!-- Prix -->
                                        <td>
                                            <span class="price-badge">
                                                {{ number_format($product->price, 2, ',', ' ') }} €
                                            </span>
                                        </td>

                                        <!-- Actions -->
                                        <td>
                                            <div class="btn-group-modern d-flex justify-content-center" role="group">
                                                <!-- Voir -->
                                                <a href="{{ route('products.show', $product) }}"
                                                    class="btn btn-outline-primary btn-sm" title="Voir les détails"
                                                    data-bs-toggle="tooltip">
                                                    <i class="bi bi-eye"></i>
                                                </a>

                                                <!-- Modifier -->
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="btn btn-outline-warning btn-sm" title="Modifier"
                                                    data-bs-toggle="tooltip">
                                                    <i class="bi bi-pencil"></i>
                                                </a>

                                                <!-- Exporter CSV -->
                                                <a href="{{ route('products.exportCSVWithId', $product) }}"
                                                    class="btn btn-outline-info btn-sm" title="Exporter en CSV"
                                                    data-bs-toggle="tooltip">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i>
                                                </a>

                                                <!-- Supprimer -->
                                                <button type="button" class="btn btn-outline-danger btn-sm"
                                                    title="Supprimer" data-bs-toggle="tooltip"
                                                    onclick="confirmDelete('{{ $product->name }}', '{{ route('products.destroy', $product) }}')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <!-- État vide -->
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-inbox"></i>
                    </div>
                    <h3 class="fw-bold mb-3" style="color: #4a5568;">Aucun produit trouvé</h3>
                    <p class="text-muted mb-4 fs-5">Commencez par créer votre premier produit pour voir apparaître votre
                        catalogue ici.</p>
                    <a href="{{ route('products.create') }}" class="btn btn-gradient-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>
                        Créer mon premier produit
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal pour confirmation de suppression -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="deleteModalLabel" style="color: #2d3748;">
                        <i class="bi bi-exclamation-triangle text-danger me-2"></i>
                        Confirmer la suppression
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-2">
                    <p class="text-muted mb-4">Êtes-vous sûr de vouloir supprimer le produit <strong
                            id="productToDelete"></strong> ?</p>
                    <div class="alert alert-warning border-0"
                        style="border-radius: 12px; background: rgba(255, 193, 7, 0.1);">
                        <i class="bi bi-info-circle text-warning me-2"></i>
                        Cette action est irréversible.
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        style="border-radius: 8px;">
                        <i class="bi bi-x-circle me-1"></i>Annuler
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="border-radius: 8px;">
                            <i class="bi bi-trash me-1"></i>Supprimer
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal pour afficher la description complète -->
    <div class="modal fade" id="descriptionModal" tabindex="-1" aria-labelledby="descriptionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0" style="border-radius: 16px;">
                <div class="modal-header border-0 pb-2">
                    <h5 class="modal-title fw-bold" id="descriptionModalLabel" style="color: #2d3748;">
                        <i class="bi bi-file-text text-primary me-2"></i>
                        Description complète
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="bg-light p-4" style="border-radius: 12px;">
                        <p id="fullDescription" class="mb-0" style="line-height: 1.6;"></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialiser les tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Fonction de recherche améliorée
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('productsTable');

            if (searchInput && table) {
                searchInput.addEventListener('keyup', function() {
                    const filter = this.value.toLowerCase();
                    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

                    for (let i = 0; i < rows.length; i++) {
                        let found = false;
                        const cells = rows[i].getElementsByTagName('td');

                        // Rechercher dans le nom du produit (colonne 1) et la description (colonne 2)
                        for (let j = 1; j <= 2; j++) {
                            if (cells[j]) {
                                const textValue = cells[j].textContent || cells[j].innerText;
                                if (textValue.toLowerCase().indexOf(filter) > -1) {
                                    found = true;
                                    break;
                                }
                            }
                        }

                        rows[i].style.display = found ? '' : 'none';
                    }

                    // Animation pour les résultats
                    const visibleRows = table.querySelectorAll('tbody tr[style=""]');
                    visibleRows.forEach((row, index) => {
                        setTimeout(() => {
                            row.style.opacity = '0';
                            row.style.transform = 'translateY(20px)';
                            setTimeout(() => {
                                row.style.transition = 'all 0.3s ease';
                                row.style.opacity = '1';
                                row.style.transform = 'translateY(0)';
                            }, 50);
                        }, index * 50);
                    });
                });
            }
        });

        // Fonction pour confirmer la suppression
        function confirmDelete(productName, deleteUrl) {
            document.getElementById('productToDelete').textContent = productName;
            document.getElementById('deleteForm').action = deleteUrl;

            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }

        // Fonction pour afficher la description complète
        function showFullDescription(description, productName) {
            document.getElementById('descriptionModalLabel').innerHTML =
                '<i class="bi bi-file-text text-primary me-2"></i>Description - ' + productName;
            document.getElementById('fullDescription').textContent = description;

            const modal = new bootstrap.Modal(document.getElementById('descriptionModal'));
            modal.show();
        }

        // Animation au chargement
        window.addEventListener('load', function() {
            const cards = document.querySelectorAll('.stat-card');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px)';
                    card.style.transition = 'all 0.6s ease';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'translateY(0)';
                    }, 100);
                }, index * 200);
            });
        });
    </script>
@endsection
