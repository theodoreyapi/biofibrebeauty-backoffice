@extends('layouts.master')

@section('content')
    <main class="section-soft py-5">
        <div class="container">

            <div class="d-flex align-items-center mb-4">
                <a href="{{ url('index') }}" class="text-dark me-3">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h2 class="h3 mb-0">Gestion du stock</h2>
            </div>

            <div class="row g-4">
                @foreach ($stockFaible as $item)
                    <div class="col-lg-4 col-md-6">
                        <div class="card-soft p-3">
                            <div class="d-flex gap-3">
                                <img src="{{ $item->image_produit == '' ? 'https://images.unsplash.com/photo-1519699047748-de8e457a634e?q=80&w=800' : url($item->image_produit) }}"
                                    alt="{{ $item->nom_produit }}" class="img-square" alt="">
                                <div class="flex-grow-1">
                                    <h6 class="fw-semibold mb-1">{{ $item->nom_produit }}</h6>
                                    <p class="text-gold fw-bold small mb-3">
                                        {{ number_format($item->prix_produit, 0, ',', ' ') }} F CFA</p>
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-box text-muted small"></i>
                                        <input type="number" class="input-unit stock-input"
                                            value="{{ $item->stock_produit }}" data-id="{{ $item->id_produit }}"
                                            min="0">
                                        <span class="text-muted small">unités</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.stock-input').forEach(input => {
            const message = input.nextElementSibling;

            input.addEventListener('change', function() {
                const stock = this.value;
                const produitId = this.dataset.id;

                message.classList.remove('d-none');
                message.textContent = 'Mise à jour...';
                message.className = 'stock-message text-muted';

                fetch(`/produits/${produitId}/update-stock`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            stock
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            message.textContent = '✔ Stock mis à jour';
                            message.className = 'stock-message text-success';
                        } else {
                            throw new Error();
                        }
                    })
                    .catch(() => {
                        message.textContent = '❌ Erreur lors de la mise à jour';
                        message.className = 'stock-message text-danger';
                    });
            });
        });
    </script>
@endsection
