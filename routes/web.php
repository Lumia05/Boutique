<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Nécessaire pour la redirection manuelle

// =========================================================================
// CONTROLEURS
// =========================================================================

// Contrôleurs PUBLICS
use App\Http\Controllers\PublicController; 
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;

// Contrôleur AUTHENTIFICATION (Manuelle)
use App\Http\Controllers\Auth\LoginController;

// Contrôleurs ADMIN
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingController; 
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
// ... (autres contrôleurs Admin)


/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES (FRONT-END)
|--------------------------------------------------------------------------
*/
// ... (Vos routes publiques restent inchangées ici)
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
| ROUTES AUTHENTIFICATION (MINIMALISTE)
|--------------------------------------------------------------------------
*/

// Formulaire de connexion (GET) - ACCÈS LIBRE
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');

// Soumission du formulaire (POST)
Route::post('/login', [LoginController::class, 'login']);

// Déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| ROUTES DE LA ZONE ADMINISTRATEUR (BACK-END)
|--------------------------------------------------------------------------
*/
// La protection se fait via le constructeur du DashboardController
Route::prefix('admin')->name('admin.')->group(function () {
    
    // 1. Tableau de bord principal
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Gestion des Paramètres/Experts (Prochaine étape)
    Route::resource('settings', SettingController::class)->only(['index', 'store']); 

    // 2. Gestion des Catégories
    Route::resource('categories', CategoryController::class); 

    // 3. Gestion des Produits
    Route::resource('products', ProductController::class);
    Route::get('products/{product}/variants', [ProductController::class, 'showVariants'])->name('products.variants.index');


    // ... (autres Route::resource futures)
});