<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- LIGNE CRUCIALE : Import de la façade Auth

class DashboardController extends Controller
{
    // C'est notre nouveau constructeur qui n'utilise PAS la méthode middleware()
    public function __construct()
    {
        // Si l'utilisateur n'est PAS connecté, on le redirige vers le formulaire de connexion.
        if (!Auth::check()) {
            // L'utilisation de redirect()->route('login') est la façon la plus simple.
            // Le code die() est ici pour s'assurer que l'exécution s'arrête immédiatement
            // après la redirection, mais on utilise return.
            
            // REDIRECTION MANUELLE FORCÉE
            redirect()->route('login')->send(); // Le .send() garantit l'arrêt de l'exécution
            exit(); // On s'assure que rien ne s'exécute après
        }
    }

    /**
     * Affiche le tableau de bord de l'administration.
     */
    public function index()
    {
        // À ce stade, nous savons que l'utilisateur est connecté et le LoginController
        // a déjà vérifié qu'il était is_admin.
        return view('admin.dashboard.index'); 
    }
}