@extends('layouts.master')

@section('content')
    @include('layouts.status')

    <main class="product-management-section py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <a href="{{ url('index') }}" class="text-dark me-3"><i class="bi bi-arrow-left"></i></a>
                    <h2 class="title-main mb-0 h3">Gestion des catégories</h2>
                </div>
                <button class="btn btn-dark-custom btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-lg me-2"></i>Ajouter
                </button>
            </div>

            <div class="row g-4">
                @foreach ($categories as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="admin-product-card">
                            <div class="p-3">
                                <h5 class="fw-bold mb-1">{{ $item->nom_categorie }}</h5>
                                <br>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary w-100 btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal{{ $item->id_categorie }}">
                                        <i class="bi bi-pencil-square me-2"></i>Modifier
                                    </button>

                                    <button class="btn btn-danger-soft btn-sm px-3" data-bs-toggle="modal"
                                        data-bs-target="#deleteProductModal{{ $item->id_categorie }}">
                                        <i class="bi bi-trash"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editProductModal{{ $item->id_categorie }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Modification</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('categories.update', $item->id_categorie) }}" method="POST"
                                        role="form">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <label class="form-label-sm">Libelle</label>
                                            <input name="categorie" required type="text"
                                                class="input-checkout border-gold-focus" value="{{ $item->nom_categorie }}"
                                                placeholder="Nom de la catégorie">
                                        </div>
                                        <button type="submit" class="btn btn-secondary w-100 py-3 mt-2">Modifier</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteProductModal{{ $item->id_categorie }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('categories.destroy', $item->id_categorie) }}" method="POST"
                                        role="form">
                                        @csrf
                                        @method('DELETE')
                                        <div class="mb-3">
                                            <span>
                                                Êtes-vous sûr de vouloir supprimer cette catégorie ?
                                            </span>
                                        </div>
                                        <button type="submit" class="btn btn-danger w-100 py-3 mt-2">Supprimer</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <div class="modal fade" id="addProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Ajouter une catégorie</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('categories.store') }}" method="POST" role="form">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-sm">Libelle</label>
                            <input name="categorie" required type="text" class="input-checkout border-gold-focus"
                                placeholder="Nom de la catégorie">
                        </div>
                        <button type="submit" class="btn btn-dark-custom w-100 py-3 mt-2">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
