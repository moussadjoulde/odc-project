<footer class="bg-dark text-light mt-5">
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <h5 class="text-white mb-3">{{ config('app.name', 'ModernShop') }}</h5>
                <p class="text-muted">Votre boutique en ligne moderne pour tous vos besoins. Qualité, style et innovation
                    réunis.</p>
                <div class="d-flex gap-3">
                    <a href="#" class="text-light"><i class="bi bi-facebook fs-4"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-twitter fs-4"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-instagram fs-4"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-linkedin fs-4"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-6 mb-4">
                <h6 class="text-white mb-3">Navigation</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-muted text-decoration-none">Accueil</a></li>
                    <li><a href="{{ url('/shop') }}" class="text-muted text-decoration-none">Boutique</a></li>
                    <li><a href="{{ url('/about') }}" class="text-muted text-decoration-none">À propos</a></li>
                    <li><a href="{{ url('/contact') }}" class="text-muted text-decoration-none">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <h6 class="text-white mb-3">Service Client</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted text-decoration-none">Support</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Livraison</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Retours</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">FAQ</a></li>
                </ul>
            </div>
            <div class="col-lg-3 mb-4">
                <h6 class="text-white mb-3">Newsletter</h6>
                <p class="text-muted mb-3">Restez informé de nos dernières offres</p>
                <div class="input-group">
                    <input type="email" class="form-control" placeholder="Votre email">
                    <button class="btn btn-primary" type="button">
                        <i class="bi bi-send"></i>
                    </button>
                </div>
            </div>
        </div>
        <hr class="my-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="text-muted mb-0">&copy; 2024 {{ config('app.name', 'ModernShop') }}. Tous droits réservés.</p>
            </div>
            <div class="col-md-6 text-md-end">
                <a href="#" class="text-muted text-decoration-none me-3">Conditions d'utilisation</a>
                <a href="#" class="text-muted text-decoration-none">Politique de confidentialité</a>
            </div>
        </div>
    </div>
</footer>
