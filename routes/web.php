<?php

use Illuminate\Support\Facades\Route;

// =========================================================================
// CONTROLEURS
// =========================================================================

// Contrôleurs PUBLICS
use App\Http\Controllers\PublicController; // Pages statiques (Accueil, À Propos, Contact, Réalisations)
use App\Http\Controllers\ProductsController; // Produits (client)
use App\Http\Controllers\CartController; // Panier
use App\Http\Controllers\CheckoutController; // Caisse

// Contrôleur AUTHENTIFICATION (Manuelle)
use App\Http\Controllers\Auth\LoginController;

// Contrôleurs ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController; 
// use App\Http\Controllers\Admin\ProductController as AdminProductController; 
// use App\Http\Controllers\Admin\OrderController; 


/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES (FRONT-END)
|--------------------------------------------------------------------------
| Ces routes sont accessibles à tous.
*/

// Pages statiques (Accueil, À propos, Contact, Réalisations)
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/a-propos', [PublicController::class, 'about'])->name('about.index');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact.index');
Route::get('/realisations', [PublicController::class, 'realisations'])->name('realisations.index');

// Routes Commerce Électronique (Client)
Route::get('/produits', [ProductsController::class, 'index'])->name('products.index');
Route::get('/produits/{product}', [ProductsController::class, 'show'])->name('products.show');
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::get('/caissse', [CheckoutController::class, 'index'])->name('checkout.index');


/*
|--------------------------------------------------------------------------
| ROUTES AUTHENTIFICATION (MANUELLE)
|--------------------------------------------------------------------------
| Gérées uniquement par notre LoginController.
*/

// Affichage du formulaire de connexion
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
// Soumission des identifiants (gère la vérification is_admin et la redirection)
Route::post('/login', [LoginController::class, 'login']);
// Déconnexion (accessible uniquement si l'utilisateur est connecté)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


/*
|--------------------------------------------------------------------------
| ROUTES DE LA ZONE ADMINISTRATEUR (BACK-END)
|--------------------------------------------------------------------------
| Protégées par 'auth' (connecté) et 'admin' (est un admin).
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // 1. Tableau de bord principal (sera accessible par /admin)
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Gestion des Paramètres/Experts (Prochaine étape)
    Route::resource('settings', SettingController::class)->only(['index', 'store']); 

    // 3. Les autres Route::resource (à décommenter/créer plus tard)
    // Route::resource('products', AdminProductController::class);
    // Route::resource('orders', OrderController::class);
    // Route::resource('users', UserController::class); 
});