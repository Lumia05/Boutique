<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Retail Business - Équipements de Sécurité</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+gbL0oN3wDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .hero-bg {
            background-image: url('https://picsum.photos/seed/construction/1600/900');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>

            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                <a href="{{ route('realisations.index') }}" class="text-gray-700 hover:text-red-600 transition duration-300">Nos réalisations</a>
                <a href="/a-propos" class="text-gray-700 hover:text-red-600 transition duration-300">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-red-600 transition duration-300">Contact</a>
            </nav>
            <div class="flex items-center space-x-4">
                 <a href="{{ route('cart.index') }}" class="relative text-gray-600 hover:text-red-600">
                <i class="fas fa-shopping-cart text-2xl">Panier</i>
                @php $cartCount = count(Session::get('cart', [])); @endphp
                @if($cartCount > 0)
                    <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                        {{ $cartCount }}
                    </span>
                @endif
            </a>
            </div>
        </div>
    </header>

    <main class="container mx-auto px-6 py-8">
        <div class="hero-bg text-white text-center py-20 px-6 rounded-lg shadow-lg">
            <h1 class="text-5xl font-extrabold leading-tight mb-4">Équipements de Sécurité et Matériaux de Construction</h1>
            <p class="text-xl mb-8">Votre partenaire de confiance pour des projets réussis. <br>Qualité, durabilité et sécurité sont notre priorité.</p>
            <a href="/produits" class="bg-red-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-red-700 transition duration-300 text-lg">Découvrir nos produits</a>
        </div>

        <section class="mt-12 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Nos Catégories</h2>
            <p class="text-gray-600 text-lg">Découvrez nos produits par catégorie.</p>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <a href="#" class="block bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                    <img src="https://picsum.photos/seed/peinture/400/300" alt="Peinture" class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="font-bold text-xl text-gray-800">Peinture</h3>
                        <p class="text-sm text-gray-600 mt-1">Éclat et protection pour tous vos murs.</p>
                    </div>
                </a>
                <a href="#" class="block bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                    <img src="https://picsum.photos/seed/casque/400/300" alt="Casque" class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="font-bold text-xl text-gray-800">Casque</h3>
                        <p class="text-sm text-gray-600 mt-1">Sécurité avant tout sur les chantiers.</p>
                    </div>
                </a>
                <a href="#" class="block bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                    <img src="https://picsum.photos/seed/gants/400/300" alt="Gants" class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="font-bold text-xl text-gray-800">Gants</h3>
                        <p class="text-sm text-gray-600 mt-1">Protection optimale pour vos mains.</p>
                    </div>
                </a>
                <a href="#" class="block bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                    <img src="https://picsum.photos/seed/membrane/400/300" alt="Membranes" class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-4">
                        <h3 class="font-bold text-xl text-gray-800">Membranes</h3>
                        <p class="text-sm text-gray-600 mt-1">Étanchéité et durabilité pour vos toits.</p>
                    </div>
                </a>
            </div>
        </section>

        <div class="mt-12 text-center">
            <h2 class="text-4xl font-bold text-gray-800 mb-2">Nos Produits Phares</h2>
            <p class="text-gray-600 text-lg">Découvrez nos produits les plus populaires et les mieux notés.</p>
        </div>
        
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @if($products->count())
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden relative group border-t-4 border-red-600">
                        <a href="{{ route('products.show', $product->id) }}">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                        <div class="p-4">
                            <a href="{{ route('products.show', $product->id) }}">
                                <h3 class="font-bold text-xl mb-1 text-gray-800">{{ $product->name }}</h3>
                            </a>
                            
                            <p class="text-gray-600 text-sm">{{ Str::limit($product->description, 70) }}</p>

                            <div class="mt-3">
                                @php
                                    $hasPromotion = false;
                                    $minPrice = $product->variants->min('price');
                                    $maxPrice = $product->variants->max('price');
                                    
                                    $minPromoPrice = $product->variants->whereNotNull('promotion_price')->min('promotion_price');
                                    
                                    if ($minPromoPrice && $minPromoPrice < $minPrice) {
                                        $hasPromotion = true;
                                    }
                                @endphp

                                @if($hasPromotion)
                                    <span class="text-xs font-semibold text-white bg-red-600 px-2 py-1 rounded-full absolute top-2 right-2">Promo</span>
                                    <p class="text-2xl font-bold text-red-600">
                                        À partir de {{ number_format($minPromoPrice, 0, ',', '.') }} FCFA
                                    </p>
                                    <p class="text-sm text-gray-500 line-through">
                                        Au lieu de {{ number_format($minPrice, 0, ',', '.') }} FCFA
                                    </p>
                                @else
                                    <p class="text-2xl font-bold text-gray-800">
                                        @if($minPrice === $maxPrice)
                                            {{ number_format($minPrice, 0, ',', '.') }} FCFA
                                        @else
                                            À partir de {{ number_format($minPrice, 0, ',', '.') }} FCFA
                                        @endif
                                    </p>
                                @endif
                            </div>

                            <a href="{{ route('products.show', $product->id) }}" class="mt-4 block w-full text-center bg-red-600 text-white font-bold py-2 rounded-full shadow-lg hover:bg-red-700 transition duration-300">
                                Voir les options
                            </a>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="col-span-full text-center text-gray-600 text-lg">Aucun produit disponible pour le moment.</p>
            @endif
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

</body>
</html>