<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Affiche une liste de tous les clients.
     */
    public function index()
    {
        // Récupère tous les utilisateurs paginés
      $users = User::where('role', '!=', 'admin')->latest()->paginate(20);

    return view('admin.users.index', compact('users'));
    }

    /**
     * Affiche les détails d'un client, y compris l'historique de ses commandes.
     */
    public function show(User $user)
    {
        // Charge les commandes du client avec leurs articles
        $user->load('orders.items.product');
        return view('admin.users.show', compact('user'));
    }

    // Nous laissons les autres méthodes (create, store, edit, update, destroy) vides pour le moment,
    // car la création et la modification des utilisateurs se font généralement via l'interface publique.
}