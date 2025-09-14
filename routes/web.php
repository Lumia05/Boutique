<?php
use Illuminate\Support\Facades\Route;

//Les modèles
use App\Models\Category; 
use App\Models\Products;

//Les contrôleurs
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ConfirmationController;

//Contrôleurs Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;


//Les routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/produits', [ProductsController::class, 'index']);
Route::get('/produits/{product}', [ProductsController::class, 'show'])->name('products.show');
Route::get('/produits/{product}/commander', [ProductsController::class, 'orderForm'])->name('products.order');
Route::post('/produits/{product}/commander', [ProductsController::class, 'processOrder'])->name('products.order.process');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::get('/confirmation', [ConfirmationController::class, 'index'])->name('confirmation.index');
Route::get('/cart/remove/{productId}', [CartController::class, 'remove'])->name('cart.remove');

// N'oubliez pas la route de déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Le groupe de routes est préfixé par 'admin'
// et le middleware 'auth' garantit l'accès aux utilisateurs connectés.
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Tableau de bord principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Gestion des produits
    Route::resource('products', AdminProductController::class);
    Route::get('/products/{product}/edit', [AdminProductController::class, 'edit'])->name('products.edit');

    // Route pour soumettre la modification
    Route::put('/products/{product}', [AdminProductController::class, 'update'])->name('products.update');

    // 3. Gestion des catégories
    Route::resource('categories', AdminCategoryController::class);
    // Contenu HTML pour la modale d'édition catégorie
    Route::get('/categories/{category}/edit-modal', [AdminCategoryController::class, 'editModal'])->name('categories.edit-modal');
});

// Routes pour la gestion des commandes
 Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// Routes pour la gestion du panier
Route::get('/panier', [CartController::class, 'index'])->name('cart.index');
Route::post('/panier/ajouter/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/panier/mettre-a-jour', [CartController::class, 'update'])->name('cart.update');
Route::post('/panier/retirer', [CartController::class, 'remove'])->name('cart.remove');

// Route pour afficher la page de la caisse avec le formulaire
Route::get('/caissse', [CheckoutController::class, 'index'])->name('checkout.index');

// Route pour soumettre le formulaire de la caisse
Route::post('/caissse', [CheckoutController::class, 'process'])->name('checkout.process');