<?php
// Fichier : app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware // <--- Doit correspondre au nom du fichier
{
    /**
     * Gère la vérification du rôle administrateur.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifie si l'utilisateur est connecté ET si le champ is_admin est vrai
        if (Auth::check() && Auth::user()->is_admin) {
            return $next($request);
        }
        
        // Si non autorisé, déconnecte (si nécessaire) et redirige
        Auth::logout();
        return redirect('/login')->with('error', 'Accès administrateur requis.'); 
    }
}