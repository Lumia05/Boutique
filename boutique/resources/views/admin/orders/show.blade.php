<h1>Détails de la Commande #{{ $order->id }}</h1>

<div>
    <h2>Informations Client</h2>
    <p>Nom : {{ $order->user->name ?? 'N/A' }}</p>
    <p>Email : {{ $order->user->email ?? 'N/A' }}</p>
    <p>Téléphone : {{ $order->user->phone_number ?? 'N/A' }}</p>
</div>

<hr>

<div>
    <h2>Statut et Paiement</h2>
    <p>Statut : {{ $order->status }}</p>
    <p>Mode de paiement : {{ $order->payment_method }}</p>
    <p>Date de la commande : {{ $order->created_at->format('d/m/Y H:i') }}</p>
</div>

<hr>

<div>
    <h2>Produits Commandés</h2>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name ?? 'Produit Supprimé' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->unit_price, 2) }} €</td>
                    <td>{{ number_format($item->unit_price * $item->quantity, 2) }} €</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<hr>

<div>
    <h2>Adresse</h2>
    <h3>Livraison</h3>
    <p>{{ $order->shipping_address }}</p>
    <h3>Facturation</h3>
    <p>{{ $order->billing_address }}</p>
</div>

<a href="{{ route('admin.orders.index') }}">Retour à la liste des commandes</a>