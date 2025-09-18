<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Global Retail Business</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+gbL0oN3wDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                <a href="/a-propos" class="text-gray-700 hover:text-red-600 transition duration-300">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-red-600 transition duration-300">Contact</a>
            </nav>
            <div class="flex items-center space-x-4">
                <div class="relative hidden md:block">
                    <input type="text" placeholder="Rechercher..." class="border border-gray-300 rounded-full py-2 pl-4 pr-10 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                    <button class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
                <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-red-600">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                    @php
                        $cartCount = count(Session::get('cart', []));
                    @endphp
                    @if($cartCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
                <button class="md:hidden text-gray-600 hover:text-red-600">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
        </div>
    </header>

    <div class="container mx-auto px-6 py-4">
        <span class="text-gray-500">
            <a href="/produits" class="hover:underline">Produits</a> > {{ $product->name }}
        </span>
    </div>

<main class="container mx-auto mt-4 px-6 py-8 bg-white shadow-lg rounded-lg">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div class="w-full flex justify-center items-center">
            {{-- Image du produit - Taille réduite --}}
            <img src="{{ asset($product->image ?? 'default-image.jpg') }}" alt="{{ $product->name }}" class="max-w-full h-96 object-contain rounded-lg shadow-xl">
        </div>

        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $product->name }}</h1>
            
            <div class="product-price">
                @php
                    // On s'assure que les dates de promotion existent et sont valides avant de les utiliser
                    $isPromotionActive = (!is_null($product->promotion_start_date) &&
                                        !is_null($product->promotion_end_date)) &&
                                        (\Carbon\Carbon::parse($product->promotion_start_date)->isPast() &&
                                        \Carbon\Carbon::parse($product->promotion_end_date)->isFuture()) &&
                                        \Carbon\Carbon::now()->between(\Carbon\Carbon::parse($product->promotion_start_date), \Carbon\Carbon::parse($product->promotion_end_date));
                                        
                @endphp

                @if($isPromotionActive)
                    <p class="text-xl text-gray-500 line-through mb-1">
                        {{ number_format($product->price, 2, ',', ' ') }} FCFA
                    </p>
                    <p class="text-3xl font-bold text-red-600 mb-2">
                        {{ number_format($product->promotion_price, 2, ',', ' ') }} FCFA
                    </p>
                    <p class="text-sm text-green-600 font-semibold mb-4">
                        Offre valable du {{ \Carbon\Carbon::parse($product->promotion_start_date)->isoFormat('LL') }}
                        au {{ \Carbon\Carbon::parse($product->promotion_end_date)->isoFormat('LL') }}
                    </p>
                @else
                    <p class="text-3xl font-bold text-red-600 mb-6">
                        {{ number_format($product->price, 2, ',', ' ') }} FCFA
                    </p>
                @endif
            </div>

            <h2 class="text-xl font-bold text-red-600 mb-2">Description du produit</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">{{ $product->description }}</p>

            @if(isset($product->features))
                <h2 class="text-xl font-bold text-red-600 mb-2">Caractéristiques du produit</h2>
                <ul class="list-disc list-inside space-y-2 text-gray-700">
                    @php
                        $features = explode('|', $product->features);
                    @endphp
                    @foreach($features as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            @endif

            @if(isset($product->recommended_use))
            <h2 class="text-xl font-bold text-red-600 mt-6 mb-2">Usage recommandé</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">{{ $product->recommended_use }}</p>
            @endif

            <div class="flex items-center justify-between">
                @if(isset($product->quantite) && $product->quantite > 0)
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <div class="flex items-center space-x-4">
                         <label for="quantity" class="text-gray-700 font-semibold">Quantité :</label>
                         <input type="number" name="quantity" id="quantity" value="1" min="1" max="{{ $product->quantite }}" class="border border-gray-300 rounded-lg py-2 px-4 w-24 text-center focus:outline-none focus:ring-2 focus:ring-red-500">
                         <button type="submit" class="bg-green-500 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-green-500 transition duration-300">
                            Ajouter au panier
                        </button>
                    </div>
                </form>
                @else
                    <p class="text-red-600 font-bold">Stock épuisé.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                @if(isset($product->technical_info))
                    <h3 class="font-bold text-2xl text-gray-800 mb-4">Informations techniques et de sécurité</h3>
                    <ul class="space-y-4 text-gray-700">
                        @php
                            $technicalInfo = explode('|', $product->technical_info);
                        @endphp
                        @foreach($technicalInfo as $info)
                            @php
                                $info = trim($info);
                                $parts = explode(': ', $info, 2);
                            @endphp
                            @if(count($parts) >= 2)
                                <li><strong>{{ $parts[0] }} :</strong> {{ $parts[1] }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
            <div>
                <h3 class="font-bold text-2xl text-gray-800 mb-4">Couleurs disponibles</h3>
                <div class="flex flex-wrap gap-2">
                     @forelse(explode(',', $product->color ?? '') as $couleur)
                        <div class="w-12 h-12 rounded-full border-2 border-gray-300 shadow-md" style="background-color: {{trim($couleur) }};"></div>
                    @empty
                        <p class="text-gray-500">Aucune couleur disponible pour le moment.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

</body>
</html>