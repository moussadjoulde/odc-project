<header class="admin-header">
    <div class="header-left">
        <a href="#" class="admin-logo">
            <i class="bi bi-shop"></i>
            {{ config('app.name') }}
        </a>
        
        <button class="sidebar-toggle" id="sidebarToggle" title="Toggle Sidebar (Ctrl+B)">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="header-center">
        <div class="search-container">
            <input type="text" class="search-input"
                placeholder="Rechercher produits, commandes, clients... (Ctrl+K)">
            <i class="bi bi-search search-icon"></i>
        </div>
    </div>

    <div class="header-right">
        <button class="header-btn" id="notificationBtn" title="Notifications">
            <i class="bi bi-bell"></i>
            <span class="notification-badge"></span>
        </button>

        <button class="header-btn" title="Messages">
            <i class="bi bi-chat-dots"></i>
        </button>

        <div class="dropdown user-menu">
            <button class="user-avatar" data-bs-toggle="dropdown" title="Menu utilisateur">
                JD
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-2">
                <li>
                    <h6 class="dropdown-header">John Doe</h6>
                </li>
                <li><a class="dropdown-item py-2" href="#"><i class="bi bi-person me-3"></i>Mon Profil</a></li>
                <li><a class="dropdown-item py-2" href="#"><i class="bi bi-gear me-3"></i>Paramètres</a></li>
                <li><a class="dropdown-item py-2" href="#"><i class="bi bi-question-circle me-3"></i>Aide</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item py-2 text-danger" href="#"><i
                            class="bi bi-box-arrow-right me-3"></i>Déconnexion</a></li>
            </ul>
        </div>
    </div>
</header>
