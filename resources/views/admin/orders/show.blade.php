@extends('layouts.admin')

@section('title', 'Détails Commande #' . $order->id)
@section('page-title', 'Commande #' . $order->id . ' | ' . ucfirst($order->status))

@section('content')

    {{-- Alertes de succès/erreur --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if (session('error'))
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <p>{{ session('error') }}</p>
        </div>
    @endif

    <div class="space-y-8">
        {{-- ======================================================= --}}
        {{-- BLOC 1: INFOS CLÉS & GESTION DU STATUT --}}
        {{-- ======================================================= --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- 1. Statut Actuel --}}
            <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg border-t-4 border-indigo-500">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Statut de la Commande</h3>
                <div class="flex items-center space-x-3 mb-4">
                    @php
                        $statusClass = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'processing' => 'bg-blue-100 text-blue-800',
                            'shipped' => 'bg-indigo-100 text-indigo-800',
                            'completed' => 'bg-green-100 text-green-800',
                            'cancelled' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="text-lg font-bold">Actuel:</span>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusClass[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                {{-- Formulaire de changement de statut --}}
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PUT')
                    <div class="flex space-x-2 items-end">
                        <div class="flex-grow">
                            <label for="status" class="block text-sm font-medium text-gray-700">Changer le statut en:</label>
                            <select id="status" name="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                @foreach (['pending' => 'En Attente', 'processing' => 'En Cours de Traitement', 'shipped' => 'Expédiée', 'completed' => 'Terminée', 'cancelled' => 'Annulée'] as $value => $label)
                                    <option value="{{ $value }}" @if($order->status === $value) selected @endif>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Mettre à jour
                        </button>
                    </div>
                </form>
                @error('status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>


            {{-- 2. Détails du Client --}}
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg border-t-4 border-red-500">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Informations Client</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                    <div class="sm:col-span-1">
                        <dt class="font-medium text-gray-500">Nom complet:</dt>
                        <dd class="text-gray-900 font-semibold">{{ $order->customer->name ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="font-medium text-gray-500">Téléphone:</dt>
                        <dd class="text-gray-900">{{ $order->customer->phone ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="font-medium text-gray-500">Email:</dt>
                        <dd class="text-gray-900">{{ $order->customer->email ?? 'N/A' }}</dd>
                    </div>
                    <div class="sm:col-span-1">
                        <dt class="font-medium text-gray-500">Date de commande:</dt>
                        <dd class="text-gray-900">{{ $order->created_at->format('d/m/Y H:i') }}</dd>
                    </div>
                    <div class="sm:col-span-2 mt-3 pt-3 border-t">
                        <dt class="font-medium text-gray-500">Adresse de Livraison ({{ ucfirst($order->option ?? 'N/A') }}):</dt>
                        <dd class="text-gray-900 font-bold">
                            @if(($order->option ?? 'N/A') === 'home')
                                {{ $order->delivery_address ?? 'Adresse non spécifiée' }}
                            @else
                                Retrait en magasin (Pas d'adresse de livraison requise)
                            @endif
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        {{-- ======================================================= --}}
        {{-- BLOC 2: ARTICLES COMMANDÉS --}}
        {{-- ======================================================= --}}
        <div class="bg-white p-6 rounded-xl shadow-lg">
            {{-- CORRECTION APPLIQUÉE ICI : Utilisation de $order->orderItems --}}
            <h3 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Articles Commandés ({{ $order->orderItems->count() }})</h3>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variante</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Unitaire</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sous-total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($order->orderItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->variant->product->name ?? 'Produit Inconnu' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->variant->name ?? 'Variante Standard' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ number_format($item->price, 0, ',', ' ') }} F CFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->quantite }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                    {{ number_format($item->price * $item->quantite, 0, ',', ' ') }} F CFA
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totaux --}}
            <div class="mt-6 flex justify-end">
                <div class="w-full sm:w-1/2 lg:w-1/3 space-y-2">
                    <div class="flex justify-between border-t pt-2">
                        <span class="text-md font-semibold text-gray-800">TOTAL FINAL:</span>
                        <span class="text-lg font-extrabold text-red-600">
                            {{ number_format($order->total_price, 0, ',', ' ') }} F CFA
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Bouton de retour --}}
        <div class="flex justify-start">
            <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <i class="fas fa-arrow-left mr-2"></i> Retour à la liste
            </a>
        </div>

    </div>
@endsection
