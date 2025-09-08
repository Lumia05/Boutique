<h1>Liste des Commandes</h1>

<table>
    <thead>
        <tr>
            <th>ID Commande</th>
            <th>Client</th>
            <th>Statut</th>
            <th>Prix Total</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'N/A' }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ number_format($order->total_price, 2) }} FCFA</td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}">Voir</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $orders->links() }}