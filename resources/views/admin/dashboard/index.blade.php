@extends('admin.layout')

@section('title', 'Tableau de bord')

@section('content')
    <div class="row g-4 mb-4">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-danger">Total des Commandes</h5>
                    <p class="card-text fs-2 fw-bold">{{ $totalOrders }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-danger">Total des Produits</h5>
                    <p class="card-text fs-2 fw-bold">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-danger">Produits en Stock Faible</h5>
                    <p class="card-text fs-2 fw-bold">{{ $outOfStockProducts }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="card-title text-danger mb-4">Ventes Mensuelles</h5>
                <canvas id="monthlySalesChart"></canvas>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="chart-container">
                <h5 class="card-title text-danger mb-4">Produits par Catégorie</h5>
                <canvas id="categoryProductsChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const salesData = @json(array_values($salesData));
        const salesLabels = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

        const salesCtx = document.getElementById('monthlySalesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'bar',
            data: {
                labels: salesLabels.slice(0, salesData.length),
                datasets: [{
                    label: 'Ventes (FCFA)',
                    data: salesData,
                    backgroundColor: 'rgba(220, 53, 69, 0.8)',
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: { y: { beginAtZero: true } }
            }
        });

        const categoryData = @json(array_values($categoryData));
        const categoryLabels = @json(array_keys($categoryData));

        const categoryCtx = document.getElementById('categoryProductsChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Nombre de produits',
                    data: categoryData,
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(255, 193, 7, 0.8)',
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(23, 162, 184, 0.8)',
                        'rgba(108, 117, 125, 0.8)',
                    ],
                    borderColor: 'white',
                    borderWidth: 2
                }]
            }
        });
    </script>
@endsection