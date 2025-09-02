@extends('layouts.app')

@section('content')
    @livewire('product-show', ['product' => $product])


    <style>
        .quantity-selector {
            width: 140px;
        }

        .quantity-btn {
            width: 40px;
            border-color: #dee2e6 !important;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
            background: transparent;
        }

        .nav-tabs .nav-link.active {
            color: #667eea;
            background: white;
            border-bottom: 3px solid #667eea !important;
            transform: translateY(3px);
        }

        .nav-tabs .nav-link:hover {
            color: #667eea;
            background: rgba(102, 126, 234, 0.05);
        }

        .product-description {
            line-height: 1.8;
            font-size: 1.1rem;
        }

        .specifications table td {
            padding: 0.75rem 0;
            border: none !important;
        }

        .specifications table td:first-child {
            width: 40%;
            color: #6c757d;
        }

        .rating-input {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .rating-input input {
            display: none;
        }

        .rating-input label {
            cursor: pointer;
            width: 30px;
            height: 30px;
            margin: 0 2px;
            position: relative;
        }

        .rating-input label .bi-star-fill {
            color: #ffc107;
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .rating-input input:checked~label .bi-star-fill,
        .rating-input label:hover .bi-star-fill,
        .rating-input label:hover~label .bi-star-fill {
            opacity: 1;
        }

        .rating-input input:checked~label .bi-star-fill {
            opacity: 1;
        }

        .rating-distribution .progress {
            background-color: #e9ecef;
            border-radius: 4px;
        }

        .review-item {
            border-left: 3px solid #667eea;
        }

        .review-item:hover {
            transform: translateX(5px);
            transition: transform 0.2s ease;
        }

        @media (max-width: 768px) {
            .price-current {
                font-size: 2rem !important;
            }

            .action-section .row {
                flex-direction: column;
            }

            .quantity-selector {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des boutons de quantité
            const quantityInput = document.getElementById('quantity');
            const decreaseBtn = document.querySelector('[data-action="decrease"]');
            const increaseBtn = document.querySelector('[data-action="increase"]');

            if (quantityInput && decreaseBtn && increaseBtn) {
                decreaseBtn.addEventListener('click', function() {
                    let value = parseInt(quantityInput.value);
                    if (value > 1) {
                        quantityInput.value = value - 1;
                    }
                });

                increaseBtn.addEventListener('click', function() {
                    let value = parseInt(quantityInput.value);
                    let max = parseInt(quantityInput.getAttribute('max'));
                    if (value < max) {
                        quantityInput.value = value + 1;
                    }
                });
            }

            // Initialiser les tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Gestion du formulaire d'ajout au panier
            const form = document.querySelector('.add-to-cart-form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Simulation d'ajout au panier (remplacez par votre logique)
                    const formData = new FormData(this);
                    const quantity = formData.get('quantity');

                    // Afficher un toast de succès
                    document.dispatchEvent(new CustomEvent('showToast', {
                        detail: {
                            type: 'success',
                            message: `${quantity} article(s) ajouté(s) au panier avec succès !`
                        }
                    }));

                    // Vous pouvez ensuite envoyer la requête AJAX ici
                    // fetch(this.action, { method: 'POST', body: formData })...
                });
            }

            // Animation des barres de progression
            const progressBars = document.querySelectorAll('.progress-bar');
            progressBars.forEach(bar => {
                const width = bar.style.width;
                bar.style.width = '0';
                setTimeout(() => {
                    bar.style.transition = 'width 1s ease-in-out';
                    bar.style.width = width;
                }, 100);
            });

            // Gestion interactive de la notation
            const starInputs = document.querySelectorAll('.rating-input input');
            starInputs.forEach(input => {
                input.addEventListener('change', function() {
                    console.log('Note sélectionnée:', this.value);
                });
            });

            const loadMoreBtn = document.getElementById('loadMoreReviews');

            if (loadMoreBtn) {
                loadMoreBtn.addEventListener('click', function() {
                    const productId = this.getAttribute('data-product-id');
                    const offset = parseInt(this.getAttribute('data-offset'));

                    // Désactiver le bouton pendant le chargement
                    this.disabled = true;
                    this.innerHTML = '<i class="spinner-border spinner-border-sm me-2"></i>Chargement...';

                    // Requête AJAX pour charger plus d'avis
                    fetch(`/products/${productId}/reviews/load-more?offset=${offset}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.success && data.reviews.length > 0) {
                                // Ajouter les nouveaux avis
                                document.getElementById('additional-reviews').insertAdjacentHTML(
                                    'beforeend', data.html);

                                // Mettre à jour l'offset
                                const newOffset = offset + data.reviews.length;
                                this.setAttribute('data-offset', newOffset);

                                // Réactiver le bouton
                                this.disabled = false;
                                this.innerHTML =
                                    '<i class="bi bi-chevron-down me-2"></i>Voir plus d\'avis';

                                // Masquer le bouton s'il n'y a plus d'avis
                                if (data.reviews.length < 5) {
                                    this.style.display = 'none';
                                }
                            } else {
                                // Plus d'avis à charger
                                this.style.display = 'none';
                            }
                        })
                        .catch(error => {
                            console.error('Erreur lors du chargement des avis:', error);
                            this.disabled = false;
                            this.innerHTML = '<i class="bi bi-chevron-down me-2"></i>Voir plus d\'avis';
                        });
                });
            }
        });
    </script>
@endsection
