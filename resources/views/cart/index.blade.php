<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Panier - Global Retail Business</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Nécessaire pour les formulaires PUT/DELETE --}}
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                <a href="/a-propos" class="text-gray-700 hover:text-red-600 transition duration-300">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-red-600 transition duration-300">Contact</a>
                <a href="{{ route('cart.index') }}" class="relative text-red-600 font-semibold">
                    Panier
                    {{-- Le $cart est utilisé pour le décompte --}}
                    @php 
                        $cartCount = count($cart ?? \Illuminate\Support\Facades\Session::get('cart', [])); 
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto mt-8 px-6 py-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-6 border-b-2 border-red-600 pb-2">Votre Panier d'Achat</h1>

        <div class="bg-white p-8 rounded-lg shadow-xl">
            {{-- Message de succès/erreur (si applicable) --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if (count($cart) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Produit</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix Unitaire</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantité</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($cart as $variantId => $item)
                                @php
                                    $price = $item['promotion_price'] ?? $item['price'];
                                    $subtotal = $price * $item['quantity'];
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <div class="flex items-start">
                                            {{-- AFFICHAGE DE L'IMAGE --}}
                                            <img src="{{ $item['image'] ?? 'https://placehold.co/64x64/f3f4f6/333?text=ID' }}" alt="{{ $item['name'] }}" class="h-16 w-16 object-cover rounded-md mr-4 shadow-sm border border-gray-100">
                                            <div>
                                                <span class="block font-bold text-base">{{ $item['name'] }}</span>
                                                
                                                {{-- AFFICHAGE DES VARIANTES (SIZE/COLOR) --}}
                                                <div class="mt-1 text-xs text-gray-500 space-x-2">
                                                    @if(isset($item['color']))
                                                        <span class="inline-block bg-gray-100 px-2 py-0.5 rounded-full">Couleur: {{ $item['color'] }}</span>
                                                    @endif
                                                    @if(isset($item['size']))
                                                        <span class="inline-block bg-gray-100 px-2 py-0.5 rounded-full">Taille: {{ $item['size'] }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($price, 0, ',', ' ') }} FCFA</td>
                                    
                                    {{-- FORMULAIRE DE MISE À JOUR DE LA QUANTITÉ (Soumission classique) --}}
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                        <form action="{{ route('cart.update', ['variantId' => $variantId]) ?? '#' }}" method="POST" class="flex items-center space-x-2">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" 
                                                   name="quantity" 
                                                   value="{{ $item['quantity'] }}" 
                                                   min="1" 
                                                   class="w-16 border border-gray-300 rounded-md shadow-sm p-1 text-center focus:ring-red-500 focus:border-red-500 text-sm">
                                            {{-- BOUTON DE SOUMISSION DU FORMULAIRE DE QUANTITÉ --}}
                                            <button type="submit" 
                                                    class="p-1 text-green-600 hover:text-green-800 transition duration-150" 
                                                    title="Mettre à jour la quantité">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        {{-- BOUTON RETIRER FONCTIONNEL --}}
                                        <form action="{{ route('cart.remove', ['variantId' => $variantId]) ?? '#' }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 transition duration-150" title="Retirer l'article">
                                                <i class="fas fa-trash-alt mr-1"></i> Retirer
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                            {{-- Ligne de total général --}}
                            <tr class="bg-gray-50 font-bold text-base">
                                <td colspan="3" class="px-6 py-4 text-right text-gray-900 uppercase">Total Général</td>
                                {{-- Le total est toujours calculé par le contrôleur à chaque rechargement --}}
                                <td class="px-6 py-4 whitespace-nowrap text-red-600">{{ number_format($total ?? 0, 0, ',', ' ') }} FCFA</td>
                                <td></td>
                            </tr>

                        </tbody>
                    </table>
                </div>

                <div class="flex justify-end mt-6 space-x-4">
                    <a href="/produits" class="py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition duration-300">
                        <i class="fas fa-angle-left mr-1"></i> Continuer les achats
                    </a>
                    <a href="{{ route('checkout.index') ?? '#' }}" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 transition duration-300">
                        <i class="fas fa-credit-card mr-1"></i> Passer à la Caisse
                    </a>
                </div>

            @else
                <div class="text-center py-12 border-4 border-dashed border-gray-200 rounded-lg">
                    <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                    <p class="text-xl font-semibold text-gray-600 mb-4">Votre panier est vide.</p>
                    <p class="text-gray-500 mb-6">Ajoutez des produits pour commencer votre commande.</p>
                    <a href="/produits" class="py-2 px-6 border border-transparent rounded-full shadow-sm text-md font-medium text-white bg-red-600 hover:bg-red-700 transition duration-300">
                        Découvrir nos produits
                    </a>
                </div>
            @endif
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

</body>
</html>
