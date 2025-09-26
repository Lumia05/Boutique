<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos de nous - Global Retail Business</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-gray-100">

    <header class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            <a href="/" class="text-3xl font-extrabold text-red-600">Global Retail Business</a>
            <nav class="hidden md:flex space-x-6 text-lg">
                <a href="/produits" class="text-gray-700 hover:text-red-600 transition duration-300">Produits</a>
                <a href="/a-propos" class="text-red-600 font-semibold transition duration-300">À propos</a>
                <a href="/contact" class="text-gray-700 hover:text-red-600 transition duration-300">Contact</a>
                <a href="/panier" class="relative text-gray-700 hover:text-red-600">
                    Panier
                </a>
            </nav>
        </div>
    </header>

    <main class="container mx-auto mt-8 px-6 py-8">

        <div class="bg-white p-8 rounded-lg shadow-xl mb-12 flex flex-col md:flex-row items-center">
            <div class="md:w-1/3 flex-shrink-0 mb-6 md:mb-0">
                <img src="https://i.imgur.com/vHq051y.png" alt="Illustration Global Retail Business" class="rounded-lg shadow-md w-full">
            </div>
            <div class="md:w-2/3 md:pl-10">
                <h1 class="text-4xl font-bold text-red-600 mb-4">Global Retail Business</h1>
                <p class="text-lg text-gray-700 leading-relaxed">
                    Global Retail Business, créée en 2018, s'est imposé comme un leader incontournable dans l'industrie de la vente au détail. Notre mission est de fournir à nos clients une expérience de shopping en ligne fluide et agréable, avec une sélection de produits de haute qualité à des prix compétitifs.
                </p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-xl mb-12">
            <h2 class="text-4xl font-bold text-red-600 text-center mb-10">Nos atouts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                <div class="flex items-start">
                    <span class="w-12 h-12 rounded-full bg-red-400 flex-shrink-0"></span>
                    <div class="ml-4">
                        <h3 class="text-2xl font-semibold">Expertise de pointe</h3>
                        <p class="text-gray-600">Nous avons une expertise inégalée en terme de solution de sécurité.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="w-12 h-12 rounded-full bg-red-400 flex-shrink-0"></span>
                    <div class="ml-4">
                        <h3 class="text-2xl font-semibold">Gamme diversifiée</h3>
                        <p class="text-gray-600">Large choix d'équipements et de solutions.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="w-12 h-12 rounded-full bg-teal-500 flex-shrink-0"></span>
                    <div class="ml-4">
                        <h3 class="text-2xl font-semibold">Conformité rigoureuse</h3>
                        <p class="text-gray-600">Respect strict des normes et réglementations.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="w-12 h-12 rounded-full bg-teal-500 flex-shrink-0"></span>
                    <div class="ml-4">
                        <h3 class="text-2xl font-semibold">Innovation continue</h3>
                        <p class="text-gray-600">Toujours à la pointe de la technologie.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="w-12 h-12 rounded-full bg-green-500 flex-shrink-0"></span>
                    <div class="ml-4">
                        <h3 class="text-2xl font-semibold">Service client dévoué</h3>
                        <p class="text-gray-600">Soutien personnalisé à chaque étape.</p>
                    </div>
                </div>
                <div class="flex items-start">
                    <span class="w-12 h-12 rounded-full bg-green-500 flex-shrink-0"></span>
                    <div class="ml-4">
                        <h3 class="text-2xl font-semibold">Stocks permanents</h3>
                        <p class="text-gray-600">Stocks constamment disponibles</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-xl mb-12">
            <h2 class="text-4xl font-bold text-red-600 text-center mb-10">Notre vision</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        <img src="https://i.imgur.com/k6lP0Wn.png" alt="Vision 1" class="absolute w-full h-full object-contain">
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-red-600">Leadership en Vente en ligne</h3>
                    <p class="text-gray-600">
                        Notre premier axe vise à établir Global Retail Business en tant que leader indiscutable dans le domaine de la vente au détail. Nous aspirons à devenir la référence en matière de shopping en ligne, garantissant ainsi la satisfaction et la fidélité de nos clients.
                    </p>
                </div>
                <div class="text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        <img src="https://i.imgur.com/p12L1mZ.png" alt="Vision 2" class="absolute w-full h-full object-contain">
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-teal-500">Excellence et Confiance</h3>
                    <p class="text-gray-600">
                        Le deuxième axe met en avant notre engagement envers l'excellence et la confiance. Nous cherchons à être reconnus pour notre qualité exceptionnelle, notre expertise inégalée et notre engagement envers la satisfaction de nos clients. En construisant cette confiance, nous visons à établir des relations durables avec nos partenaires commerciaux.
                    </p>
                </div>
                <div class="text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        <img src="https://i.imgur.com/y3x3qQ4.png" alt="Vision 3" class="absolute w-full h-full object-contain">
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-yellow-500">Un Avenir Plus Sûr et Prospère</h3>
                    <p class="text-gray-600">
                        Notre troisième volet est axé sur l’impact positif que nous souhaitons avoir sur le monde. Nous œuvrons à créer un avenir plus sûr et plus prospère pour les entreprises en prévenant les risques professionnels, en favorisant des environnements de travail sécurisés et en contribuant à la croissance économique.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-xl mb-12">
            <h2 class="text-4xl font-bold text-red-600 text-center mb-10">Nos valeurs</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div>
                    <span class="text-4xl font-bold text-gray-500 mb-2 block">01</span>
                    <h3 class="text-xl font-semibold text-red-600 mb-2">Intégrité</h3>
                    <p class="text-gray-600">
                        L'intégrité est au cœur de notre entreprise. Nous nous engageons à agir avec honnêteté, transparence et éthique dans toutes nos interactions. Nous sommes fiers de maintenir des normes élevées d'intégrité professionnelle, ce qui renforce la confiance de nos clients et partenaires dans notre entreprise.
                    </p>
                </div>
                <div>
                    <span class="text-4xl font-bold text-gray-500 mb-2 block">02</span>
                    <h3 class="text-xl font-semibold text-teal-500 mb-2">Innovation</h3>
                    <p class="text-gray-600">
                        L’innovation est essentielle pour notre succès. Nous encourageons la créativité et l’innovation dans la recherche de solutions de protection de pointe. Nous nous efforçons de rester à la pointe de la technologie et de l’industrie pour offrir à nos clients des produits et des services de qualité supérieure.
                    </p>
                </div>
                <div>
                    <span class="text-4xl font-bold text-gray-500 mb-2 block">03</span>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Engagement envers la qualité</h3>
                    <p class="text-gray-600">
                        La qualité est notre priorité absolue. Nous sommes déterminés à fournir des produits qui dépassent les attentes de nos clients. Cette valeur se manifeste à travers notre sélection de produits, nos services et notre mission visant à offrir le meilleur à notre clientèle, contribuant ainsi à sa satisfaction.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="bg-white p-8 rounded-lg shadow-xl mb-12">
            <h2 class="text-4xl font-bold text-red-600 text-center mb-10">Nos missions</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="bg-red-50 p-6 rounded-lg border-t-8 border-red-500">
                    <h3 class="text-xl font-semibold text-red-600 mb-2">Protéger vos données les plus précieuses</h3>
                    <p class="text-gray-600">
                        Notre mission première est de protéger vos données et vos informations personnelles. Nous fournissons des solutions de sécurité de pointe pour garantir la sécurité et la protection de vos informations, tout en préservant la confidentialité de vos données.
                    </p>
                </div>
                <div class="bg-teal-50 p-6 rounded-lg border-t-8 border-teal-500">
                    <h3 class="text-xl font-semibold text-teal-600 mb-2">Réduire les risques en ligne</h3>
                    <p class="text-gray-600">
                        Nous sommes engagés à réduire les risques en ligne pour votre entreprise. Grâce à nos produits et services de haute qualité, nous aidons nos clients à minimiser les risques de sécurité, à se conformer aux normes les plus strictes et à prévenir les perturbations coûteuses.
                    </p>
                </div>
                <div class="bg-yellow-50 p-6 rounded-lg border-t-8 border-yellow-500">
                    <h3 class="text-xl font-semibold text-yellow-600 mb-2">Favoriser la productivité et la croissance</h3>
                    <p class="text-gray-600">
                        En sécurisant votre entreprise, Global Retail Business crée un environnement de travail propice à la productivité et à la croissance. Notre expertise et nos solutions innovantes contribuent à l’efficacité opérationnelle, vous permettant ainsi de vous concentrer sur le développement de votre entreprise en toute confiance.
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-8 rounded-lg shadow-xl mb-12">
            <h2 class="text-4xl font-bold text-red-600 text-center mb-10">Nos clients & Partenaires</h2>
            <p class="text-center text-gray-600 mb-8">
                Nous sommes fiers de collaborer avec des leaders de l'industrie pour fournir des solutions de sécurité de premier ordre.
            </p>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-6 items-center justify-center">
                <img src="https://i.imgur.com/K75Rz1e.png" alt="Louis Pasteur Labo" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/83u0Q2E.png" alt="GLOBELEQ" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/G4Yt04I.png" alt="PERENCO" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/B942LgY.png" alt="BANQUE DES ETATS D'AFRIQUE CENTRALE" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/oK8tQW6.png" alt="CIMPOR" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/3N70VpG.png" alt="SLB Schlumberger" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/pW9gYdM.png" alt="Halliburton" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/eO3f1Ff.png" alt="Boissons du Cameroun" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/T0T3Ew5.png" alt="Petrofor" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/p8yBw8j.png" alt="ADDX PETROLEUM" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/gK2o81e.png" alt="GUINNESS" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/n1x2w4m.png" alt="KALFRELEC" class="w-full h-auto object-contain">
                <img src="https://i.imgur.com/w2Y9w5b.png" alt="DANGOTE" class="w-full h-auto object-contain">
            </div>
        </div>

    </main>

    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p>&copy; 2025 Global Retail Business. Tous droits réservés.</p>
    </footer>

</body>
</html>