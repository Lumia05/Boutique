<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Pour la création automatique du slug

class CategoryController extends Controller
{
    // CONTOURNEMENT : Vérification manuelle de la connexion.
    public function __construct()
    {
        if (!Auth::check()) {
            redirect()->route('login')->send();
            exit();
        }
    }

    /**
     * Affiche la liste des catégories.
     */
    /**
     * Affiche la liste des catégories avec le comptage de produits récursif.
     */
    public function index(Request $request)
    {
        $search = trim((string) $request->input('q', ''));

        $query = Category::query()
            // IMPORTANT : Chargement des relations NÉCESSAIRES (Eager Loading)
            // 'children' est essentiel pour la récursion dans l'accesseur.
            // 'products' est essentiel pour le compte initial des produits directs.
            // 'parent' est pour l'affichage du nom du parent dans le tableau.
            ->with(['children', 'products', 'parent']) 
            ->orderBy('name');

        if ($search !== '') {
            // Logique de recherche (simplifiée ou celle que vous aviez)
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }
        
        // Exécution de la requête avec pagination
        $categories = $query->paginate(10)->appends(['q' => $search]);

        return view('admin.categories.index', compact('categories', 'search'));
    }
    /**
     * Affiche le formulaire de création de catégorie.
     */
   public function create()
    {
        // C'est ici que la variable est définie
        $parentCategories = Category::whereNull('parent_id')->get();
        
        // Et elle est correctement passée à la vue
        return view('admin.categories.create', compact('parentCategories'));
    }

    /**
     * Enregistre une nouvelle catégorie.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            // Génération du slug à partir du nom
            'slug' => Str::slug($request->name), 
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès.');
    }

    /**
     * Affiche le formulaire d'édition de catégorie.
     */
    public function edit(Category $category)
    {
        // ✅ LA VARIABLE EST CORRECTEMENT DÉFINIE ICI
        $parentCategories = Category::whereNull('parent_id')->get();
        
        // ✅ ET ELLE EST CORRECTEMENT PASSÉE À LA VUE
        return view('admin.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Met à jour la catégorie.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([
            // La validation unique doit ignorer l'ID actuel
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès.');
    }

    /**
     * Supprime la catégorie.
     */
    public function destroy(Category $category)
    {
        $category->delete(); 
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée avec succès.');
    }
}