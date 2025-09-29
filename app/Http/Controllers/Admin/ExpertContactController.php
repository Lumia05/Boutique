<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExpertContact; // Assurez-vous que le chemin est correct

class ExpertContactController extends Controller
{
    /**
     * Affiche la liste des experts (READ).
     */
    public function index()
    {
        // Récupère les experts triés par ordre de priorité puis par ID.
        $experts = ExpertContact::orderBy('sort_order', 'asc')
                                ->orderBy('id', 'asc')
                                ->get();

        return view('admin.expert_contacts.index', compact('experts'));
    }

    /**
     * Affiche le formulaire de création (CREATE).
     */
    public function create()
    {
        return view('admin.expert_contacts.create');
    }

    /**
     * Enregistre un nouvel expert dans la base de données (STORE).
     */
    public function store(Request $request)
    {
        // Validation : Nom et Rôle sont OBLIGATOIRES
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'role'      => ['required', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'whatsapp'  => ['nullable', 'url', 'max:255'],
            'sort_order'=> ['nullable', 'integer', 'min:0'],
        ]);

        ExpertContact::create([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            // Détermine 'is_active' en fonction de si la checkbox est présente
            'is_active' => $request->has('is_active'), 
        ]);

        return redirect()->route('admin.expert_contacts.index')->with('success', 'L\'expert a été ajouté avec succès.');
    }

    /**
     * Affiche le formulaire de modification (EDIT).
     */
    public function edit(ExpertContact $expertContact)
    {
        return view('admin.expert_contacts.edit', compact('expertContact'));
    }

    /**
     * Met à jour l'expert spécifié (UPDATE).
     */
    public function update(Request $request, ExpertContact $expertContact)
    {
        // Validation identique à 'store'
        $validated = $request->validate([
            'name'      => ['required', 'string', 'max:255'],
            'role'      => ['required', 'string', 'max:255'],
            'phone'     => ['nullable', 'string', 'max:30'],
            'whatsapp'  => ['nullable', 'url', 'max:255'],
            'sort_order'=> ['nullable', 'integer', 'min:0'],
        ]);

        $expertContact->update([
            'name' => $validated['name'],
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'whatsapp' => $validated['whatsapp'] ?? null,
            'sort_order' => $validated['sort_order'] ?? 0,
            // Met à jour 'is_active'
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.expert_contacts.index')->with('success', 'L\'expert a été mis à jour avec succès.');
    }

    /**
     * Supprime l'expert spécifié (DESTROY).
     */
    public function destroy(ExpertContact $expertContact)
    {
        $expertContact->delete();

        return redirect()->route('admin.expert_contacts.index')->with('success', 'L\'expert a été supprimé.');
    }
}