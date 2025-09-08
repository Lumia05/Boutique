<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Affiche une liste de toutes les commandes.
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Affiche les détails d'une commande spécifique.
     */
    public function show(Order $order)
    {
        // Charge les relations pour éviter les requêtes inutiles
        $order->load('user', 'items.product');

        return view('admin.orders.show', compact('order'));
    }
}