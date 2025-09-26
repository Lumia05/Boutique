<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Affiche le formulaire de connexion
    public function showLoginForm()
    {
        // Si l'utilisateur est déjà connecté, on le redirige directement vers l'admin
        if (Auth::check()) {
            return redirect('/admin');
        }
        return view('auth.login'); 
    }

    // Gère la tentative de connexion et vérifie le rôle
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tente de connecter l'utilisateur
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Vérifie si l'utilisateur est un administrateur
            if ($user->is_admin) {
                $request->session()->regenerate();
                // Redirection vers le tableau de bord admin
                return redirect()->intended('/admin'); 
            }

            // Si l'utilisateur n'est PAS admin
            Auth::logout(); // Déconnexion immédiate
            return back()->withErrors([
                'email' => 'Accès non autorisé : vous devez être administrateur.',
            ])->onlyInput('email');
        }

        // Échec des identifiants
        return back()->withErrors([
            'email' => 'Identifiants ou mot de passe incorrects.',
        ])->onlyInput('email');
    }

    // Gère la déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}