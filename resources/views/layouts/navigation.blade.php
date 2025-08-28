<nav class="navbar navbar-expand-lg navbar-modern fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <i class="bi bi-shop me-2 text-primary"></i>
            {{ config('app.name', 'ModernShop') }}
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Menu principal -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}">
                        <i class="bi bi-house me-1"></i>Accueil
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/shop') }}">
                        <i class="bi bi-bag me-1"></i>Boutique
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/about') }}">
                        <i class="bi bi-info-circle me-1"></i>À propos
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/contact') }}">
                        <i class="bi bi-envelope me-1"></i>Contact
                    </a>
                </li>
            </ul>

            <!-- Menu utilisateur -->
            <ul class="navbar-nav ms-auto">
                @livewire('cart-indicator')
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('Connexion') }}
                            </a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="btn btn-modern ms-2" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>{{ __('Inscription') }}
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center me-2"
                                style="width: 32px; height: 32px;">
                                <i class="bi bi-person text-white"></i>
                            </div>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ url('/profile') }}">
                                <i class="bi bi-person-circle me-2"></i>Mon Profil
                            </a>
                            <a class="dropdown-item" href="{{ url('/orders') }}">
                                <i class="bi bi-bag-check me-2"></i>Mes Commandes
                            </a>
                            <a class="dropdown-item" href="{{ url('/settings') }}">
                                <i class="bi bi-gear me-2"></i>Paramètres
                            </a>
                            @if (Auth::user()->hasRole('admin'))
                                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                    <i class="bi bi-shield-lock me-2"></i>Administration
                                </a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right me-2"></i>{{ __('Déconnexion') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
