<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Produits - Global Retail Business</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                {{-- <a href="/nouveautes" class="text-gray-700 hover:text-red-600 transition duration-300">Nouveautés</a> --}}
                <a href="/a-propos" class="text-gray-700 hover:text-red-600 transition duration-300">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-red-600 transition duration-300">Contact</a>
                <a href="/panier" class="relative text-gray-700 hover:text-red-600">
                    Panier
                        @php
                            $cartCount = array_sum(array_column(Session::get('cart', []), 'quantity'));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                </a>
            </nav>
            <div class="flex items-center space-x-4">
                <form action="/produits" method="GET" class="relative hidden md:block">
                    <input type="text" name="search" placeholder="Rechercher..." class="border border-gray-300 rounded-full py-2 pl-4 pr-10 focus:outline-none focus:ring-2 focus:ring-red-500 text-sm">
                    <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </form>
        </div>
    </header>

    <div class="container mx-auto mt-8 px-6 flex flex-col md:flex-row gap-8">

    <aside class="w-full md:w-1/4 bg-white p-6 shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-red-600">Catégories</h2>
    <ul>
        <li class="mb-2">
            <a href="/produits" class="block py-2 px-3 rounded-md @if(!$selectedCategoryId) bg-red-100 font-bold text-red-600 @else text-gray-700 hover:bg-gray-100 @endif transition-colors duration-200">
                Toutes les catégories
            </a>
        </li>

        @foreach ($categories as $category)
            <li class="mb-2">
                <a href="/produits?category_id={{ $category->id }}" 
                   class="block py-2 px-3 rounded-md flex justify-between items-center transition-colors duration-200 
                   @if($selectedCategoryId == $category->id) bg-red-100 font-bold text-red-600 @else text-gray-700 hover:bg-gray-100 @endif"
                   @if($category->children->count())
                       onclick="event.preventDefault(); toggleSubcategories(this);"
                   @endif>
                    <span>{{ $category->name }}</span>
                    @if($category->children->count())
                    <svg class="w-4 h-4 transform transition-transform duration-300" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    @endif
                </a>
                
                @if($category->children->count())
                    <ul class="pl-4 mt-2 space-y-2 overflow-hidden transition-all duration-300" data-subcategories>
                        @foreach($category->children as $child)
                            <li class="mb-1">
                                <a href="/produits?category_id={{ $child->id }}" class="block py-1 px-3 text-sm rounded-md transition-colors duration-200
                                @if($selectedCategoryId == $child->id) bg-red-100 font-bold text-red-600 @else text-gray-600 hover:bg-gray-100 @endif">
                                    {{ $child->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</aside>

    <div class="flex-1">
        <h2 class="text-3xl font-bold text-center mb-6">{{ $contentTitle }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden relative group border-t-4 border-red-600">
                    <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="p-4">
                        <h3 class="font-bold text-xl mb-1 text-gray-800">{{ $product->name }}</h3>
                        <p class="text-gray-600 text-sm">{{ Str::limit($product->description, 70) }}</p>
                        <div class="mt-3 flex justify-between items-center">
                            <span class="text-2xl font-bold text-red-600">{{ number_format($product->price, 2, ',', ' ') }} FCFA</span>
                            <a href="/produits/{{ $product->id }}" class="bg-red-600 text-white px-4 py-2 rounded-full hover:bg-red-700 transition duration-300 text-sm">Détails</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-600 text-lg">Aucun produit ne correspond à votre sélection.</p>
            @endforelse
        </div>
    </div>
</div>
    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

    <script>
        function toggleSubcategories(button) {
            const subcategoriesList = button.nextElementSibling;
            if (subcategoriesList) {
                const arrow = button.querySelector('svg');
                const isExpanded = subcategoriesList.classList.contains('max-h-96');

                if (isExpanded) {
                    subcategoriesList.classList.remove('max-h-96');
                    subcategoriesList.classList.add('max-h-0');
                    arrow.classList.remove('rotate-180');
                } else {
                    subcategoriesList.classList.remove('max-h-0');
                    subcategoriesList.classList.add('max-h-96');
                    arrow.classList.add('rotate-180');
                }
            }
        }
    </script>
</body>
</html>