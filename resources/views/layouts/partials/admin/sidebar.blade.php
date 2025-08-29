<nav class="sidebar" id="sidebar">
    <div class="sidebar-content">
        <!-- Dashboard -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Tableau de bord</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link active">
                        <i class="bi bi-speedometer2 sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Vue d'ensemble</span>
                    </a>
                </li>
                {{-- <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-graph-up-arrow sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Analytiques</span>
                    </a>
                </li> --}}
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-pie-chart sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Rapports</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- E-commerce -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">{{ config('app.name') }}</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.products.index') }}" class="sidebar-menu-link">
                        <i class="bi bi-box-seam sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Produits</span>
                        <span class="sidebar-menu-badge">124</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-grid sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Catégories</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-receipt sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Commandes</span>
                        <span class="sidebar-menu-badge">23</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-people sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Clients</span>
                    </a>
                </li>
                {{-- <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-tags sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Promotions</span>
                    </a>
                </li> --}}
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-truck sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Livraisons</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Marketing -->
        {{-- <div class="sidebar-section">
            <div class="sidebar-section-title">Marketing</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-megaphone sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Campagnes</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-envelope sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Email Marketing</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-star sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Avis clients</span>
                    </a>
                </li>
            </ul>
        </div> --}}

        <!-- Gestion -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Gestion</div>
            <ul class="sidebar-menu">
                {{-- <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-wallet2 sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Finances</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-building sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Inventaire</span>
                    </a>
                </li> --}}
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-shield-check sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Utilisateurs</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Configuration -->
        {{-- <div class="sidebar-section">
            <div class="sidebar-section-title">Configuration</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-gear sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Paramètres</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-palette sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Apparence</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-shield-lock sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Sécurité</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="#" class="sidebar-menu-link">
                        <i class="bi bi-life-preserver sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Support</span>
                    </a>
                </li>
            </ul>
        </div> --}}
    </div>
    <a href="{{ url('/') }}" class="sidebar-menu">Accueil</a>
</nav>
