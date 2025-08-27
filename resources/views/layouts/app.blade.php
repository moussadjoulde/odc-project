<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Laravel')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --danger-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            --dark-gradient: linear-gradient(135deg, #434343 0%, #000000 100%);
            --light-bg: #f8f9fa;
            --card-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            --card-shadow-hover: 0 1rem 2rem rgba(0, 0, 0, 0.25);
            --border-radius: 0.75rem;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Navigation moderne */
        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .navbar-nav .nav-link {
            font-weight: 500;
            color: #495057 !important;
            transition: all 0.3s ease;
            position: relative;
            margin: 0 0.5rem;
        }

        .navbar-nav .nav-link:hover {
            color: #667eea !important;
            transform: translateY(-2px);
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--primary-gradient);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover::after {
            width: 100%;
        }

        /* Contenu principal */
        main {
            background: var(--light-bg);
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            margin-top: 2rem;
            min-height: calc(100vh - 120px);
            box-shadow: var(--card-shadow);
            position: relative;
            overflow: hidden;
        }

        main::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            z-index: 1;
        }

        /* Cartes modernes */
        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--card-shadow);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .card:hover {
            box-shadow: var(--card-shadow-hover);
            transform: translateY(-5px);
        }

        .card:hover::before {
            opacity: 1;
        }

        /* Boutons avec gradients */
        .btn-gradient-primary {
            background: var(--primary-gradient);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-gradient-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
            color: white;
        }

        .btn-gradient-success {
            background: var(--success-gradient);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .btn-gradient-warning {
            background: var(--warning-gradient);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        .btn-gradient-danger {
            background: var(--danger-gradient);
            border: none;
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius);
            transition: all 0.3s ease;
        }

        /* Tables modernes */
        .table {
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--card-shadow);
            background: white;
        }

        .table thead th {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.05em;
            color: #495057;
            padding: 1.25rem 1rem;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border: none;
        }

        .table tbody tr:hover {
            background-color: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }

        .table tbody td {
            border: none;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1.25rem 1rem;
            vertical-align: middle;
        }

        /* Badges modernes */
        .badge {
            border-radius: 50px;
            font-weight: 500;
            padding: 0.5rem 1rem;
        }

        .badge-gradient-primary {
            background: var(--primary-gradient);
        }

        .badge-gradient-success {
            background: var(--success-gradient);
        }

        /* Alertes */
        .alert {
            border-radius: var(--border-radius);
            border: none;
            font-weight: 500;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(67, 233, 123, 0.1) 0%, rgba(56, 249, 215, 0.1) 100%);
            color: #155724;
            border-left: 4px solid #43e97b;
        }

        /* Formulaires */
        .form-control {
            border-radius: var(--border-radius);
            border: 2px solid #e9ecef;
            transition: all 0.3s ease;
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.75rem;
        }

        /* Animation de chargement */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease forwards;
        }

        /* Header de page */
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 1rem;
        }

        .page-header p {
            color: #6c757d;
            font-size: 1.1rem;
        }

        /* Stats cards */
        .stat-card {
            background: white;
            border-radius: var(--border-radius);
            padding: 2rem;
            box-shadow: var(--card-shadow);
            border: none;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--card-shadow-hover);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #495057;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.05em;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-header h1 {
                font-size: 2rem;
            }
            
            main {
                margin-top: 1rem;
                border-radius: 0;
            }
            
            .stat-card {
                margin-bottom: 1rem;
            }
        }

        /* Animation float */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-box-seam me-2"></i>
                    {{ config('app.name', 'Laravel') }}
                </a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}">
                                <i class="bi bi-house me-1"></i>
                                Accueil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">
                                <i class="bi bi-box me-1"></i>
                                Produits
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.create') }}">
                                <i class="bi bi-plus-circle me-1"></i>
                                Ajouter
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- Contenu principal -->
        <main class="container-fluid">
            <div class="container py-4">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Bootstrap 5.3 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Animation script -->
    <script>
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.card, .table, .alert');
            elements.forEach((element, index) => {
                element.style.opacity = '0';
                element.style.transform = 'translateY(30px)';
                
                setTimeout(() => {
                    element.style.transition = 'all 0.6s ease';
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Confirmation de suppression améliorée
        function confirmDelete(message = 'Êtes-vous sûr de vouloir supprimer cet élément ?') {
            return confirm(message);
        }
    </script>
</body>
</html>