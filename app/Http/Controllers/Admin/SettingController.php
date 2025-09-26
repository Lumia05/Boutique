<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth; // Nécessaire pour le contournement Auth::check()

class SettingController extends Controller
{
    // CONTOURNEMENT : Vérification manuelle de la connexion dans le constructeur.
    public function __construct()
    {
        // Si l'utilisateur n'est PAS connecté, on le redirige vers le formulaire de connexion.
        if (!Auth::check()) {
            redirect()->route('login')->send();
            exit();
        }
    }

    /**
     * Affiche le formulaire de gestion des paramètres (Contacts experts).
     */
    public function index()
    {
        // firstOrCreate récupère l'unique ligne existante ou la crée si elle n'existe pas.
        $setting = Setting::firstOrCreate([]); 

        // Renvoie à la vue qui utilise votre layout d'administration.
        return view('admin.settings.index', compact('setting'));
    }

    /**
     * Met à jour les paramètres (Contacts experts).
     */
     public function store(Request $request)
    {
        // 1. Validation des données
        $request->validate([
            'expert1_name' => 'nullable|string|max:255',
            'expert1_email' => 'nullable|email|max:255',
            'expert1_phone' => 'nullable|string|max:20',
            'expert1_expertise' => 'nullable|string|max:255', // Validation ajoutée
            
            'expert2_name' => 'nullable|string|max:255',
            'expert2_email' => 'nullable|email|max:255',
            'expert2_phone' => 'nullable|string|max:20',
            'expert2_expertise' => 'nullable|string|max:255', // Validation ajoutée

            'opening_time' => 'nullable|date_format:H:i', // Validation Heure (ex: 09:00)
            'closing_time' => 'nullable|date_format:H:i|after:opening_time', // Validation Heure
            'closing_days' => 'nullable|string|max:255',
            'footer_text' => 'nullable|string|max:500',
        ]);

        // 2. Récupération ou création de l'unique ligne
        $setting = Setting::firstOrCreate([]);

        // 3. Mise à jour des données (Utilise request()->all() pour la simplicité, 
        // ou la liste complète des champs 'fillable' si vous préférez)
        $setting->update($request->only([
            'expert1_name', 'expert1_email', 'expert1_phone', 'expert1_expertise',
            'expert2_name', 'expert2_email', 'expert2_phone', 'expert2_expertise',
            'opening_time', 'closing_time', 'closing_days', 'footer_text',
        ]));

        return redirect()->route('admin.settings.index')->with('success', 'Les paramètres de la boutique ont été mis à jour avec succès.');
    }
}