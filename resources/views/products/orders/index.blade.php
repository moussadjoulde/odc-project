@extends('layouts.app')

@section('title', 'Mes Commandes')

@section('content')
    @livewire('my-orders')
@endsection

@push('styles')
    <style>
        /* Styles supplémentaires pour améliorer l'UX Livewire */
        [wire\:loading] {
            opacity: 0.7;
        }

        .opacity-50 {
            opacity: 0.5 !important;
        }

        /* Animation de chargement */
        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        .loading-pulse {
            animation: pulse 1.5s ease-in-out infinite;
        }

        /* Style pour les notifications temporaires */
        .alert {
            animation: slideInDown 0.3s ease-out;
        }

        @keyframes slideInDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Amélioration visuelle des boutons pendant le chargement */
        .btn[wire\:loading] .spinner-border {
            width: 1rem;
            height: 1rem;
        }

        /* Transition fluide pour les éléments qui changent */
        .floating-card {
            transition: all 0.3s ease;
        }

        .floating-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        /* Style pour les badges de statut */
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
        }

        /* Responsive improvements */
        @media (max-width: 768px) {
            .btn-sm {
                font-size: 0.75rem;
                padding: 0.25rem 0.5rem;
            }

            .floating-card .d-flex.gap-2 {
                gap: 0.5rem !important;
            }

            .floating-card .btn {
                min-width: auto;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Notifications
            Livewire.on('showNotification', (message, type, duration = 5000) => {
                showToast(message, type, duration);
            });

            // Confirmation annulation commande
            Livewire.on('confirmOrderCancellation', (orderId, componentId) => {
                if (confirm(
                        'Êtes-vous sûr de vouloir annuler cette commande ? Cette action est irréversible.'
                        )) {
                    Livewire.find(componentId).call('confirmCancelOrder', orderId);
                }
            });

            // Tracking modal
            Livewire.on('openTrackingModal', (trackingNumber) => {
                openTrackingModal(trackingNumber);
            });

            // Review modal
            Livewire.on('openReviewModal', (orderId, componentId) => {
                openReviewModal(orderId, componentId);
            });

            // Toasts
            function showToast(message, type = 'info', duration = 5000) {
                const toast = document.createElement('div');
                toast.className =
                    `toast align-items-center text-white bg-${type === 'error' ? 'danger' : type} border-0`;
                toast.setAttribute('role', 'alert');
                toast.setAttribute('aria-live', 'assertive');
                toast.setAttribute('aria-atomic', 'true');

                toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">${message}</div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

                let toastContainer = document.querySelector('.toast-container');
                if (!toastContainer) {
                    toastContainer = document.createElement('div');
                    toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
                    toastContainer.style.zIndex = '1055';
                    document.body.appendChild(toastContainer);
                }

                toastContainer.appendChild(toast);

                const bootstrapToast = new bootstrap.Toast(toast, {
                    delay: duration
                });
                bootstrapToast.show();

                toast.addEventListener('hidden.bs.toast', () => {
                    toast.remove();
                });
            }

            // Review modal (corrigé)
            window.submitReview = function() {
                const modal = document.getElementById('reviewModal');
                const orderId = modal.getAttribute('data-order-id');
                const componentId = modal.getAttribute('data-component-id');
                const form = document.getElementById('reviewForm');
                const formData = new FormData(form);

                Livewire.find(componentId).call('submitReview', orderId, {
                    rating: formData.get('rating'),
                    comment: formData.get('comment'),
                    recommend: formData.get('recommend') ? true : false
                });

                bootstrap.Modal.getInstance(modal).hide();
                showToast('Avis soumis avec succès !', 'success');
            };
        });
    </script>
@endpush
