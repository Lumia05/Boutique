<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administration GRB')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Styles de base pour la structure */
        .pt-16 { padding-top: 4rem; }
        .ml-64 { margin-left: 16rem; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100 font-sans antialiased">

    <header class="bg-gray-800 text-white shadow-lg fixed w-full z-10">
        <div class="flex justify-between items-center h-16 px-6">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-red-500 hover:text-red-400 transition duration-300">
                GRB <span class="text-white font-light">Admin</span>
            </a>
            
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium">Bonjour, Admin !</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-400 hover:text-red-500 transition duration-300 py-1 px-3 rounded-lg border border-red-400 hover:border-red-500">
                        Déconnexion
                    </button>
                </form>
            </div>
        </div>
    </header>

   <div class="flex pt-16">

        <nav class="w-64 bg-gray-900 h-screen fixed top-16 left-0 shadow-xl p-4 space-y-2">
            
            <a href="{{ route('admin.dashboard') }}" class="menu-item @if(Request::is('admin')) bg-gray-700 @endif">
                Dashboard
            </a>
            
            <h3 class="text-xs font-semibold text-gray-500 uppercase pt-4 pb-1 px-4">Gestion</h3>
            
            <a href="{{ route('admin.categories.index') }}" class="menu-item @if(Request::is('admin/categories*')) bg-gray-700 @endif">
                Catégories
            </a>

            <a href="{{ route('admin.products.index') }}" class="menu-item @if(Request::is('admin/products*')) bg-gray-700 @endif">
                Produits
            </a>

            <a href="#" class="menu-item">Commandes (À Faire)</a>

            <h3 class="text-xs font-semibold text-gray-500 uppercase pt-4 pb-1 px-4">Configuration</h3>
            <a href="{{ route('admin.settings.index') }}" class="menu-item @if(Request::is('admin/settings')) bg-gray-700 @endif">
                Paramètres & Contacts
            </a>
            
            </nav>
            <style>
                .menu-item {
                    display: flex;
                    align-items: center;
                    padding: 0.625rem 1rem; /* py-2.5 px-4 */
                    border-radius: 0.5rem; /* rounded-lg */
                    color: #9ca3af; /* text-gray-400 */
                    font-weight: 600; /* font-semibold */
                    transition: background-color 300ms, color 300ms;
                }
                .menu-item:hover:not(.bg-gray-700) {
                    background-color: #4b5563; /* hover:bg-gray-700 */
                    color: #ffffff; /* hover:text-white */
                }
                .bg-gray-700 {
                    color: #ffffff;
                }
            </style>
        </nav>

        <main class="ml-64 p-8 w-full">
            <h1 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-2">@yield('page-title')</h1>

            @yield('content')
        </main>

    </div>

    @stack('scripts')
</body>
</html>