@extends('layouts.product')

@section('title', $category->name)

@section('content')
    <style>
        /* Styles personnalisés pour l'affichage de catégorie */
        .detail-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid #f0f0f0;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .detail-header {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            padding: 2rem;
            text-align: center;
            position: relative;
        }

        .detail-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .detail-header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .detail-header .subtitle {
            font-size: 1.2rem;
            opacity: 0.9;
            margin: 0;
            position: relative;
            z-index: 1;
        }

        .detail-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            opacity: 0.8;
            position: relative;
            z-index: 1;
        }

        .detail-body {
            padding: 2.5rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .info-item {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .info-item:hover {
            background: #f1f5f9;
            border-color: #cbd5e0;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .info-label {
            font-weight: 700;
            color: #4a5568;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1.25rem;
            font-weight: 600;
            color: #2d3748;
        }

        .info-value.slug {
            font-family: 'Monaco', 'Menlo', monospace;
            background: white;
            border: 1px solid #cbd5e0;
            border-radius: 6px;
            padding: 0.5rem;
            font-size: 1rem;
            color: #4facfe;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .status-active {
            background: linear-gradient(135deg, #48bb78 0%, #38a169 100%);
            color: white;
        }

        .status-inactive {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            color: white;
        }

        .image-section {
            background: #f8fafc;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .image-section img {
            max-width: 300px;
            max-height: 300px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease;
        }

        .image-section img:hover {
            transform: scale(1.05);
        }

        .no-image {
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e0 100%);
            border-radius: 12px;
            padding: 3rem 2rem;
            color: #718096;
        }

        .no-image i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .description-section {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .description-section h3 {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .description-section h3 i {
            margin-right: 0.5rem;
            color: #4facfe;
        }

        .description-text {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #4a5568;
            margin: 0;
        }

        .no-description {
            font-style: italic;
            color: #a0aec0;
            text-align: center;
            padding: 1rem 0;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            padding: 2rem;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .btn-gradient-primary {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.4);
        }

        .btn-gradient-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(79, 172, 254, 0.6);
            color: white;
        }

        .btn-gradient-warning {
            background: linear-gradient(135deg, #fbd38d 0%, #f6ad55 100%);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(246, 173, 85, 0.4);
        }

        .btn-gradient-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(246, 173, 85, 0.6);
            color: white;
        }

        .btn-gradient-danger {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
            border: none;
            color: white;
            font-weight: 700;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(229, 62, 62, 0.4);
        }

        .btn-gradient-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(229, 62, 62, 0.6);
            color: white;
        }

        .btn-outline-secondary {
            border: 2px solid #e2e8f0;
            color: #718096;
            background: white;
            font-weight: 600;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: #f8fafc;
            border-color: #cbd5e0;
            color: #4a5568;
            transform: translateY(-2px);
        }

        .breadcrumb-modern {
            background: transparent;
            padding: 0;
            margin-bottom: 2rem;
        }

        .breadcrumb-modern .breadcrumb-item {
            font-weight: 600;
        }

        .breadcrumb-modern .breadcrumb-item.active {
            color: #4facfe;
        }

        .breadcrumb-modern a {
            color: #718096;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-modern a:hover {
            color: #4facfe;
        }

        .stats-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .timeline-section {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .timeline-section h3 {
            color: #2d3748;
            font-weight: 700;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .timeline-section h3 i {
            margin-right: 0.5rem;
            color: #4facfe;
        }

        .timeline-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
            padding: 1rem;
            background: #f8fafc;
            border-radius: 8px;
        }

        .timeline-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .timeline-content {
            flex: 1;
        }

        .timeline-date {
            font-size: 0.875rem;
            color: #718096;
            font-weight: 600;
        }

        .timeline-action {
            font-weight: 600;
            color: #2d3748;
        }

        @media (max-width: 768px) {
            .detail-header h1 {
                font-size: 2rem;
            }

            .detail-body {
                padding: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Animation */
        .detail-card {
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .floating-actions {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 1000;
        }

        .floating-btn {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            border: none;
            color: white;
            font-size: 1.25rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .floating-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
        }

        .floating-btn.edit {
            background: linear-gradient(135deg, #fbd38d 0%, #f6ad55 100%);
        }

        .floating-btn.delete {
            background: linear-gradient(135deg, #fc8181 0%, #e53e3e 100%);
        }

        @media (max-width: 768px) {
            .floating-actions {
                display: none;
            }
        }
    </style>

    <div class="container-fluid">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="breadcrumb-modern">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('categories.index') }}">
                        <i class="bi bi-grid-3x3-gap me-1"></i>
                        Catégories
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="bi bi-eye me-1"></i>
                    {{ $category->name }}
                </li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-8">
                <!-- Carte principale -->
                <div class="detail-card">
                    <!-- Header -->
                    <div class="detail-header">
                        <div class="detail-icon">
                            <i class="bi bi-folder-open"></i>
                        </div>
                        <h1>{{ $category->name }}</h1>
                        <p class="subtitle">Détails de la catégorie</p>
                    </div>

                    <!-- Corps -->
                    <div class="detail-body">
                        <!-- Informations principales -->
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-tag me-1"></i>
                                    Nom
                                </div>
                                <div class="info-value">{{ $category->name }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-link-45deg me-1"></i>
                                    Slug (URL)
                                </div>
                                <div class="info-value slug">{{ $category->slug }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-arrow-up-down me-1"></i>
                                    Ordre d'affichage
                                </div>
                                <div class="info-value">{{ $category->order }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="bi bi-eye me-1"></i>
                                    Statut
                                </div>
                                <div class="info-value">
                                    @if($category->is_active)
                                        <span class="status-badge status-active">
                                            <i class="bi bi-check-circle me-1"></i>
                                            Active
                                        </span>
                                    @else
                                        <span class="status-badge status-inactive">
                                            <i class="bi bi-x-circle me-1"></i>
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Image -->
                        <div class="image-section">
                            <h3 class="mb-3">
                                <i class="bi bi-image me-2"></i>
                                Image de la catégorie
                            </h3>
                            @if($category->image)
                                <img src="{{ Storage::url($category->image) }}" 
                                     alt="{{ $category->name }}" 
                                     class="img-fluid">
                                <div class="mt-2">
                                    <small class="text-muted">{{ basename($category->image) }}</small>
                                </div>
                            @else
                                <div class="no-image">
                                    <i class="bi bi-image"></i>
                                    <div>Aucune image définie</div>
                                </div>
                            @endif
                        </div>

                        <!-- Description -->
                        <div class="description-section">
                            <h3>
                                <i class="bi bi-card-text"></i>
                                Description
                            </h3>
                            @if($category->description)
                                <p class="description-text">{{ $category->description }}</p>
                            @else
                                <p class="no-description">Aucune description fournie</p>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="action-buttons">
                        <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left me-2"></i>
                            Retour à la liste
                        </a>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-gradient-warning">
                            <i class="bi bi-pencil me-2"></i>
                            Modifier
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-gradient-danger">
                                <i class="bi bi-trash me-2"></i>
                                Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Statistiques -->
                <div class="stats-section">
                    <h3 class="mb-3 text-white">
                        <i class="bi bi-bar-chart me-2"></i>
                        Statistiques
                    </h3>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <div class="stat-number">{{ $category->products_count ?? 0 }}</div>
                            <div class="stat-label">Produits</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $category->is_active ? '✓' : '✗' }}</div>
                            <div class="stat-label">Statut</div>
                        </div>
                    </div>
                </div>

                <!-- Historique -->
                <div class="timeline-section">
                    <h3>
                        <i class="bi bi-clock-history"></i>
                        Historique
                    </h3>
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="bi bi-plus-circle"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-action">Catégorie créée</div>
                            <div class="timeline-date">{{ $category->created_at->format('d/m/Y à H:i') }}</div>
                        </div>
                    </div>
                    @if($category->updated_at != $category->created_at)
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-pencil"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-action">Dernière modification</div>
                                <div class="timeline-date">{{ $category->updated_at->format('d/m/Y à H:i') }}</div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Informations techniques -->
                <div class="timeline-section">
                    <h3>
                        <i class="bi bi-info-circle"></i>
                        Informations techniques
                    </h3>
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="bi bi-key"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-action">ID</div>
                            <div class="timeline-date">#{{ $category->id }}</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-icon">
                            <i class="bi bi-calendar-plus"></i>
                        </div>
                        <div class="timeline-content">
                            <div class="timeline-action">Créé le</div>
                            <div class="timeline-date">{{ $category->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    @if($category->updated_at != $category->created_at)
                        <div class="timeline-item">
                            <div class="timeline-icon">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div class="timeline-content">
                                <div class="timeline-action">Modifié le</div>
                                <div class="timeline-date">{{ $category->updated_at->format('d/m/Y') }}</div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions flottantes (desktop uniquement) -->
    <div class="floating-actions">
        {{-- <a href="{{ route('categories.edit', $category) }}" class="floating-btn edit" title="Modifier">
            <i class="bi bi-pencil"></i>
        </a> --}}
        <button type="button" class="floating-btn delete" title="Supprimer" onclick="confirmDelete()">
            <i class="bi bi-trash"></i>
        </button>
    </div>

    <!-- Scripts -->
    <script>
        function confirmDelete() {
            if (confirm('Êtes-vous sûr de vouloir supprimer la catégorie "{{ $category->name }}" ?\n\nCette action est irréversible.')) {
                // Créer un formulaire de suppression
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route('categories.destroy', $category) }}';
                
                // Ajouter le token CSRF
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '{{ csrf_token() }}';
                
                // Ajouter la méthode DELETE
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Animation au scroll
        document.addEventListener('DOMContentLoaded', function() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            });

            // Observer tous les éléments avec animation
            document.querySelectorAll('.info-item, .timeline-item').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'all 0.6s ease';
                observer.observe(el);
            });
        });
    </script>
@endsection