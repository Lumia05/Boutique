<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passer à la Caisse - Global Retail Business</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
        </div>
    </header>

    <main class="container mx-auto mt-8 px-6 py-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8 border-b-2 border-red-600 pb-2">Finaliser la Commande</h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Colonne 1: Formulaire Client --}}
            <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-lg shadow-xl">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6">Informations de Livraison</h2>

                <form action="{{ route('checkout.store') }}" method="POST">
                    @csrf
                    
                    {{-- Champs d'information client --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 required">Nom Complet</label>
                            <input type="text" name="name" id="name" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-red-500 focus:border-red-500 @error('name') border-red-500 @enderror"
                                value="{{ old('name') }}">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 required">Numéro de Téléphone</label>
                            <input type="tel" name="phone" id="phone" required
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-red-500 focus:border-red-500 @error('phone') border-red-500 @enderror"
                                value="{{ old('phone') }}">
                            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse Email (Optionnel)</label>
                            <input type="email" name="email" id="email"
                                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-red-500 focus:border-red-500 @error('email') border-red-500 @enderror"
                                value="{{ old('email') }}">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Section Options de Livraison --}}
                    <h3 class="text-xl font-semibold text-gray-800 mb-4 border-t pt-4">Option de Livraison</h3>
                    <div class="space-y-4">
                        {{-- Option 1: Retrait (Pickup) --}}
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg bg-gray-50 cursor-pointer transition duration-200 hover:border-red-500">
                            <input id="pickup-option" name="delivery_option" type="radio" value="pickup" 
                                class="h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500" 
                                checked onchange="updateTotal(this.value)">
                            <label for="pickup-option" class="ml-3 block text-base font-medium text-gray-900 flex justify-between w-full">
                                <span>Retrait en Magasin</span>
                                <span class="text-green-600 font-bold">Gratuit</span>
                            </label>
                        </div>

                        {{-- Option 2: Domicile (Home) --}}
                        <div class="flex items-center p-4 border border-gray-200 rounded-lg bg-gray-50 cursor-pointer transition duration-200 hover:border-red-500">
                            <input id="home-option" name="delivery_option" type="radio" value="home" 
                                class="h-4 w-4 text-red-600 border-gray-300 focus:ring-red-500" 
                                onchange="updateTotal(this.value)">
                            <label for="home-option" class="ml-3 block text-base font-medium text-gray-900 flex justify-between w-full">
                                <span>Livraison à Domicile</span>
                                <span class="text-red-600 font-bold">+ 2 000 FCFA</span>
                            </label>
                        </div>
                    </div>
                    @error('delivery_option')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                    {{-- Champ Adresse (Apparaît si Domicile est sélectionné) --}}
                    <div id="address-field" class="mt-6 hidden">
                        <label for="address" class="block text-sm font-medium text-gray-700 required">Adresse Complète (Quartier, Ville, etc.)</label>
                        <textarea name="address" id="address" rows="3"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-3 focus:ring-red-500 focus:border-red-500 @error('address') border-red-500 @enderror">{{ old('address') }}</textarea>
                        @error('address')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    
                    <div class="mt-8">
                         <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-red-600 hover:bg-red-700 transition duration-300">
                            <i class="fas fa-money-check-alt mr-2"></i> Payer la Commande
                        </button>
                    </div>
                    
                </form>
            </div>

            {{-- Colonne 2: Récapitulatif de Commande --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-lg shadow-xl sticky top-4">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-6 border-b pb-2">Votre Commande</h2>
                    
                    {{-- Liste des articles (simplifiée) --}}
                    <div class="space-y-4 border-b pb-4 mb-4">
                        @foreach ($cart as $item)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                <span>{{ number_format(($item['promotion_price'] ?? $item['price']) * $item['quantity'], 0, ',', ' ') }} FCFA</span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Détails du total --}}
                    <div class="space-y-3">
                        <div class="flex justify-between text-gray-700 font-medium">
                            <span>Sous-Total des Articles</span>
                            <span id="subtotal-display">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        <div class="flex justify-between text-gray-700 font-medium border-t pt-3">
                            <span>Frais de Livraison</span>
                            <span id="delivery-fee-display" class="text-red-600">{{ number_format($deliveryFee, 0, ',', ' ') }} FCFA</span>
                        </div>
                        
                        <div class="flex justify-between text-xl font-bold text-gray-900 border-t pt-4 mt-4">
                            <span>Total Général</span>
                            <span id="grand-total-display">{{ number_format($grandTotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

    <script>
        // Valeurs de base utilisées par le script
        const baseSubtotal = {{ $total }};
        const deliveryCost = 2000;
        const addressField = document.getElementById('address-field');
        const deliveryFeeDisplay = document.getElementById('delivery-fee-display');
        const grandTotalDisplay = document.getElementById('grand-total-display');

        /**
         * Met à jour le total général en fonction de l'option de livraison sélectionnée.
         * @param {string} option - 'home' ou 'pickup'
         */
        function updateTotal(option) {
            let currentDeliveryFee = 0;
            let currentGrandTotal = baseSubtotal;

            if (option === 'home') {
                currentDeliveryFee = deliveryCost;
                currentGrandTotal += deliveryCost;
                addressField.classList.remove('hidden');
            } else {
                addressField.classList.add('hidden');
            }

            // Mise à jour de l'affichage
            deliveryFeeDisplay.textContent = formatPrice(currentDeliveryFee) + ' FCFA';
            grandTotalDisplay.textContent = formatPrice(currentGrandTotal) + ' FCFA';
        }

        /**
         * Formatte un nombre en chaîne de caractères avec des espaces comme séparateurs de milliers.
         * @param {number} price 
         * @returns {string} Prix formaté
         */
        function formatPrice(price) {
            return price.toString().replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        }

        // Initialisation: S'assurer que les champs sont correctement affichés au chargement de la page
        document.addEventListener('DOMContentLoaded', () => {
            const initialOption = document.querySelector('input[name="delivery_option"]:checked').value;
            updateTotal(initialOption);
        });
    </script>
</body>
</html>
