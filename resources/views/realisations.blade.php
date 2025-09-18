<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos réalisations</title>
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased text-gray-800">
    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                <a href="{{ route('realisations.index') }}" class="text-red-600 font-bold">Nos réalisations</a>
                <a href="/a-propos" class="text-gray-700 hover:text-red-600 transition duration-300">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-red-600 transition duration-300">Contact</a>
            </nav>
        </div>
    </header>

    <main class="w-full mt-6 px-0">
        <h1 class="text-3xl md:text-4xl font-bold text-center mb-8">Nos réalisations</h1>

        @if(empty($images))
            <p class="text-center text-gray-600">Aucune image trouvée dans public/storage/images.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-0 md:gap-0 w-full">
                @foreach($images as $img)
                    <div class="w-full overflow-hidden">
                        <img src="{{ $img }}" alt="Réalisation" class="w-full h-[60vh] md:h-[75vh] lg:h-[80vh] object-cover">
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>
</body>
</html>


