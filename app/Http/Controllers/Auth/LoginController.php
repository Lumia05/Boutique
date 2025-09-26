<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Affiche le formulaire de connexion.
     * Cette route GET est accessible sans restriction (nous avons retiré le middleware 'guest' des routes)
     * pour éviter la boucle de redirection.
     */
    public function showLoginForm()
    {
        // Si l'utilisateur est déjà connecté, nous le redirigeons vers sa zone.
        // C'est une vérification de sécurité supplémentaire, même si le problème est souvent
        // géré par le middleware RedirectIfAuthenticated.
        if (Auth::check() && Auth::user()->is_admin) {
             return redirect('/admin');
        }
        
        return view('auth.login'); 
    }

    /**
     * Gère la soumission du formulaire et la logique de connexion/vérification de rôle.
     */
    public function login(Request $request)
    {
        // 1. Validation des identifiants
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Tente de connecter l'utilisateur
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // 3. VÉRIFICATION DU RÔLE : L'utilisateur doit être administrateur
            if ($user->is_admin) {
                $request->session()->regenerate();
                // Redirection réussie et garantie vers le tableau de bord admin
                return redirect()->intended('/admin'); 
            }

            // 4. Si l'utilisateur est un simple client (is_admin = 0)
            Auth::logout(); // Déconnexion immédiate du client
            return back()->withErrors([
                'email' => 'Accès non autorisé. Seuls les administrateurs peuvent se connecter ici.',
            ])->onlyInput('email');
        }

        // 5. Échec des identifiants (mot de passe ou email incorrect)
        return back()->withErrors([
            'email' => 'Identifiants ou mot de passe incorrects.',
        ])->onlyInput('email');
    }

    /**
     * Gère la déconnexion.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        // Après déconnexion, retour à la page d'accueil de la boutique
        return redirect('/'); 
    }
}