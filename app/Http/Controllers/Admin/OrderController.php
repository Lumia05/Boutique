<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 

class OrderController extends Controller
{
    /**
     * Affiche la liste des commandes (Index).
     */
    public function index()
    {
        // ... votre logique de pagination des commandes ...
        $orders = Order::with('customer')->latest()->paginate(20);

        // Simulation des données de statistiques pour le graphique (A REMPLACER)
        $stats = [
            'labels' => ['Jour 7', 'Jour 6', 'Jour 5', 'Jour 4', 'Jour 3', 'Hier', 'Aujourd\'hui'],
            'submitted' => [15, 20, 18, 25, 30, 22, 28], // Commandes soumises
            'completed' => [10, 15, 12, 18, 25, 19, 23], // Commandes complétées (validées)
        ];
        
        // Total des KPIs pour les cartes
        $kpis = [
            'total_submitted' => 150,
            'total_completed' => 120,
            'revenue_last_30_days' => 1250000, // F CFA
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'kpis'));
    }

    /**
     * Affiche les détails d'une commande (SHOW).
     */
    public function show(Order $order)
    {
        // Charge les relations nécessaires (client, produits)
        $order->load('customer', 'items.product'); 
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Met à jour le statut d'une commande (UPDATE).
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', 'in:pending,processing,shipped,completed,cancelled'],
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $order)->with('success', 'Le statut de la commande a été mis à jour.');
    }

    /**
     * Supprime une commande (DESTROY).
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'La commande a été supprimée.');
    }
}