<nav class="sidebar" id="sidebar">
    <div class="sidebar-content">
        <!-- Dashboard -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Tableau de bord</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2 sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Vue d'ensemble</span>
                    </a>
                </li>
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
                    <a href="{{ route('products.index') }}" 
                       class="sidebar-menu-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="bi bi-box-seam sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Produits</span>
                        <span class="sidebar-menu-badge">124</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('categories.index') }}" 
                       class="sidebar-menu-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="bi bi-grid sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Catégories</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('orders.admin.index') }}" 
                       class="sidebar-menu-link {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                        <i class="bi bi-receipt sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Commandes</span>
                        <span class="sidebar-menu-badge">23</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Gestion -->
        <div class="sidebar-section">
            <div class="sidebar-section-title">Gestion</div>
            <ul class="sidebar-menu">
                <li class="sidebar-menu-item">
                    <a href="{{ route('users.index') }}" 
                       class="sidebar-menu-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="bi bi-shield-check sidebar-menu-icon"></i>
                        <span class="sidebar-menu-text">Utilisateurs</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
    <!-- Lien Accueil - actif si on est sur la page d'accueil -->
    <a href="{{ url('/') }}" 
       class="sidebar-menu {{ request()->is('/') ? 'active' : '' }}">
        Accueil
    </a>
</nav>