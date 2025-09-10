<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="icon" type="image/x-icon" href="/favicon.ico">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        .file-input {
            display: block !important;
            opacity: 1 !important;
        }
    </style>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <!-- Header d'administration -->
    @include('layouts.partials.admin.header')

    <!-- Sidebar -->
    @include('layouts.partials.admin.sidebar')

    <!-- Contenu principal -->
    <main class="main-content" id="mainContent">
        <!-- Breadcrumb -->
        <nav class="modern-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="#"><i class="bi bi-house-door me-1"></i>Accueil</a>
                </li>
                <li class="breadcrumb-item active">Tableau de bord</li>
            </ol>
        </nav>

        <!-- Zone de contenu dynamique -->
        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <!-- Overlay pour mobile -->
    <div class="sidebar-overlay d-md-none" id="sidebarOverlay"></div>

    <!-- Toast Container -->
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <!-- Les toasts seront injectés ici dynamiquement -->
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JavaScript personnalisé -->
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
