<div>
    <li class="nav-item me-3">
        <a class="nav-link position-relative" href="{{ url('/cart') }}">
            <i class="bi bi-cart3 fs-5"></i>
            @if ($cartCount > 0)
                <span class="position-absolute top-2 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $cartCount > 99 ? '99+' : $cartCount }}
                    <span class="visually-hidden">articles dans le panier</span>
                </span>
            @endif
        </a>
    </li>
</div>
