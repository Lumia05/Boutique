<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ici, vous récupérerez les statistiques clés (commandes, produits, clients)
        // pour les afficher sur le tableau de bord. Pour l'instant, on se contente d'afficher la vue.
        
        return view('admin.dashboard.index');
    }
}