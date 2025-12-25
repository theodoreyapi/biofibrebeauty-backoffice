@extends('layouts.master')

@section('content')
    @include('layouts.status')

    <main class="product-management-section py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <a href="{{ url('index') }}" class="text-dark me-3"><i class="bi bi-arrow-left"></i></a>
                    <h2 class="title-main mb-0 h3">Gestion des produits</h2>
                </div>
                <button class="btn btn-dark-custom btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal">
                    <i class="bi bi-plus-lg me-2"></i>Ajouter
                </button>
            </div>

            <div class="row g-4">
                @foreach ($produits as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="admin-product-card">
                            <div class="image-wrapper">
                                <img src="{{ $item->image_produit == '' ? 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?q=80&w=800' : $item->image_produit }}"
                                    alt="{{ $item->nom_produit }}" class="admin-product-img">
                            </div>
                            <div class="p-3">
                                <h5 class="fw-bold mb-1">{{ $item->nom_produit }}</h5>
                                <p class="text-muted small mb-3">
                                    {{ \Illuminate\Support\Str::limit($item->description_produit, 115) }}</p>
                                <p class="text-gold fw-bold mb-1">{{ number_format($item->prix_produit, 0, ',', ' ') }} F
                                    CFA</p>
                                <p class="text-muted small mb-3">{{ $item->nom_categorie }} • {{ $item->valeur_longueur }} •
                                    {{ $item->couleur_produit }}</p>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-secondary w-100 btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal{{ $item->id_produit }}">
                                        <i class="bi bi-pencil-square me-2"></i>Modifier
                                    </button>
                                    <button class="btn btn-danger-soft btn-sm px-3" data-bs-toggle="modal"
                                        data-bs-target="#deleteProductModal{{ $item->id_produit }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editProductModal{{ $item->id_produit }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Modification</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('produit.update', $item->id_produit) }}" method="POST"
                                        role="form" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label-sm">Nom <span class="text-danger">*</span> </label>
                                            <input name="libelle" required type="text" value="{{ $item->nom_produit }}"
                                                class="input-checkout border-gold-focus" placeholder="Nom du produit">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label-sm">Description</label>
                                            <textarea name="description" class="input-checkout" rows="3">{{ $item->description_produit }}</textarea>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label class="form-label-sm">Prix (FCFA) <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="prix" required class="input-checkout"
                                                    value="{{ $item->prix_produit }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label-sm">Couleur <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="couleur" required class="input-checkout"
                                                    value="{{ $item->couleur_produit }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label-sm">Quantité <span
                                                        class="text-danger">*</span></label>
                                                <input type="number" name="stock" required class="input-checkout"
                                                    value="{{ $item->stock_produit }}">
                                            </div>
                                        </div>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <label class="form-label-sm">Catégorie <span
                                                        class="text-danger">*</span></label>
                                                <select name="categorie" required class="input-checkout">
                                                    <option value="">Sélectionne</option>
                                                    @foreach ($categories as $cate)
                                                        <option @if ($item->categorie_id == $cate->id_categorie) selected @endif
                                                            value="{{ $cate->id_categorie }}">
                                                            {{ $cate->nom_categorie }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <label class="form-label-sm">Longueur <span
                                                        class="text-danger">*</span></label>
                                                <select name="longueur" required class="input-checkout">
                                                    <option value="">Sélectionne</option>
                                                    @foreach ($longueurs as $long)
                                                        <option @if ($item->longueur_id == $long->id_longueur) selected @endif
                                                            value="{{ $long->id_longueur }}">
                                                            {{ $long->valeur_longueur }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label-sm">Image <span class="text-danger">*</span></label>
                                            <input name="image" type="file" class="input-checkout"
                                                placeholder="Choisir une image">
                                        </div>
                                        <button type="submit" class="btn btn-secondary w-100 py-3 mt-2">Modifier</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="deleteProductModal{{ $item->id_produit }}" tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="modal-title fw-bold">Suppression</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body p-4">
                                    <form action="{{ route('produit.destroy', $item->id_produit) }}" method="POST"
                                        role="form">
                                        @csrf
                                        @method('DELETE')
                                        <div class="mb-3">
                                            <span>
                                                Êtes-vous sûr de vouloir supprimer cet produit ?
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
                    <h5 class="modal-title fw-bold">Ajouter un produit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('produit.store') }}" method="POST" role="form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label-sm">Nom <span class="text-danger">*</span> </label>
                            <input name="libelle" required type="text" class="input-checkout border-gold-focus"
                                placeholder="Nom du produit">
                        </div>
                        <div class="mb-3">
                            <label class="form-label-sm">Description</label>
                            <textarea name="description" class="input-checkout" rows="3"></textarea>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label-sm">Prix (FCFA) <span class="text-danger">*</span></label>
                                <input type="number" name="prix" required class="input-checkout" value="0">
                            </div>
                            <div class="col-6">
                                <label class="form-label-sm">Couleur <span class="text-danger">*</span></label>
                                <input type="text" name="couleur" required class="input-checkout">
                            </div>
                            <div class="col-6">
                                <label class="form-label-sm">Quantité <span class="text-danger">*</span></label>
                                <input type="number" name="stock" required class="input-checkout">
                            </div>
                        </div>
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label-sm">Catégorie <span class="text-danger">*</span></label>
                                <select name="categorie" required class="input-checkout">
                                    <option value="">Sélectionne</option>
                                    @foreach ($categories as $cate)
                                        <option value="{{ $cate->id_categorie }}">{{ $cate->nom_categorie }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label-sm">Longueur <span class="text-danger">*</span></label>
                                <select name="longueur" required class="input-checkout">
                                    <option value="">Sélectionne</option>
                                    @foreach ($longueurs as $long)
                                        <option value="{{ $long->id_longueur }}">{{ $long->valeur_longueur }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="form-label-sm">Image <span class="text-danger">*</span></label>
                            <input name="image" required type="file" class="input-checkout"
                                placeholder="Choisir une image">
                        </div>
                        <button type="submit" class="btn btn-dark-custom w-100 py-3 mt-2">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
