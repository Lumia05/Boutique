<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Global Retail Business - Équipements de Sécurité</title>
    @vite('resources/css/app.css')
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

    <div class="hero-bg relative h-[500px] flex items-center justify-center text-center">
        <div class="absolute inset-0 bg-black opacity-50"></div>
        <div class="relative z-10 text-white p-6 md:p-12">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">Global Retail Business</h1>
            <p class="text-lg md:text-xl max-w-2xl mx-auto drop-shadow-md">
                Votre partenaire de confiance en équipements et services professionnels. Nous fournissons des solutions de sécurité et de productivité de haute qualité pour les chantiers, les industries et les professionnels.
            </p>
            <a href="/produits" class="mt-8 inline-block bg-red-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-red-700 transition duration-300">
                Découvrir nos produits
            </a>
        </div>
    </div>

    <main class="container mx-auto mt-8 px-6">
        <h2 class="text-3xl font-bold text-center mb-8">Nos produits phares</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @if($products->count())
                @foreach($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden relative group border-t-4 border-red-600">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                        <div class="p-4">
                            <h3 class="font-bold text-xl mb-1 text-gray-800">{{ $product->name }}</h3>
                            <p class="text-gray-600 text-sm">{{ Str::limit($product->description, 70) }}</p>
                            <div class="mt-3 flex justify-between items-center">
                                <span class="text-2xl font-bold text-red-600">{{ number_format($product->price, 2, ',', ' ') }} FCFA</span>
                            </div>
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