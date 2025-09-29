<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpertContact;
use App\Models\Setting; // Assurez-vous que ce modèle existe pour les configs

class ContactController extends Controller
{
    /**
     * Affiche la page de contact avec les experts actifs, le responsable et les horaires.
     */
    public function index()
    {
        // 1. Récupération des Experts Actifs (pour la section "Contactez nos Experts Directement")
        $experts = ExpertContact::where('is_active', true)
                                ->orderBy('sort_order', 'asc')
                                ->orderBy('name', 'asc')
                                ->get();
                                
        // 2. Récupération des Configurations (Informations Générales)
        // Les clés sont déduites des champs souvent utilisés dans une table Setting
        $settings = Setting::pluck('value', 'key')->toArray();

        // 3. Structuration des Données du Responsable (pour la vue)
        $manager = [
            'email' => $settings['manager_email_destinataire'] ?? 'contact@globalretail.com',
            'phone' => $settings['manager_telephone_principal'] ?? '+237 6XX XX XX XX',
        ];

        // 4. Structuration des Horaires (pour la vue)
        // Les horaires sont supposés être stockés sous forme d'heures brutes (ex: 08:00 et 17:00)
        $hours = [
            'open' => $settings['heure_ouverture'] ?? '08:00',
            'close' => $settings['heure_fermeture'] ?? '17:00',
        ];
                                
        // Passage de toutes les données à la vue
        return view('contact', compact('experts', 'manager', 'hours'));
    }
}