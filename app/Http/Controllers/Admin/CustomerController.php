<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer; // Utilisation du modèle Customer

class CustomerController extends Controller
{
    /**
     * Affiche la liste des clients (Index).
     */
    public function index()
    {
        // Récupère les clients, triés par les plus récents
        $customers = Customer::latest()->paginate(20);

        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Affiche le profil d'un client (SHOW).
     */
    public function show(Customer $customer)
    {
        // Charge l'historique des commandes du client
        $customer->load('order');
        
        return view('admin.customers.show', compact('customer'));
    }

    /**
     * Met à jour un client (UPDATE).
     */
    public function update(Request $request, Customer $customer)
    {
        // Assurez-vous d'utiliser la règle unique correctement si l'e-mail est modifiable
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:customers,email,' . $customer->id],
            // Ajouter d'autres champs de la table customer
        ]);

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)->with('success', 'Le profil client a été mis à jour.');
    }
    
    // Les méthodes create/store/destroy sont généralement évitées pour les clients/utilisateurs.
}