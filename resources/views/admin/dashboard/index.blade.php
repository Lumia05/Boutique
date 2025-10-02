@extends('layouts.admin')

@section('title', 'Aperçu Général')

@section('content')
    <style>
        .card-shadow {
            transition: all 0.3s ease;
        }
        .card-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>

    <header class="mb-8">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-2">Tableau de Bord Administrateur</h1>
        <p class="text-gray-600">Accès rapide aux fonctionnalités clés de la boutique.</p>
    </header>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        <!-- Carte 1: Commandes -->
        <a href="{{ route('admin.orders.index') ?? '#' }}" class="block">
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-red-500 card-shadow">
                <div class="flex items-center">
                    <i class="fas fa-shopping-bag text-3xl text-red-500 mr-4"></i>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">Gestion des Commandes</p>
                        <p class="text-sm text-gray-500">Suivi et traitement des commandes clients.</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Carte 2: Gestion des Produits (Stocks & Variantes) -->
        <a href="{{ route('admin.products.index') ?? '#' }}" class="block">
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-blue-500 card-shadow">
                <div class="flex items-center">
                    <i class="fas fa-cubes text-3xl text-blue-500 mr-4"></i>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">Produits & Stocks</p>
                        <p class="text-sm text-gray-500">Ajouter, modifier les produits et gérer les inventaires.</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Carte 3: Catégories -->
        <a href="{{ route('admin.categories.index') ?? '#' }}" class="block">
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-green-500 card-shadow">
                <div class="flex items-center">
                    <i class="fas fa-layer-group text-3xl text-green-500 mr-4"></i>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">Gestion des Catégories</p>
                        <p class="text-sm text-gray-500">Organiser la structure du catalogue.</p>
                    </div>
                </div>
            </div>
        </a>

        
        <!-- Carte 5: Clients -->
        <a href="{{ route('admin.customers.index') ?? '#' }}" class="block">
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-purple-500 card-shadow">
                <div class="flex items-center">
                    <i class="fas fa-user-tag text-3xl text-purple-500 mr-4"></i>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">Gestion des Clients</p>
                        <p class="text-sm text-gray-500">Consulter et gérer les informations des acheteurs.</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Carte 6: Experts (Vendeurs/Partenaires) -->
        <a href="{{ route('admin.expert_contacts.index') ?? '#' }}" class="block">
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-pink-500 card-shadow">
                <div class="flex items-center">
                    <i class="fas fa-handshake text-3xl text-pink-500 mr-4"></i>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">Experts de la Boutique</p>
                        <p class="text-sm text-gray-500">Gestion des vendeurs ou partenaires externes.</p>
                    </div>
                </div>
            </div>
        </a>
        
        <!-- Carte 7: Paramètres Généraux -->
        <a href="{{ route('admin.settings.index') ?? '#' }}" class="block">
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-gray-500 card-shadow">
                <div class="flex items-center">
                    <i class="fas fa-cog text-3xl text-gray-500 mr-4"></i>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">Configuration Générale</p>
                        <p class="text-sm text-gray-500">Modifier le nom de la boutique, les frais, etc.</p>
                    </div>
                </div>
            </div>
        </a>

        <!-- Carte 8 : Statistiques/Rapports (Idée supplémentaire) -->
         <a href="{{ route('admin.reports.index') ?? '#' }}" class="block">
            <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-cyan-500 card-shadow">
                <div class="flex items-center">
                    <i class="fas fa-chart-line text-3xl text-cyan-500 mr-4"></i>
                    <div>
                        <p class="text-xl font-semibold text-gray-900">Statistiques & Rapports</p>
                        <p class="text-sm text-gray-500">Vue d'ensemble des ventes et tendances.</p>
                    </div>
                </div>
            </div>
        </a>

    </section>
@endsection
