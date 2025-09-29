<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting; // Assurez-vous d'avoir un modèle Setting pour les paires clé-valeur
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
    /**
     * Affiche la vue de configuration générale (Responsable/Horaires).
     */
    public function index()
    {
        // Récupérer toutes les paires clé-valeur et les transformer en tableau associatif
        $settings = Setting::pluck('value', 'key')->all();

        // Si vous avez besoin de passer des experts pour une raison quelconque (par ex. le menu)
        // Mais nous allons le retirer pour le garder propre.
        // On ne passe que les settings.
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Met à jour les paramètres généraux.
     */
    public function update(Request $request)
    {
        // 1. Validation des champs généraux
        $validated = $request->validate([
            'shop_email'          => ['required', 'string', 'email', 'max:255'],
            'shop_phone'          => ['required', 'string', 'max:30'],
            'shop_opening_time'   => ['required', 'date_format:H:i'],
            'shop_closing_time'   => ['required', 'date_format:H:i', 'after:shop_opening_time'],
        ]);

        try {
            // 2. Sauvegarde des paires clé-valeur
            foreach ($validated as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }
            
            return redirect()->route('admin.settings.index')->with('success', 'Les informations générales ont été mises à jour avec succès.');

        } catch (\Exception $e) {
            // Gérer les erreurs de base de données ou autres
            return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement des paramètres.');
        }
    }
    
    // La méthode 'edit' n'est plus nécessaire car l'édition se fait sur index.blade.php
}