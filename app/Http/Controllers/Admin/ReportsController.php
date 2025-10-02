<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    /**
     * Affiche le tableau de bord des rapports et statistiques (Index).
     */
    public function index()
    {
        // Définition de la période : 30 derniers jours
        $startDate = Carbon::now()->subDays(30)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        // 1. Calcul des indicateurs clés (KPIs) pour les 30 derniers jours
        $kpis = $this->calculateKpis($startDate, $endDate);

        // 2. Préparation des données pour le graphique de ventes (Jours/Montants)
        $chartData = $this->getSalesChartData(Carbon::now()->subDays(7)->startOfDay(), $endDate);

        return view('admin.reports.index', compact('kpis', 'chartData'));
    }

    /**
     * Génère et télécharge un rapport PDF/CSV (Exemple).
     */
    public function generate(Request $request)
    {
        // Simple validation pour choisir le type de rapport
        $request->validate([
            'type' => 'required|in:csv,pdf',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        // Ici, vous auriez la logique pour formater les données de toutes les commandes
        // en fonction des dates et générer le fichier. 
        // Par simplicité, nous renvoyons un message de succès.
        
        return redirect()->route('admin.reports.index')->with('success', 'Le rapport demandé a été généré et est prêt au téléchargement.');
    }

    /**
     * Calcule les indicateurs clés de performance (KPIs).
     */
    protected function calculateKpis(Carbon $startDate, Carbon $endDate)
    {
        $orders = Order::whereBetween('created_at', [$startDate, $endDate]);

        return [
            // Nombre total de commandes sur la période
            'total_orders' => (clone $orders)->count(),
            
            // Nombre de commandes terminées
            'completed_orders' => (clone $orders)->where('status', 'completed')->count(),
            
            // Chiffre d'affaires total (des commandes terminées)
            'revenue' => (clone $orders)
                ->where('status', 'completed')
                ->sum('total_price'),
                
            // Nombre de nouveaux clients
            'new_customers' => Customer::whereBetween('created_at', [$startDate, $endDate])->count(),
        ];
    }
    
    /**
     * Récupère les données agrégées pour le graphique des ventes.
     */
    protected function getSalesChartData(Carbon $startDate, Carbon $endDate)
    {
        $sales = Order::select(
            DB::raw('DATE(created_at) as order_date'),
            DB::raw('SUM(total_price) as total_sales')
        )
        ->where('status', 'completed') // Seules les commandes complétées
        ->whereBetween('created_at', [$startDate, $endDate])
        ->groupBy('order_date')
        ->orderBy('order_date', 'ASC')
        ->get()
        ->keyBy('order_date');

        // Préparation des labels et des données pour Chart.js
        $period = Carbon::parse($startDate)->daysUntil($endDate);
        $labels = [];
        $data = [];

        foreach ($period as $date) {
            $formattedDate = $date->toDateString();
            $labels[] = $date->format('D d/m'); // Ex: Mer 02/10
            $data[] = $sales->get($formattedDate)->total_sales ?? 0;
        }

        return compact('labels', 'data');
    }
}
