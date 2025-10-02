@extends('layouts.admin')

@section('title', 'Gestion des Commandes')

@section('content')
    <div class="space-y-8">
        <header class="flex justify-between items-center pb-4 border-b border-gray-200">
            <h1 class="text-3xl font-bold text-gray-900">Gestion des Commandes</h1>
        </header>

        {{-- Messages de Session (Succès/Erreur) --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        {{-- Barre de Filtre des Statuts --}}
        <div class="bg-white p-4 rounded-xl shadow-md flex flex-wrap gap-3 text-sm font-medium">
            @php
                // Définition des libellés et couleurs des statuts
                $statuses = [
                    'all' => ['label' => 'Toutes', 'color' => 'gray'],
                    'pending' => ['label' => 'En Attente', 'color' => 'red'],
                    'processing' => ['label' => 'En Cours', 'color' => 'yellow'],
                    'shipped' => ['label' => 'Expédiée', 'color' => 'blue'],
                    'completed' => ['label' => 'Terminée', 'color' => 'green'],
                    'cancelled' => ['label' => 'Annulée', 'color' => 'gray'],
                ];
                
                // Calcul du total pour le filtre 'Toutes'
                $totalOrders = $statusCounts->sum();
            @endphp

            <a href="{{ route('admin.orders.index') }}" 
               class="px-3 py-1 rounded-full border 
                      {{ !$status ? 'bg-indigo-600 text-white border-indigo-700' : 'text-gray-700 hover:bg-gray-100 border-gray-300' }}">
                Toutes ({{ $totalOrders }})
            </a>
            
            @foreach ($statuses as $key => $data)
                @if ($key !== 'all' && $statusCounts->get($key, 0) > 0)
                    @php
                        $isActive = $status === $key;
                        $baseColor = $data['color'];
                        $bgColor = $isActive ? "bg-{$baseColor}-600 text-white border-{$baseColor}-700" : "bg-{$baseColor}-100 text-{$baseColor}-800 hover:bg-{$baseColor}-200 border-{$baseColor}-300";
                    @endphp
                    <a href="{{ route('admin.orders.index', ['status' => $key]) }}" 
                       class="px-3 py-1 rounded-full border {{ $bgColor }}">
                        {{ $data['label'] }} ({{ $statusCounts->get($key, 0) }})
                    </a>
                @endif
            @endforeach
        </div>

        {{-- Tableau des Commandes --}}
        <div class="bg-white rounded-xl shadow-lg overflow-x-auto">
            @if ($orders->isEmpty())
                <p class="p-6 text-gray-500 text-center">Aucune commande n'a été trouvée pour ce statut.</p>
            @else
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID Commande
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Client
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statut
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $order->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $order->customer->name ?? 'Client Inconnu' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                    {{ number_format($order->total_price, 0, ',', ' ') }} F CFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        // Définition locale des couleurs pour la table
                                        $color = $order->status == 'pending' ? 'red' : ($order->status == 'processing' ? 'yellow' : ($order->status == 'completed' ? 'green' : 'gray'));
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{{ $color }}-100 text-{{ $color }}-800">
                                        {{ $statuses[$order->status]['label'] ?? ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium flex justify-end space-x-2">
                                    
                                    {{-- Action: Confirmer (si 'pending') --}}
                                    @if ($order->status === 'pending')
                                        <form action="{{ route('admin.orders.confirm', $order) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-sm font-medium text-green-600 hover:text-green-900 p-1 rounded hover:bg-green-50 transition duration-150">
                                                <i class="fas fa-check-circle mr-1"></i> Confirmer
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Action: Annuler (si ni 'completed' ni 'cancelled') --}}
                                    @if ($order->status !== 'completed' && $order->status !== 'cancelled')
                                        <form action="{{ route('admin.orders.cancel', $order) }}" method="POST">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir annuler la commande #{{ $order->id }} ?')"
                                                    class="text-sm font-medium text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition duration-150">
                                                <i class="fas fa-times-circle mr-1"></i> Annuler
                                            </button>
                                        </form>
                                    @endif
                                    
                                    {{-- Action: Détails --}}
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-900 p-1 rounded hover:bg-indigo-50 transition duration-150">
                                        <i class="fas fa-info-circle mr-1"></i> Détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
                {{-- Pagination --}}
                <div class="p-4">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
