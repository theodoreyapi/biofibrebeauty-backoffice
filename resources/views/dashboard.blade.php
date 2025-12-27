@extends('layouts.master')

@section('content')
    <main class="dashboard-section py-5">
        <div class="container">
            <h2 class="title-main mb-4">Tableau de bord</h2>

            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon-circle bg-light-gold">
                            <i class="bi bi-graph-up-arrow text-gold"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Revenus</small>
                            <span class="stat-value">{{ $revenus }} F CFA</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon-circle bg-light-orange">
                            <i class="bi bi-bag text-warning"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">En attente</small>
                            <span class="stat-value">{{ $commandesEnAttente }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon-circle bg-light-blue">
                            <i class="bi bi-box-seam text-primary"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Produits</small>
                            <span class="stat-value">{{ $produitsCount }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon-circle bg-light-red">
                            <i class="bi bi-people text-danger"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Stock faible</small>
                            <span class="stat-value">{{ $stockFaible }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card">
                        <div class="stat-icon-circle bg-light-blue">
                            <i class="bi bi-people text-info"></i>
                        </div>
                        <div>
                            <small class="text-muted d-block">Clients</small>
                            <span class="stat-value">{{ $clientsCount }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <a href="{{ url('gestion') }}" class="action-card">
                        <i class="bi bi-bag-check text-gold mb-3"></i>
                        <h4>Gérer les commandes</h4>
                        <p>{{ $commandesEnAttente }} commande(s)</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ url('produit') }}" class="action-card">
                        <i class="bi bi-box-seam text-gold mb-3"></i>
                        <h4>Gérer les produits</h4>
                        <p>{{ $produitsCount }} produit(s)</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ url('stocks') }}" class="action-card">
                        <i class="bi bi-graph-up text-gold mb-3"></i>
                        <h4>Gérer le stock</h4>
                        <p>{{ $stockFaible }} alerte(s)</p>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="{{ url('categories') }}" class="action-card">
                        <i class="bi bi-tags text-gold mb-3"></i>
                        <h4>Catégories</h4>
                        <p>{{ $categoriesCount }} catégorie(s)</p>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ url('longueurs') }}" class="action-card">
                        <i class="bi bi-rulers text-gold mb-3"></i>
                        <h4>Longueurs</h4>
                        <p>{{ $longueursCount }} longueur(s)</p>
                    </a>
                </div>

                <div class="col-md-4">
                    <a href="{{ url('clients') }}" class="action-card">
                        <i class="bi bi-people text-gold mb-3"></i>
                        <h4>Clients</h4>
                        <p>{{ $clientsCount }} client(s)</p>
                    </a>
                </div>

            </div>

            <div class="recent-orders-card">
                <h3 class="title-main h4 mb-4">Commandes récentes</h3>
                @foreach ($commandesRecentes as $commande)
                    <div class="order-list-item">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <div>
                                <strong class="order-ref">ORD-{{ $commande->id_commande }}</strong>
                                <p class="mb-0 text-muted small">{{ $commande->nom_complet }}</p>
                            </div>
                            <div class="text-end">
                                <span
                                    class="text-gold fw-bold">{{ number_format($commande->montant_produit, 0, ',', ' ') }}
                                    F CFA</span>
                                <p class="mb-0 text-muted small">
                                    @if ($commande->statut_commande == 'pending')
                                        En attente
                                    @elseif ($commande->statut_commande == 'completed')
                                        Livrer
                                    @else
                                        Annuler
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>
@endsection
