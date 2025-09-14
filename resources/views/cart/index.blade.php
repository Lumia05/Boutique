@extends('layouts.app')

@section('title', 'Mon panier')

@section('content')
    <div class="container my-5">
        <h1 class="h3 fw-bold text-danger mb-4">Mon panier</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if(empty($cart))
            <div class="alert alert-info text-center">Votre panier est vide.</div>
        @else
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover rounded-3 overflow-hidden">
                            <thead>
                                <tr>
                                    <th>Produit</th>
                                    <th>Prix</th>
                                    <th>Quantité</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $totalPrice = 0; @endphp
                                @foreach($cart as $id => $details)
                                    @php $totalPrice += $details['price'] * $details['quantity']; @endphp
                                    <tr>
                                        <td class="d-flex align-items-center">
                                            <img src="{{ asset($details['image']) }}" alt="{{ $details['name'] }}" style="width: 50px; height: 50px; object-fit: cover;" class="me-3 rounded-3">
                                            {{ $details['name'] }}
                                        </td>
                                        <td>{{ number_format($details['price'], 0, ',', '.') }} FCFA</td>
                                        <td>
                                            <form action="{{ route('cart.update') }}" method="POST" class="d-flex">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <input type="number" name="quantite" value="{{ $details['quantity'] }}" min="1" class="form-control form-control-sm" style="width: 80px;">
                                                <button type="submit" class="btn btn-sm btn-outline-secondary ms-2 rounded-pill">Mettre à jour</button>
                                            </form>
                                        </td>
                                        <td>{{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }} FCFA</td>
                                        <td>
                                            <form action="{{ route('cart.remove') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $id }}">
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill">Retirer</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end fw-bold h4 my-3">
                        Total du panier : {{ number_format($totalPrice, 0, ',', '.') }} FCFA
                    </div>
                    <div class="text-end">
                        <a href="{{ route('checkout.index') }}" class="btn btn-success btn-lg rounded-pill px-5">Passer à la caisse</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection