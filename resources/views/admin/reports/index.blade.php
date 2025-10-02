@extends('layouts.admin')

@section('title', 'Rapports et Statistiques')
@section('page-title', 'Analyse des Performances')

@section('content')

    {{-- Message de succès global (pour le bouton "Générer Rapport") --}}
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    {{-- ======================================================= --}}
    {{-- 1. CARTES DE STATISTIQUES CLÉS (KPIs) - 30 Derniers Jours --}}
    {{-- ======================================================= --}}
    <h2 class="text-2xl font-semibold text-gray-800 mb-6">Indicateurs Clés (30 Jours)</h2>
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        
        {{-- Carte 1: Chiffre d'Affaires Total --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-medium text-gray-500">Chiffre d'Affaires (CA)</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">
                {{ number_format($kpis['revenue'] ?? 0, 0, ',', ' ') }} F CFA
            </p>
        </div>
        
        {{-- Carte 2: Commandes Terminées --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-indigo-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-medium text-gray-500">Commandes Terminées</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">
                {{ number_format($kpis['completed_orders'] ?? 0, 0, ',', ' ') }}
            </p>
        </div>
        
        {{-- Carte 3: Commandes Totales --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-medium text-gray-500">Commandes Totales Soumises</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">
                {{ number_format($kpis['total_orders'] ?? 0, 0, ',', ' ') }}
            </p>
        </div>

        {{-- Carte 4: Nouveaux Clients --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500 hover:shadow-xl transition duration-300">
            <p class="text-sm font-medium text-gray-500">Nouveaux Clients</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">
                {{ number_format($kpis['new_customers'] ?? 0, 0, ',', ' ') }}
            </p>
        </div>

    </div>

    {{-- ======================================================= --}}
    {{-- 2. GRAPHIQUE DES VENTES (7 Derniers Jours) --}}
    {{-- ======================================================= --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-3 border-b">
            Chiffre d'Affaires Jours (7 Derniers Jours)
        </h3>
        <canvas id="salesChart" height="80"></canvas>
    </div>

    {{-- ======================================================= --}}
    {{-- 3. OUTILS DE GÉNÉRATION DE RAPPORTS --}}
    {{-- ======================================================= --}}
    <div class="bg-white p-6 rounded-xl shadow-lg">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-3 border-b">
            Générer un Rapport Personnalisé
        </h3>
        <form action="{{ route('admin.reports.generate') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Sélecteur de date de début --}}
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Date de Début</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('start_date', now()->subDays(7)->toDateString()) }}">
                    @error('start_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                {{-- Sélecteur de date de fin --}}
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Date de Fin</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ old('end_date', now()->toDateString()) }}">
                    @error('end_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Sélecteur de format --}}
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700">Format d'Export</label>
                    <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="csv">CSV (Feuille de calcul)</option>
                        <option value="pdf">PDF (Document)</option>
                    </select>
                    @error('type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Bouton de soumission --}}
                <div class="flex items-end">
                    <button type="submit" class="w-full justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                        Générer et Télécharger le Rapport
                    </button>
                </div>
            </div>
        </form>
    </div>

@endsection

{{-- ======================================================= --}}
{{-- SCRIPTS POUR LE GRAPHIQUE (Chart.js) --}}
{{-- ======================================================= --}}
@push('scripts')
    {{-- Inclus Chart.js si ce n'est pas déjà fait dans le layout admin --}}
    {{-- Le `ReportController` fournit la variable $chartData --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Récupération des données passées par Laravel
        const chartData = @json($chartData); 
        
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        const salesChart = new Chart(ctx, {
            type: 'bar', // Utilisation de barres pour un affichage plus clair du CA journalier
            data: {
                labels: chartData.labels, // Jours de la période
                datasets: [
                    {
                        label: 'Chiffre d\'Affaires Réalisé (F CFA)',
                        data: chartData.data,
                        backgroundColor: '#4f46e5', // Indigo-600
                        borderColor: '#3730a3',
                        borderWidth: 1,
                        borderRadius: 4,
                    },
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Montant (F CFA)'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Jour'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'XOF', minimumFractionDigits: 0 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
