<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
 // Nécessaire pour la redirection manuelle

// =========================================================================
// CONTROLEURS
// =========================================================================

// Contrôleurs PUBLICS
use App\Http\Controllers\PublicController; 
use App\Http\Controllers\ContactController;
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
use App\Http\Controllers\Admin\ExpertContactController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ReportsController;
// ... (autres contrôleurs Admin)


/*
|--------------------------------------------------------------------------
| ROUTES PUBLIQUES (FRONT-END)
|--------------------------------------------------------------------------
*/
// ... (Vos routes publiques restent inchangées ici)
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/a-propos', [PublicController::class, 'about'])->name('about.index');
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::get('/realisations', [PublicController::class, 'realisations'])->name('realisations.index');

// Routes Commerce Électronique (Client)
Route::get('/produits', [ProductsController::class, 'index'])->name('products.index');
Route::get('/produits/{product}', [ProductsController::class, 'show'])->name('products.show');

/*
|--------------------------------------------------------------------------
| ROUTES DU PANIER (CLIENT)
|--------------------------------------------------------------------------
*/

Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter', [CartController::class, 'add'])->name('cart.add');
Route::get('/panier/retirer', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/panier/vider', [CartController::class, 'clear'])->name('cart.clear');


// Route DELETE pour retirer un article du panier
Route::delete('/panier/retirer/{variantId}', [CartController::class, 'remove'])->name('cart.remove');

// GESTION DU CHECKOUT (Passage à la caisse)
Route::get('/checkout', [CartController::class, 'indexCheckout'])->name('checkout.index');
Route::post('/checkout/commande', [CartController::class, 'storeCheckout'])->name('checkout.store');

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


    // ✅ 2. Gestion des Paramètres Uniques (Email, Téléphone, Heures)
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    Route::get('/settings/edit', [SettingController::class, 'edit'])->name('admin.settings.edit');

// ✅ 3. Gestion des Experts Multiples (CRUD)
    Route::resource('expert-contacts', ExpertContactController::class)
        // Nous excluons 'show' car vous n'avez pas besoin d'une page de détail individuelle
        ->except(['show']) 
        // Cette ligne garantit que les noms des routes seront :
        // admin.expert_contacts.index, admin.expert_contacts.store, etc.
        ->names('expert_contacts'); 
// --- FIN DU BLOC EXPERT CONTACTS ---

    // 4. Gestion des Catégories
    Route::resource('categories', CategoryController::class); 

    // 5. Gestion des Produits
    Route::resource('products', ProductController::class);
    Route::get('products/{product}/variants', [ProductController::class, 'showVariants'])->name('products.variants.index');

     // GESTION DES COMMANDES
    Route::resource('orders', OrderController::class)
        ->only(['index', 'show', 'update', 'destroy'])
        ->names('orders');
     Route::post('orders/{order}/confirm', [OrderController::class, 'confirm'])->name('orders.confirm');
     Route::post('orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
    // GESTION DES CLIENTS
    Route::resource('customers', CustomerController::class) // Changement d'URI
        ->only(['index', 'show', 'update'])
        ->names('customers'); // Changement de nommage
    
    //Rapports et Stats
    Route::get('reports', [ReportsController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [ReportsController::class, 'generate'])->name('reports.generate');
    // ... (autres Route::resource futures)
});