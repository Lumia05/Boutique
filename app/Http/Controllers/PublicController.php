<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products; // Assurez-vous d'importer le bon modèle de produit

class PublicController extends Controller
{
    /**
     * Affiche la page d'accueil avec les produits en vedette.
     */
    public function home()
    {
        // Récupère par exemple les 8 derniers produits ajoutés pour les afficher
        $products = Products::latest()->take(8)->get();
        
        return view('welcome', compact('products'));
    }

    /**
     * Affiche la page "À propos".
     */
    public function about()
    {
        return view('about');
    }

    /**
     * Affiche la page "Contact".
     */
    public function contact()
    {
        return view('contact');
    }

    /**
     * Affiche la page "Réalisations".
     */
    public function realisations()
    {
        return view('realisations'); 
    }
}