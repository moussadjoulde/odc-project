@extends('layouts.app')

@section('title', 'Gestion des Produits')

@section('content')
<!-- Messages d'alerte -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<!-- Header de la page -->
<div class="page-header text-center mb-5 mt-3">
    <div class="float-animation mb-4">
        <i class="bi bi-box-seam" style="font-size: 4rem; color: #667eea;"></i>
    </div>
    <h1 class="display-4 fw-bold mb-3">Gestion des Produits</h1>
    <p class="lead text-muted">Gérez facilement votre catalogue de produits</p>
</div>

<!-- Statistiques et Actions -->
<div class="row mb-5">
    <!-- Carte de statistiques -->
    <div class="col-lg-8">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="stat-card h-100">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-box text-primary" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label mb-2">Total Produits</h6>
                            <div class="stat-number">{{ count($products) }}</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="stat-card h-100">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="bi bi-currency-euro text-success" style="font-size: 2rem;"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="stat-label mb-2">Valeur Totale</h6>
                            <div class="stat-number">
                                {{ number_format($products->sum('price'), 2, ',', ' ') }} €
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Boutons d'action -->
    <div class="col-lg-4 mb-4">
        <div class="card h-100 border-0">
            <div class="card-body d-flex flex-column justify-content-center">
                <div class="text-center">
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
</div>

<!-- Table des produits -->
<div class="card border-0">
    <div class="card-header bg-white border-0 py-4">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="card-title mb-0 fw-bold">
                    <i class="bi bi-list-ul me-2 text-primary"></i>
                    Liste des Produits
                </h3>
            </div>
            <div class="col-auto">
                <div class="input-group">
                    <span class="input-group-text bg-light border-0">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" class="form-control border-0" placeholder="Rechercher un produit..." id="searchInput">
                </div>
            </div>
        </div>
    </div>

    @if(count($products) > 0)
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="productsTable">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 80px;">
                                <i class="bi bi-hash"></i>
                            </th>
                            <th>
                                <i class="bi bi-tag me-2"></i>
                                Nom du Produit
                            </th>
                            <th>
                                <i class="bi bi-currency-euro me-2"></i>
                                Prix
                            </th>
                            <th>
                                <i class="bi bi-card-text me-2"></i>
                                Description
                            </th>
                            <th class="text-center" style="width: 200px;">
                                <i class="bi bi-gear me-2"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                            <tr>
                                <!-- ID -->
                                <td class="text-center">
                                    <span class="badge badge-gradient-primary rounded-circle p-2" style="width: 40px; height: 40px; line-height: 1.5;">
                                        {{ $product->id }}
                                    </span>
                                </td>

                                <!-- Nom du produit -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-3">
                                            <i class="bi bi-box text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ $product->name }}</h6>
                                            <small class="text-muted">#{{ $product->sku }}</small>
                                        </div>
                                    </div>
                                </td>

                                <!-- Description -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle p-2 me-3">
                                            <i class="bi bi-file-earmark-text text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-semibold">{{ Str::limit($product->description, 50) }}</h6>
                                        </div>
                                    </div>
                                </td>

                                <!-- Prix -->
                                <td>
                                    <span class="badge bg-success bg-opacity-10 text-success px-3 py-2 fs-6">
                                        {{ number_format($product->price, 2, ',', ' ') }} €
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <!-- Voir -->
                                        <a href="{{ route('products.show', $product) }}" 
                                           class="btn btn-outline-primary btn-sm" 
                                           title="Voir les détails">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <!-- Modifier -->
                                        <a href="{{ route('products.edit', $product) }}" 
                                           class="btn btn-outline-warning btn-sm" 
                                           title="Modifier">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <!-- Exporter CSV -->
                                        <a href="{{ route('products.exportCSVWithId', $product) }}" 
                                           class="btn btn-outline-info btn-sm" 
                                           title="Exporter en CSV">
                                            <i class="bi bi-file-earmark-spreadsheet"></i>
                                        </a>

                                        <!-- Supprimer -->
                                        <form action="{{ route('products.destroy', $product) }}" 
                                              method="POST" 
                                              style="display: inline-block;" 
                                              onsubmit="return confirmDelete('Êtes-vous sûr de vouloir supprimer le produit {{ $product->name }} ?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-outline-danger btn-sm" 
                                                    title="Supprimer">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
        <div class="card-body text-center py-5">
            <div class="mb-4">
                <i class="bi bi-inbox" style="font-size: 5rem; color: #dee2e6;"></i>
            </div>
            <h4 class="text-muted mb-3">Aucun produit trouvé</h4>
            <p class="text-muted mb-4">Commencez par créer votre premier produit pour voir apparaître votre catalogue ici.</p>
            <a href="{{ route('products.create') }}" class="btn btn-gradient-primary btn-lg">
                <i class="bi bi-plus-circle me-2"></i>
                Créer mon premier produit
            </a>
        </div>
    @endif
</div>

<!-- Script pour la recherche -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('productsTable');
    
    if (searchInput && table) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            for (let i = 0; i < rows.length; i++) {
                const productName = rows[i].getElementsByTagName('td')[1];
                if (productName) {
                    const textValue = productName.textContent || productName.innerText;
                    if (textValue.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        });
    }
});
</script>
@endsection