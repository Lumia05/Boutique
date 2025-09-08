<?php

namespace App\Http\Controllers\Admin;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord principal.
     */
    public function index()
    {
        // Données pour le graphique des ventes
        $salesData = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(total_price) as total_sales')
        )
        ->whereYear('created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total_sales', 'month')
        ->toArray();

        // Données pour le graphique des catégories
        $categoryData = Category::withCount('products')->pluck('products_count', 'name')->toArray();

        // Données pour les statistiques générales
        $totalOrders = Order::count();
        $totalProducts = Products::count();
        $outOfStockProducts = Products::where('quantite', '<=', 5)->count();

        return view('admin.dashboard.index', compact(
            'salesData',
            'categoryData',
            'totalOrders',
            'totalProducts',
            'outOfStockProducts'
        ));
    }
}