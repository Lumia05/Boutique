<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contactez-nous - Global Retail Business</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                <a href="/a-propos" class="text-gray-700 hover:text-red-600 transition duration-300">À propos</a>
                <a href="/contact" class="text-red-600 font-semibold transition duration-300">Contact</a>
                <a href="/panier" class="relative text-gray-700 hover:text-red-600">
                    Panier
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto mt-8 px-6 py-8">
        <div class="bg-white p-8 rounded-lg shadow-xl mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-6 border-b-2 border-red-600 pb-2">Contactez-nous</h1>
            <p class="text-lg text-gray-700 leading-relaxed mb-8">
                Notre équipe est à votre disposition pour vous conseiller et répondre à toutes vos questions. Choisissez la méthode de contact qui vous convient le mieux.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                
                <div class="p-6 bg-gray-50 rounded-lg shadow-inner">
                    <h2 class="text-2xl font-bold mb-4 border-b border-gray-300 pb-2">Envoyez-nous un message</h2>
                    <form action="#" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nom et prénom</label>
                            <input type="text" name="name" id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                            <input type="email" name="email" id="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700">Sujet de votre demande</label>
                            <input type="text" name="subject" id="subject" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required>
                        </div>
                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-700">Votre message</label>
                            <textarea name="message" id="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" required></textarea>
                        </div>
                        <div>
                            <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                                Envoyer le message
                            </button>
                        </div>
                    </form>
                </div>

                <div class="space-y-6">
                    <div class="p-6 bg-white rounded-lg shadow-md border-t-4 border-red-600">
                        <h2 class="text-2xl font-bold mb-4">Informations Générales</h2>
                        <div class="space-y-4 text-gray-700 text-lg">
                            <p class="flex items-start">
                                <i class="fas fa-map-marker-alt text-red-600 text-xl w-6 flex-shrink-0 mt-1"></i> 
                                <span class="ml-3"><strong>Siège Social :</strong> Douala, Bepanda, près de l’Hôtel Déborah</span>
                            </p>
                            <p class="flex items-center">
                                <i class="fas fa-phone-alt text-red-600 text-xl w-6 flex-shrink-0"></i> 
                                <span class="ml-3"><strong>Appel Général :</strong> <a href="tel:{{ $manager['phone'] }}" class="hover:underline font-semibold">{{ $manager['phone'] }}</a></span>
                            </p>
                            <p class="flex items-center">
                                <i class="fas fa-envelope text-red-600 text-xl w-6 flex-shrink-0"></i> 
                                <span class="ml-3"><strong>E-mail :</strong> <a href="mailto:{{ $manager['email'] }}" class="hover:underline">{{ $manager['email'] }}</a></span>
                            </p>
                            <p class="flex items-center">
                                <i class="fab fa-facebook-square text-red-600 text-xl w-6 flex-shrink-0"></i> 
                                <span class="ml-3"><strong>Facebook :</strong> <a href="https://facebook.com/GlobalRetailBusiness" target="_blank" class="hover:underline">@GlobalRetailBusiness</a></span>
                            </p>
                        </div>
                    </div>

                    <div class="p-6 bg-white rounded-lg shadow-md border-l-4 border-red-600">
                        <h2 class="text-2xl font-bold mb-4">Horaires d'Ouverture</h2>
                        <div class="space-y-2 text-gray-700 text-lg">
                            {{-- Utilisation des données dynamiques du contrôleur --}}
                            <p class="flex justify-between">
                                <span class="font-semibold">Lundi - Vendredi :</span> <span>{{ $hours['open'] }} - {{ $hours['close'] }}</span>
                            </p>
                            <p class="flex justify-between">
                                <span class="font-semibold">Samedi :</span> <span>{{ $hours['open'] }} - 13h00</span>
                            </p>
                            <p class="flex justify-between">
                                <span class="font-semibold text-red-600">Dimanche :</span> <span class="text-red-600">Fermé</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            ---

            <div class="mt-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-red-600 pb-2 text-center">Contactez nos Experts Directement</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    
                    @forelse ($experts as $expert)
                        {{-- Génération dynamique des blocs d'experts --}}
                        <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-red-500">
                            <h3 class="font-bold text-xl mb-2 text-red-600">{{ $expert->role }}</h3>
                            <p class="text-gray-600 mb-4">{{ $expert->name }}</p>
                            <div class="flex flex-wrap gap-2">
                                @if ($expert->phone)
                                    <a href="https//wa.me/+237{{ $expert->whatsapp }}" class="inline-flex items-center text-white bg-green-500 px-3 py-1 rounded-full text-sm hover:bg-green-600 transition duration-300" target="_blank">
                                        <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                                    </a>
                                @endif
                                @if ($expert->phone)
                                    <a href="tel:+237{{ $expert->phone }}" class="inline-flex items-center text-white bg-red-600 px-3 py-1 rounded-full text-sm hover:bg-red-700 transition duration-300">
                                        <i class="fas fa-phone-alt mr-2"></i> Appeler
                                    </a>
                                    <a href="sms:{{ $expert->phone }}" class="inline-flex items-center text-white bg-blue-600 px-3 py-1 rounded-full text-sm hover:bg-blue-700 transition duration-300">
                                        <i class="fas fa-sms mr-2"></i> SMS
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        {{-- Message si aucun expert n'est actif/visible --}}
                        <div class="md:col-span-3 text-center py-6 text-gray-500">
                            <p>Aucun expert spécialisé n'est actuellement visible. Veuillez utiliser le formulaire de contact général.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            ---

            <div class="mt-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 border-b-2 border-red-600 pb-2">Notre Localisation</h2>
                <div class="rounded-lg overflow-hidden shadow-md">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.7558974769495!2d9.714869340905969!3d4.0700867853737925!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x106113b6d8402a73%3A0xfc003a9c1a58b461!2sGLC%20International%20Sarl!5e0!3m2!1sen!2scm!4v1758772100139!5m2!1sen!2scm"
                        width="100%"
                        height="450"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                    ></iframe>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>© 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

</body>
</html>