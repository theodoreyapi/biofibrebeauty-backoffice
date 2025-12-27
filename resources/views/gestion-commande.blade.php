@extends('layouts.master')

@section('content')
    <style>
        .order-accordion-card {
            border-radius: 16px;
            border: 1px solid #eee;
        }

        .accordion-button {
            background: #fafafa;
            border-radius: 16px;
        }

        .accordion-button:not(.collapsed) {
            background: #fff;
            box-shadow: none;
        }

        .item-thumb-sm {
            width: 48px;
            height: 48px;
            object-fit: cover;
        }
    </style>

    <main class="order-management-section py-5">
        <div class="container">
            <div class="d-flex align-items-center mb-4">
                <a href="{{ url('index') }}" class="text-dark me-3"><i class="bi bi-arrow-left"></i></a>
                <h2 class="title-main mb-0 h3">Gestion des commandes</h2>
            </div>
            <div class="accordion" id="ordersAccordion">

                @forelse ($commandes as $commande)
                    <div class="accordion-item order-accordion-card mb-3">
                        <h2 class="accordion-header" id="heading{{ $commande->id_commande }}">
                            <button class="accordion-button collapsed d-flex justify-content-between" type="button"
                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $commande->id_commande }}">

                                <div class="d-flex flex-column flex-md-row gap-2 w-100 justify-content-between">
                                    <span class="fw-bold">ORD-{{ $commande->id_commande }}</span>

                                    <span class="text-muted small">
                                        {{ $commande->created_at->format('d/m/Y') }}
                                    </span>

                                    @if ($commande->statut_commande == 'pending')
                                        <span class="badge bg-warning text-dark">
                                            En attente
                                        </span>
                                    @elseif ($commande->statut_commande == 'completed')
                                        <span class="badge bg-success text-white">
                                            Livrer
                                        </span>
                                    @elseif ($commande->statut_commande == 'paid')
                                        <span class="badge bg-info text-white">
                                            Payer
                                        </span>
                                    @else
                                        <span class="badge bg-danger text-white">
                                            Annuler
                                        </span>
                                    @endif
                                    <span class="fw-bold text-gold">
                                        {{ number_format($commande->montant_produit, 0, ',', ' ') }} F CFA
                                    </span>
                                </div>
                            </button>
                        </h2>

                        <div id="collapse{{ $commande->id_commande }}" class="accordion-collapse collapse"
                            data-bs-parent="#ordersAccordion">

                            <div class="accordion-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <!-- Livraison -->
                                    <div class="mb-3">
                                        <small class="text-muted">Adresse de livraison</small>
                                        <p class="mb-0 fw-semibold">
                                            {{ $commande->adresse_livraison ?? 'Non renseignée' }}
                                        </p>
                                    </div>
                                    <div>
                                        <select class="form-select form-select-sm status-select fs-6"
                                            data-commande="{{ $commande->id_commande }}">
                                            <option value="pending" @selected($commande->statut_commande === 'pending')>
                                                En attente
                                            </option>
                                            <option value="paid" @selected($commande->statut_commande === 'paid')>
                                                Payé
                                            </option>
                                            <option value="completed" @selected($commande->statut_commande === 'completed')>
                                                Livré
                                            </option>
                                            <option value="cancelled" @selected($commande->statut_commande === 'cancelled')>
                                                Annulé
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <hr>

                                <!-- Articles -->
                                <div class="mb-3">
                                    <small class="text-muted">Articles</small>

                                    <div class="d-flex align-items-center gap-3 mt-2">
                                        <img src="{{ $commande->image_produit ?: 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?q=80&w=100' }}"
                                            class="item-thumb-sm rounded">

                                        <div>
                                            <div class="fw-bold">{{ $commande->nom_produit }}</div>
                                            <small class="text-muted">Quantité : x{{ $commande->quantite }}</small>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- Footer -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        {{ $commande->created_at->format('d/m/Y H:i') }}
                                    </small>

                                    <span class="fw-bold fs-6">
                                        Total : {{ number_format($commande->montant_produit, 0, ',', ' ') }} F CFA
                                    </span>
                                </div>

                            </div>
                        </div>
                    </div>

                @empty
                    <div class="text-center text-muted py-5">
                        Aucune commande disponible
                    </div>
                @endforelse

            </div>

        </div>
    </main>

    <script>
        document.querySelectorAll('.status-select').forEach(select => {
            select.addEventListener('change', function() {

                const commandeId = this.dataset.commande;
                const statut = this.value;

                fetch(`/commandes/${commandeId}/statut`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            statut_commande: statut
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            this.classList.add('border-success');
                            setTimeout(() => this.classList.remove('border-success'), 1200);
                            location.reload();
                        } else {
                            alert('Payer avant d\'être livré.');
                        }
                    })
                    .catch(() => {
                        alert('Erreur serveur');
                    });
            });
        });
    </script>
@endsection
