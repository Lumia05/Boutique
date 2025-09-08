<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Global Retail Business</title>
    @vite('resources/css/app.css')
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                {{-- <a href="/nouveautes" class="text-gray-700 hover:text-red-600 transition duration-300">Nouveautés</a> --}}
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
            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="max-w-full h-auto rounded-lg shadow-xl">
        </div>

        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 mb-2">{{ $product->name }}</h1>
            <p class="text-3xl font-bold text-red-600 mb-6">{{ number_format($product->price, 2, ',', ' ') }} FCFA</p>

            <h2 class="text-xl font-bold text-red-600 mb-2">Description du produit</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">{{ $product->description }}</p>

          @if($product->features)
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

            @if(!empty($product->recommended_use))
            <h2 class="text-xl font-bold text-red-600 mt-6 mb-2">Usage recommandé</h2>
            <p class="text-gray-700 mb-6 leading-relaxed">{{ $product->recommended_use }}</p>
            @endif

            <div class="flex items-center justify-between">
                <a href="/produits/{{ $product->id }}/commander" class="bg-red-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-red-700 transition duration-300 text-lg">
                    Faire une demande de contact
                </a>
            </div>
        </div>
    </div>

    <div class="mt-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                @if($product->technical_info)
                    <h3 class="font-bold text-2xl text-gray-800 mb-4">Informations techniques et de sécurité</h3>
                    <ul class="space-y-4 text-gray-700">
                        @php
                            $technicalInfo = explode('|', $product->technical_info);
                        @endphp
                        @foreach($technicalInfo as $info)
                            @php
                                list($key, $value) = explode(': ', $info, 2);
                            @endphp
                            <li><strong>{{ $key }} :</strong> {{ $value }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div>
                <!--Ici on affiche les couleurs disponibles pour le produit, en supprimant les virgules avec explode et 
                en parcourant la liste des couleurs avec la methode foreach.-->
                <h3 class="font-bold text-2xl text-gray-800 mb-4">Couleurs disponibles</h3>
                <div class="flex flex-wrap gap-2">
                     @forelse($hexProductColors as $color)
                        <div class="w-12 h-12 rounded-full border-2 border-gray-300 shadow-md" style="background-color: {{ $color }};"></div>
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