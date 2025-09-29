@extends('layouts.admin')

@section('content')
    <h1>Détails de la Commande #{{ $order->id }}</h1>

    {{-- 1. Informations du Client, Adresses, Statut --}}
    {{-- 2. TABLEAU DES LIGNES DE COMMANDE (Order Items) --}}
    <h2 class="mt-8">Produits Commandés</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix Unitaire</th>
                <th>Sous-total</th>
            </tr>
        </thead>
        <tbody>
            {{-- Boucle sur la relation $order->items --}}
            @foreach ($order->items as $item) 
            <tr>
                <td>{{ $item->product->name }}</td> 
                <td>{{ $item->quantity }}</td>
                <td>{{ $item->unit_price }}</td>
                <td>{{ $item->quantity * $item->unit_price }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    {{-- 3. Totaux --}}
    @endsection