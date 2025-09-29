@extends('layouts.admin')

@section('title', 'Variantes de ' . $product->name)
@section('page-title', 'Variantes : ' . $product->name)

@section('content')

    <div class="bg-white p-6 rounded-xl shadow-lg max-w-4xl mx-auto">
        
        <div class="flex justify-between items-center mb-6 border-b pb-4">
            <h3 class="text-xl font-semibold text-gray-800">Gestion des {{ $product->variants->count() }} Variantes</h3>
            
            <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Modifier le Produit
            </a>
        </div>

        @if ($product->variants->isEmpty())
            <p class="text-gray-500 text-center py-8">
                Ce produit n'a pas encore de variantes. Veuillez le modifier pour en ajouter.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Taille
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Couleur
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Poids
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix Normal
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix Promotionnel
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Stock
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($product->variants as $variant)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $variant->size ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $variant->color ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $variant->weight ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{-- Prix normal barré si promo --}}
                                    @if ($variant->promotion_price)
                                        <span class="line-through text-gray-400">{{ number_format($variant->price, 0, ',', ' ') }} XAF</span>
                                    @else
                                        {{ number_format($variant->price, 0, ',', ' ') }} XAF
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                    {{-- Affichage du prix de promotion --}}
                                    @if ($variant->promotion_price)
                                        <span class="text-red-600">{{ number_format($variant->promotion_price, 0, ',', ' ') }} XAF</span>
                                    @else
                                        <span class="text-gray-400">Non applicable</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold">
                                    <span class="px-2 inline-flex text-xs leading-5 rounded-full 
                                        {{ $variant->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $variant->stock }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="mt-8 border-t pt-4 flex justify-start">
            <a href="{{ route('admin.products.index') }}" class="px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition duration-150">
                ← Retour à la Liste des Produits
            </a>
        </div>

    </div>

@endsection