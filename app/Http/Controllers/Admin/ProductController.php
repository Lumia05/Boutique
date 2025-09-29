<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Category;
use App\Models\ProductVariant; // Nouveau modèle de variante
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // ... (constructeur et méthode index restent inchangés, sauf la validation) ...

    public function showVariants(Products $product)
    {
        // On s'assure que les variantes sont chargées pour la vue
        $product->load('variants');
        
        // Retourne la vue que nous avons créée (resources/views/admin/products/variants.blade.php)
        return view('admin.products.variants', compact('product'));
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->input('q', ''));

        $query = Products::query()
            ->with('category', 'variants') // Charger les variantes pour l'affichage dans l'index (optionnel mais utile)
            ->orderBy('created_at', 'desc');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        }

        $products = $query->paginate(10)->appends(['q' => $search]);

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create()
    {
        $categories = Category::all(); 
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Enregistre un nouveau produit et ses variantes.
     */

    // -----------------------------------------------------------
    // MÉTHODE STORE (CRÉATION)
    // -----------------------------------------------------------

    /**
     * Enregistre un nouveau produit et ses variantes.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Validation du Produit
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'is_active' => 'nullable|boolean',
            
            // Validation des listes de Variantes
            'variant_sizes.*' => 'required|string|max:100',
            'variant_colors.*' => 'nullable|string|max:100',
            'variant_weights.*' => 'nullable|string|max:100',
            'variant_prices.*' => 'required|numeric|min:0',
            'variant_promotion_prices.*' => 'nullable|numeric|min:0|lt:variant_prices.*', 
            
            // ✅ NOUVEAU : Validation des dates de promotion
            'variant_promo_start_dates.*' => 'nullable|date',
            'variant_promo_end_dates.*' => 'nullable|date|after_or_equal:variant_promo_start_dates.*',
            
            'variant_stocks.*' => 'required|integer|min:0',
        ]);

        // 1. Préparation et création du Produit
        $data = $request->except([
            'image', '_token', 
            'variant_sizes', 'variant_colors', 'variant_weights', 
            'variant_prices', 'variant_promotion_prices', 'variant_stocks',
            'variant_promo_start_dates', 'variant_promo_end_dates' // EXCLUSION DES NOUVELLES DATES
        ]);
        
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        
        if ($request->hasFile('image')) {
             $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product = Product::create($data);

        // 2. Enregistrement des variantes
        if ($request->has('variant_sizes')) {
            $variants = [];
            foreach ($request->variant_sizes as $key => $size) {
                // Création d'un nom de variante agrégé (pour la base de données)
                $name = "Taille: " . $size;
                if (!empty($request->variant_colors[$key])) {
                    $name .= " / Couleur: " . $request->variant_colors[$key];
                }

                $variants[] = new ProductVariant([
                    'size' => $size,
                    'color' => $request->variant_colors[$key] ?? null,
                    'weight' => $request->variant_weights[$key] ?? null,
                    'name' => $name, 
                    'price' => $request->variant_prices[$key],
                    'promotion_price' => $request->variant_promotion_prices[$key] ?? null,
                    
                    // ✅ NOUVEAU : Enregistrement des dates
                    'promotion_start_date' => $request->variant_promo_start_dates[$key] ?? null,
                    'promotion_end_date' => $request->variant_promo_end_dates[$key] ?? null,
                    
                    'stock' => $request->variant_stocks[$key],
                ]);
            }
            $product->variants()->saveMany($variants);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit et variantes créés avec succès.');
    }

    // -----------------------------------------------------------
    // MÉTHODE UPDATE (MODIFICATION)
    // -----------------------------------------------------------

    /**
     * Met à jour un produit existant et ses variantes.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            // Validation du Produit
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048', // Max 2MB
            'is_active' => 'nullable|boolean',
            
            // Validation des listes de Variantes
            'variant_sizes.*' => 'required|string|max:100',
            'variant_colors.*' => 'nullable|string|max:100',
            'variant_weights.*' => 'nullable|string|max:100',
            'variant_prices.*' => 'required|numeric|min:0',
            'variant_promotion_prices.*' => 'nullable|numeric|min:0|lt:variant_prices.*', 
            
            // ✅ NOUVEAU : Validation des dates de promotion
            'variant_promo_start_dates.*' => 'nullable|date',
            'variant_promo_end_dates.*' => 'nullable|date|after_or_equal:variant_promo_start_dates.*',
            
            'variant_stocks.*' => 'required|integer|min:0',
        ]);

        // 1. Préparation et mise à jour du Produit
        $data = $request->except([
            'image', '_token', '_method',
            'variant_sizes', 'variant_colors', 'variant_weights', 
            'variant_prices', 'variant_promotion_prices', 'variant_stocks',
            'variant_promo_start_dates', 'variant_promo_end_dates' // EXCLUSION DES NOUVELLES DATES
        ]);
        
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        
        if ($request->hasFile('image')) {
            // Suppression de l'ancienne image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
             $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product->update($data);
        
        // 2. Suppression et recréation des variantes (Approche simple pour l'édition)
        $product->variants()->delete();
        
        if ($request->has('variant_sizes')) {
            $variants = [];
            foreach ($request->variant_sizes as $key => $size) {
                // Création d'un nom de variante agrégé
                $name = "Taille: " . $size;
                if (!empty($request->variant_colors[$key])) {
                    $name .= " / Couleur: " . $request->variant_colors[$key];
                }

                $variants[] = new ProductVariant([
                    'size' => $size,
                    'color' => $request->variant_colors[$key] ?? null,
                    'weight' => $request->variant_weights[$key] ?? null,
                    'name' => $name, 
                    'price' => $request->variant_prices[$key],
                    'promotion_price' => $request->variant_promotion_prices[$key] ?? null,
                    
                    // ✅ NOUVEAU : Enregistrement des dates
                    'promotion_start_date' => $request->variant_promo_start_dates[$key] ?? null,
                    'promotion_end_date' => $request->variant_promo_end_dates[$key] ?? null,
                    
                    'stock' => $request->variant_stocks[$key],
                ]);
            }
            $product->variants()->saveMany($variants);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit et variantes mis à jour avec succès.');
    }
    public function edit(Products $product)
    {
        // Charger explicitement les variantes pour la vue d'édition
        $product->load('variants');
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }


    public function destroy(Product $product)
    {
        // 1. Suppression de l'image du produit (si elle existe)
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // 2. Suppression du produit. 
        // Les variantes associées (ProductVariant) seront automatiquement supprimées
        // par l'effet de la contrainte 'onDelete('cascade')' définie dans la migration.
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Le produit a été supprimé avec succès.');
    }

}