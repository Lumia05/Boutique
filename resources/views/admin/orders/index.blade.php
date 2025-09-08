@extends('admin.layout')

@section('title', 'Gestions des Commandes')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">

    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table  table-hover mb-0">
                    <thead class="bg-danger text-white">
                        <tr>
                            <th>ID Commande</th>
                            <th>Client</th>
                            <th>Statut</th>
                            <th>Prix Total</th>
                            <th>Date</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->id }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>{{ $order->status }}</td>
                                <td>{{ number_format($order->total_price, 2) }} FCFA</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-info btn-sm me-2">Valider</a>
                                         Valider
                                        </button>
                                    <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')">Supprimer</button>
                                    </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 <div class="d-flex justify-content-center mt-4">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>

            
              
 
