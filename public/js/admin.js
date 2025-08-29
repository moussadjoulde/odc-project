document.addEventListener('DOMContentLoaded', function () {
    // Éléments DOM
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const mainContent = document.getElementById('mainContent');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const searchInput = document.querySelector('.search-input');
    const notificationBtn = document.getElementById('notificationBtn');

    let sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';

    // État initial du sidebar
    function initSidebar() {
        if (window.innerWidth <= 768) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
            sidebarCollapsed = true;
        } else if (sidebarCollapsed) {
            sidebar.classList.add('collapsed');
            mainContent.classList.add('expanded');
        }
        updateSidebarToggleIcon();
    }

    // Mise à jour de l'icône du toggle
    function updateSidebarToggleIcon() {
        const icon = sidebarToggle.querySelector('i');
        if (sidebarCollapsed) {
            icon.className = 'bi bi-layout-sidebar-inset';
        } else {
            icon.className = 'bi bi-list';
        }
    }

    // Toggle du sidebar
    function toggleSidebar() {
        sidebarCollapsed = !sidebarCollapsed;

        if (window.innerWidth <= 768) {
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
        } else {
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
        }

        updateSidebarToggleIcon();
    }

    // Event listeners
    sidebarToggle.addEventListener('click', toggleSidebar);

    // Fermer sidebar sur mobile en cliquant sur l'overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function () {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        });
    }

    // Gestion des liens actifs
    document.querySelectorAll('.sidebar-menu-link').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Retirer la classe active de tous les liens
            document.querySelectorAll('.sidebar-menu-link').forEach(l => {
                l.classList.remove('active');
            });

            // Ajouter la classe active au lien cliqué
            this.classList.add('active');

            // Fermer sidebar sur mobile après clic
            if (window.innerWidth <= 768) {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
            }
        });
    });

    // Raccourcis clavier
    document.addEventListener('keydown', function (e) {
        // Ctrl + B pour toggle sidebar
        if (e.ctrlKey && e.key === 'b') {
            e.preventDefault();
            toggleSidebar();
        }

        // Ctrl + K pour focus sur la recherche
        if (e.ctrlKey && e.key === 'k') {
            e.preventDefault();
            searchInput.focus();
        }

        // Échap pour fermer sidebar sur mobile
        if (e.key === 'Escape' && window.innerWidth <= 768) {
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
        }
    });

    // Fonction pour créer des toasts
    function createToast(type, title, message, duration = 5000) {
        const toastContainer = document.querySelector('.toast-container');
        const toastId = 'toast-' + Date.now();

        const iconMap = {
            success: 'bi-check-circle-fill text-success',
            error: 'bi-exclamation-triangle-fill text-danger',
            warning: 'bi-exclamation-circle-fill text-warning',
            info: 'bi-info-circle-fill text-info'
        };

        const toastHTML = `
                    <div id="${toastId}" class="toast align-items-center border-0 shadow-lg" role="alert">
                        <div class="d-flex">
                            <div class="toast-body d-flex align-items-center">
                                <i class="bi ${iconMap[type]} me-3 fs-5"></i>
                                <div>
                                    <div class="fw-bold">${title}</div>
                                    <div class="text-muted small">${message}</div>
                                </div>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                `;

        toastContainer.insertAdjacentHTML('beforeend', toastHTML);

        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            delay: duration
        });

        toast.show();

        // Nettoyer le DOM après fermeture
        toastElement.addEventListener('hidden.bs.toast', function () {
            toastElement.remove();
        });

        return toast;
    }

    // Notifications
    notificationBtn.addEventListener('click', function () {
        createToast('info', 'Nouvelles notifications', 'Vous avez 3 nouvelles commandes en attente de traitement.');
    });

    // Recherche en temps réel (simulation)
    let searchTimeout;
    searchInput.addEventListener('input', function () {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length >= 2) {
            searchTimeout = setTimeout(() => {
                // Simulation d'une recherche
                console.log('Recherche pour:', query);
                // Ici vous pourriez implémenter une vraie recherche AJAX
            }, 300);
        }
    });

    // Gestion responsive
    function handleResize() {
        if (window.innerWidth <= 768) {
            sidebar.classList.remove('collapsed');
            sidebar.classList.remove('show');
            mainContent.classList.remove('expanded');
            sidebarOverlay.classList.remove('show');
        } else {
            if (sidebarCollapsed) {
                sidebar.classList.add('collapsed');
                mainContent.classList.add('expanded');
            }
        }
        updateSidebarToggleIcon();
    }

    window.addEventListener('resize', handleResize);

    // Animation des éléments au scroll
    function setupScrollAnimations() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-slide-up');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observer les éléments à animer
        document.querySelectorAll('.modern-card, .page-header, .modern-breadcrumb').forEach(el => {
            observer.observe(el);
        });
    }

    // Effet de survol avancé pour les boutons
    function setupAdvancedHovers() {
        document.querySelectorAll('.btn-modern').forEach(btn => {
            btn.addEventListener('mouseenter', function (e) {
                const ripple = document.createElement('span');
                ripple.style.position = 'absolute';
                ripple.style.borderRadius = '50%';
                ripple.style.background = 'rgba(255, 255, 255, 0.3)';
                ripple.style.transform = 'scale(0)';
                ripple.style.animation = 'ripple 0.6s linear';
                ripple.style.left = (e.layerX - 10) + 'px';
                ripple.style.top = (e.layerY - 10) + 'px';
                ripple.style.width = ripple.style.height = '20px';

                this.appendChild(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });
        });
    }

    // Theme switcher (bonus)
    function setupThemeSwitcher() {
        const themeToggle = document.querySelector('[data-theme-toggle]');
        if (themeToggle) {
            themeToggle.addEventListener('click', function () {
                const currentTheme = document.documentElement.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

                document.documentElement.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);

                createToast('success', 'Thème modifié', `Thème ${newTheme === 'dark' ? 'sombre' : 'clair'} activé`);
            });
        }
    }

    // Initialisation
    initSidebar();
    setupScrollAnimations();
    setupAdvancedHovers();
    setupThemeSwitcher();

    // Animation CSS pour les ripples
    const style = document.createElement('style');
    style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
                
                .sidebar-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    z-index: 1019;
                    opacity: 0;
                    visibility: hidden;
                    transition: all 0.3s ease;
                }
                
                .sidebar-overlay.show {
                    opacity: 1;
                    visibility: visible;
                }
                
                @media (max-width: 768px) {
                    .sidebar.show {
                        transform: translateX(0);
                        box-shadow: 0 0 50px rgba(0, 0, 0, 0.3);
                    }
                }
                
                /* Améliorations du dropdown */
                .dropdown-menu {
                    border-radius: 16px;
                    padding: 0.75rem 0;
                    margin-top: 0.5rem;
                    border: 1px solid rgba(148, 163, 184, 0.1);
                    backdrop-filter: blur(20px);
                    background: rgba(255, 255, 255, 0.95);
                }
                
                .dropdown-item {
                    padding: 0.75rem 1.5rem;
                    border-radius: 12px;
                    margin: 0 0.5rem;
                    transition: all 0.15s ease;
                    font-weight: 500;
                }
                
                .dropdown-item:hover {
                    background: rgba(99, 102, 241, 0.1);
                    color: var(--primary);
                    transform: translateX(4px);
                }
                
                .dropdown-header {
                    padding: 0.75rem 1.5rem 0.5rem;
                    font-weight: 700;
                    color: var(--primary);
                    border-bottom: 1px solid rgba(148, 163, 184, 0.1);
                    margin-bottom: 0.5rem;
                }
                
                /* Toast améliorés */
                .toast {
                    border-radius: 16px;
                    backdrop-filter: blur(20px);
                    background: rgba(255, 255, 255, 0.95);
                    border: 1px solid rgba(148, 163, 184, 0.1);
                    margin-bottom: 1rem;
                }
                
                .toast-body {
                    padding: 1.25rem;
                }
            `;
    document.head.appendChild(style);

    // Message de bienvenue
    setTimeout(() => {
        createToast('success', 'Bienvenue !', 'Interface d\'administration chargée avec succès.');
    }, 1000);
});
