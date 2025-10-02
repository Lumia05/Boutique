<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; 
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Affiche la liste des commandes (Index).
     */
    public function index(Request $request)
    {
        // Récupération du statut de filtre de la requête (ex: /admin/orders?status=pending)
        $status = $request->get('status');
        
        $query = Order::with('customer')->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $orders = $query->paginate(20);

        // Calcul des totaux par statut pour les filtres du tableau de bord
        $statusCounts = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');

        return view('admin.orders.index', compact('orders', 'statusCounts', 'status'));
    }

    /**
     * Affiche les détails d'une commande (SHOW).
     */
    public function show(Order $order)
    {
        // CORRECTION : Utilisation de 'orderItems.variant' car la relation est nommée 'orderItems' dans le modèle Order.
        $order->load('customer', 'orderItems.variant'); 
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * CONFIRME la commande (passe de 'pending' à 'processing').
     */
    public function confirm(Order $order)
    {
        // Condition de sécurité : on ne confirme qu'une commande en attente
        if ($order->status === 'pending') {
            $order->status = 'processing';
            $order->save();
            return redirect()->route('admin.orders.index')->with('success', "Commande #{$order->id} confirmée et mise en traitement.");
        }
        
        return redirect()->route('admin.orders.index')->with('error', "La commande #{$order->id} ne peut pas être confirmée (Statut actuel : {$order->status}).");
    }
    
    /**
     * ANNULE la commande.
     */
    public function cancel(Order $order)
    {
        // Condition de sécurité : on ne peut pas annuler une commande déjà terminée
        if ($order->status !== 'completed' && $order->status !== 'cancelled') {
            $order->status = 'cancelled';
            $order->save();
            return redirect()->route('admin.orders.index')->with('success', "Commande #{$order->id} annulée.");
        }
        
        return redirect()->route('admin.orders.index')->with('error', "La commande #{$order->id} ne peut pas être annulée (Statut actuel : {$order->status}).");
    }

    /**
     * Met à jour le statut d'une commande (UPDATE) - utilisé pour les changements manuels.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            // Ajout des statuts 'processing' et 'shipped' (expédiée)
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
        // Optionnel : Ajouter une vérification pour n'autoriser la suppression que si 'cancelled'
        // if ($order->status !== 'cancelled') { ... }
        
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'La commande a été supprimée.');
    }
}
