@extends('layouts.admin')

@section('title', 'Tableau de Bord Commandes')
@section('page-title', 'Statistiques et Gestion des Commandes')

@section('content')

    {{-- ======================================================= --}}
    {{-- 1. CARTES DE STATISTIQUES (KPIs) --}}
    {{-- ======================================================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        
        {{-- Carte 1: Commandes Soumises --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-indigo-500">
            <p class="text-sm font-medium text-gray-500">Commandes Soumises (30 jours)</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">
                {{ number_format($kpis['total_submitted'] ?? 0, 0, ',', ' ') }}
            </p>
        </div>
        
        {{-- Carte 2: Commandes Validées --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
            <p class="text-sm font-medium text-gray-500">Commandes Validées (30 jours)</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">
                {{ number_format($kpis['total_completed'] ?? 0, 0, ',', ' ') }}
            </p>
        </div>
        
        {{-- Carte 3: Revenu --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-red-500">
            <p class="text-sm font-medium text-gray-500">Revenu (30 derniers jours)</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-1">
                {{ number_format($kpis['revenue_last_30_days'] ?? 0, 0, ',', ' ') }} F CFA
            </p>
        </div>

    </div>

    {{-- ======================================================= --}}
    {{-- 2. GRAPHIQUE DES COMMANDES (Soumises vs Validées) --}}
    {{-- ======================================================= --}}
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-3 border-b">
            Performance des Commandes (7 derniers jours)
        </h3>
        <canvas id="orderChart" height="100"></canvas>
    </div>


    {{-- ======================================================= --}}
    {{-- 3. LISTE DES COMMANDES --}}
    {{-- ======================================================= --}}
    <div class="p-4 bg-white rounded-xl shadow-lg border-t-4 border-gray-100">

        <h3 class="text-xl font-semibold text-gray-800 mb-4 pb-3 border-b">
            Commandes Récentes
        </h3>

        @if ($orders->isEmpty())
            <p class="text-gray-500">Aucune commande n'a été enregistrée pour le moment.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Actions</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($orders as $order)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #{{ $order->id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <a href="{{ route('admin.customers.show', $order->customer) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                        {{ $order->customer->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($order->status == 'completed') bg-green-100 text-green-800
                                        @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-bold">
                                    {{ number_format($order->total_amount, 2, ',', ' ') }} F CFA
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-red-600 hover:text-red-900">
                                        Détails
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

@endsection

{{-- ======================================================= --}}
{{-- SCRIPTS POUR LE GRAPHIQUE (Chart.js) --}}
{{-- ======================================================= --}}
@push('scripts')
    {{-- Assurez-vous d'inclure la librairie Chart.js dans votre layout admin --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}

    <script>
        // Récupération des données passées par Laravel
        const stats = @json($stats); 
        
        const ctx = document.getElementById('orderChart').getContext('2d');
        
        const orderChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: stats.labels, // Jours de la semaine
                datasets: [
                    {
                        label: 'Commandes Soumises',
                        data: stats.submitted,
                        borderColor: '#4f46e5', // Indigo-600
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        tension: 0.3,
                        fill: true,
                    },
                    {
                        label: 'Commandes Validées',
                        data: stats.completed,
                        borderColor: '#10b981', // Green-600
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.3,
                        fill: true,
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        suggestedMax: Math.max(...stats.submitted) + 5 // Ajuste la hauteur max
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                }
            }
        });
    </script>
@endpush