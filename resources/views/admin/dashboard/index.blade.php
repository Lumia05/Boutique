@extends('layouts.admin')

@section('title', 'Tableau de Bord')
@section('page-title', 'Tableau de Bord')

@section('content')

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500">
            <p class="text-sm text-gray-500">Total Ventes (Mois)</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">2 500 000 XAF</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
            <p class="text-sm text-gray-500">Commandes en Attente</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">12</p>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <p class="text-sm text-gray-500">Nouveaux Clients</p>
            <p class="text-3xl font-bold text-gray-800 mt-1">45</p>
        </div>
    </div>

    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md" role="alert">
        <p class="font-bold">Prochaine étape : Contacts Experts</p>
        <p class="text-sm">Cliquez sur **"Paramètres & Contacts"** dans le menu pour gérer les contacts de support de votre boutique.</p>
    </div>

@endsection