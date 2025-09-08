<?php
use Illuminate\Support\Facades\Route;

//Les modèles
use App\Models\Category; 
use App\Models\Products;

//Les contrôleurs
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\Auth\LoginController;

//Contrôleurs Admin
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

//Les routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/produits', [ProductsController::class, 'index']);
Route::get('/produits/{product}', [ProductsController::class, 'show'])->name('products.show');
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// N'oubliez pas la route de déconnexion
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Le groupe de routes est préfixé par 'admin'
// et le middleware 'auth' garantit l'accès aux utilisateurs connectés.
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // 1. Tableau de bord principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 2. Gestion des produits
    Route::resource('products', AdminProductController::class);

    // 3. Gestion des catégories
    Route::resource('categories', AdminCategoryController::class);

    // 4. Gestion des commandes
    Route::resource('orders', AdminOrderController::class);

    // 5. Gestion des clients
    Route::resource('users', AdminUserController::class);
     // On peut ajouter une route pour télécharger les factures
    Route::get('/orders/{order}/invoice', [AdminOrderController::class, 'downloadInvoice'])->name('orders.invoice');
        // Ajoute une nouvelle route pour charger le formulaire d'édition de la modale
    // Dans routes/web.php
    Route::get('/admin/products/{product}/edit-modal', [ProductsController::class, 'editModal'])->name('admin.products.edit-modal');


});