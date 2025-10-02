@extends('layouts.admin')

@section('title', 'Profil Client : ' . $customer->name)

@section('content')
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-6">
            Profil Client : {{ $customer->name }}
        </h1>

        <!-- Messages Flash -->
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded-lg" role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 rounded-lg" role="alert">
                <p>{{ session('error') }}</p>
            </div>
        @endif
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Informations Client et Mise à Jour -->
            <div class="lg:col-span-1 bg-white p-6 rounded-xl shadow-lg h-fit">
                <h2 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">Détails du Client</h2>
                
                <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Champ Nom -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-600">Nom</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $customer->name) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 p-2 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 p-2 @error('email') border-red-500 @enderror">
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Champ Téléphone (Exemple) -->
                    <div class="mb-4">
                        <label for="phone" class="block text-sm font-medium text-gray-600">Téléphone</label>
                        <input type="text" id="phone" name="phone" value="{{ old('phone', $customer->phone ?? 'N/A') }}" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 p-2 @error('phone') border-red-500 @enderror">
                    </div>
                    
                    <!-- Champ Adresse (Exemple) -->
                    <div class="mb-6">
                        <label for="address" class="block text-sm font-medium text-gray-600">Adresse</label>
                        <textarea id="address" name="address" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500 p-2">{{ old('address', $customer->address ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-150">
                        Mettre à Jour le Profil
                    </button>
                </form>

            </div>

            <!-- Historique des Commandes -->
            <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-bold text-gray-700 mb-4 border-b pb-2">
                    Historique des Commandes ({{ $customer->order->count() }} total)
                </h2>
                
                @if($customer->order->isEmpty())
                    <div class="text-gray-500 italic p-4 bg-gray-50 rounded-lg">
                        Ce client n'a pas encore passé de commande.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Commande</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                                    <th class="px-6 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($customer->order as $order)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            #{{ $order->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $order->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-bold">
                                            {{ number_format($order->total_price, 2, ',', ' ') }} FCFA
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <!-- Affichage coloré du statut (utiliser une fonction d'aide si disponible) -->
                                            @php
                                                $statusClasses = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'processing' => 'bg-blue-100 text-blue-800',
                                                    'shipped' => 'bg-indigo-100 text-indigo-800',
                                                    'completed' => 'bg-green-100 text-green-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusText = ucfirst($order->status);
                                            @endphp
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusText }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-red-600 hover:text-red-900 font-semibold">Voir Détails</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
                    <a href="{{ route('admin.customers.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-black hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                Revenir à la liste des clients
            </a>
        </div>
    </div>
@endsection
