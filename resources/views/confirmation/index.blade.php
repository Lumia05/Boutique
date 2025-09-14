<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande Soumise</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+gbL0oN3wDA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
        .success-message {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300 no-underline hover:no-underline">Produits</a>
                <a href="/a-propos" class="text-gray-700 hover:text-red-600 transition duration-300 no-underline hover:no-underline">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-red-600 transition duration-300 no-underline hover:no-underline">Contact</a>
            </nav>
            <a href="/panier" class="relative text-gray-600 hover:text-red-600">
                <i class="fas fa-shopping-cart text-2xl"></i>
            </a>
        </div>
    </header>

    <main class="container mx-auto px-6 py-8">
        <div class="bg-white shadow-lg rounded-lg p-10 max-w-xl mx-auto text-center mt-12 success-message">
            <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
            <h1 class="text-3xl font-bold text-gray-900 mb-4">Commande soumise avec succès !</h1>
            <p class="text-gray-600 mb-6">Merci pour votre achat. Un récapitulatif a été envoyé à votre adresse e-mail.</p>
            <a href="/" class="bg-red-600 text-white font-bold py-3 px-8 rounded-full shadow-lg hover:bg-red-700 transition duration-300">
                Retourner à l'accueil
            </a>
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

</body>
</html>