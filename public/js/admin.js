// JavaScript pour l'interface admin
document.addEventListener('DOMContentLoaded', function () {
    // Éléments DOM
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const mainContent = document.getElementById('mainContent');
    const searchInput = document.querySelector('.search-input');
    const notificationBtn = document.getElementById('notificationBtn');

    // Variable pour l'état de la sidebar
    let sidebarCollapsed = false;
    let isMobile = window.innerWidth <= 768;

    // Toggle de la sidebar
    function toggleSidebar() {
        if (isMobile) {
            // Mobile: slide in/out
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            document.body.classList.toggle('sidebar-open');
        } else {
            // Desktop: collapse/expand
            sidebarCollapsed = !sidebarCollapsed;
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('sidebar-collapsed');

            // Sauvegarder l'état dans localStorage
            localStorage.setItem('sidebarCollapsed', sidebarCollapsed);
        }
    }

    // Event listeners pour le toggle de sidebar
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', toggleSidebar);
    }

    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', toggleSidebar);
    }

    // Raccourcis clavier
    document.addEventListener('keydown', function (e) {
        // Ctrl/Cmd + B pour toggle sidebar
        if ((e.ctrlKey || e.metaKey) && e.key === 'b') {
            e.preventDefault();
            toggleSidebar();
        }

        // Ctrl/Cmd + K pour focus sur la recherche
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if (searchInput) {
                searchInput.focus();
                searchInput.select();
            }
        }

        // Échap pour fermer la sidebar mobile
        if (e.key === 'Escape' && isMobile && sidebar.classList.contains('show')) {
            toggleSidebar();
        }
    });

    // Gestion du responsive
    function handleResize() {
        const wasMobile = isMobile;
        isMobile = window.innerWidth <= 768;

        if (wasMobile !== isMobile) {
            // Reset states when switching between mobile/desktop
            sidebar.classList.remove('show', 'collapsed');
            sidebarOverlay.classList.remove('show');
            mainContent.classList.remove('sidebar-collapsed');
            document.body.classList.remove('sidebar-open');

            if (!isMobile) {
                // Restaurer l'état de la sidebar desktop
                const savedState = localStorage.getItem('sidebarCollapsed');
                if (savedState === 'true') {
                    sidebarCollapsed = true;
                    sidebar.classList.add('collapsed');
                    mainContent.classList.add('sidebar-collapsed');
                }
            }
        }
    }

    // Listener pour le resize
    let resizeTimeout;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(handleResize, 150);
    });

    // Initialisation de l'état de la sidebar
    function initSidebar() {
        if (!isMobile) {
            const savedState = localStorage.getItem('sidebarCollapsed');
            if (savedState === 'true') {
                sidebarCollapsed = true;
                sidebar.classList.add('collapsed');
                mainContent.classList.add('sidebar-collapsed');
            }
        }
    }

    // Animation smooth scroll pour les liens internes
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Highlighting du menu actif basé sur l'URL
    function highlightActiveMenu() {
        const currentPath = window.location.pathname;
        const menuLinks = document.querySelectorAll('.sidebar-menu-link');

        menuLinks.forEach(link => {
            link.classList.remove('active');
            const href = link.getAttribute('href');

            if (href && (currentPath === href || currentPath.startsWith(href + '/'))) {
                link.classList.add('active');
            }
        });
    }

    // Recherche en temps réel (placeholder pour future implémentation)
    if (searchInput) {
        let searchTimeout;

        searchInput.addEventListener('input', function (e) {
            clearTimeout(searchTimeout);
            const query = e.target.value.trim();

            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    performSearch(query);
                }, 300);
            }
        });

        // Placeholder pour la fonction de recherche
        function performSearch(query) {
            console.log('Recherche pour:', query);
            // Implémentez ici votre logique de recherche
            // Par exemple: appel AJAX vers votre backend
        }
    }

    // Animation d'entrée pour les éléments
    function animateElements() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observer les éléments avec animation
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });
    }

    // Notification badge animation
    function animateNotificationBadge() {
        const badge = document.querySelector('.notification-badge');
        if (badge) {
            badge.style.animation = 'pulse 2s infinite';
        }
    }

    // CSS pour l'animation pulse
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
        
        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }
        
        .sidebar.collapsed .sidebar-section-title,
        .sidebar.collapsed .sidebar-menu-text,
        .sidebar.collapsed .sidebar-menu-badge {
            opacity: 0;
            visibility: hidden;
        }
        
        .sidebar.collapsed .sidebar-menu-link {
            justify-content: center;
            padding-left: 0;
            padding-right: 0;
            margin-right: 0;
            border-radius: 8px;
            margin: 4px 8px;
        }
        
        .sidebar-collapsed {
            margin-left: var(--sidebar-collapsed-width) !important;
        }
        
        @media (max-width: 768px) {
            .sidebar.collapsed {
                width: var(--sidebar-width);
            }
            
            .sidebar.collapsed .sidebar-section-title,
            .sidebar.collapsed .sidebar-menu-text,
            .sidebar.collapsed .sidebar-menu-badge {
                opacity: 1;
                visibility: visible;
            }
            
            .sidebar-collapsed {
                margin-left: 0 !important;
            }
        }
    `;
    document.head.appendChild(style);

    // Tooltips pour la sidebar collapsed
    function initTooltips() {
        const menuLinks = document.querySelectorAll('.sidebar-menu-link');

        menuLinks.forEach(link => {
            const text = link.querySelector('.sidebar-menu-text')?.textContent;
            if (text) {
                link.setAttribute('title', text);
            }
        });

        // Bootstrap tooltips si disponible
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    placement: 'right',
                    trigger: 'hover'
                });
            });
        }
    }

    // Toast notifications helper
    function showToast(message, type = 'info', duration = 5000) {
        const toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) return;

        const toastId = 'toast-' + Date.now();
        const toastHTML = `
            <div class="toast align-items-center text-bg-${type} border-0" role="alert" id="${toastId}" data-bs-autohide="true" data-bs-delay="${duration}">
                <div class="d-flex">
                    <div class="toast-body">
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;

        toastContainer.insertAdjacentHTML('beforeend', toastHTML);

        const toastElement = document.getElementById(toastId);
        if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            const toast = new bootstrap.Toast(toastElement);
            toast.show();

            toastElement.addEventListener('hidden.bs.toast', () => {
                toastElement.remove();
            });
        }
    }

    // Initialisation
    initSidebar();
    highlightActiveMenu();
    animateElements();
    animateNotificationBadge();
    initTooltips();

    // Exposer certaines fonctions globalement pour utilisation externe
    window.adminInterface = {
        showToast,
        toggleSidebar,
        highlightActiveMenu
    };

    console.log('✅ Interface Admin initialisée');
});