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
     public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'required|string',
            'is_active' => 'nullable|in:1,0', 
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Validation des listes de variantes
            'variant_names.*' => 'required|string|max:100',
            'variant_prices.*' => 'required|numeric|min:0',
            // promotion_price est optionnel et peut être null
            'variant_promotion_prices.*' => 'nullable|numeric|min:0|lt:variant_prices.*', 
            'variant_stocks.*' => 'required|integer|min:0',
        ]);

        $data = $request->except(['image', '_token', 'variant_names', 'variant_prices', 'variant_promotion_prices', 'variant_stocks']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        
        // ... (gestion de l'image)
        
        $product = Products::create($data);

        // Enregistrement des variantes
        if ($request->has('variant_names')) {
            $variants = [];
            foreach ($request->variant_names as $key => $name) {
                // Vérifier la cohérence des données
                if (isset($request->variant_prices[$key]) && isset($request->variant_stocks[$key])) {
                    $variants[] = new \App\Models\ProductVariant([
                        'name' => $name,
                        'price' => $request->variant_prices[$key],
                        // Enregistrer le prix de promotion (peut être null)
                        'promotion_price' => $request->variant_promotion_prices[$key] ?? null,
                        'stock' => $request->variant_stocks[$key],
                    ]);
                }
            }
            $product->variants()->saveMany($variants);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit et variantes créés avec succès.');
    }

    public function edit(Products $product)
    {
        // Charger explicitement les variantes pour la vue d'édition
        $product->load('variants');
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Met à jour un produit existant et ses variantes.
     */
   public function update(Request $request, Products $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name,' . $product->id, 
            'description' => 'required|string',
            'is_active' => 'nullable|in:1,0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            
            // Validation des listes de variantes
            'variant_names.*' => 'required|string|max:100',
            'variant_prices.*' => 'required|numeric|min:0',
            'variant_promotion_prices.*' => 'nullable|numeric|min:0|lt:variant_prices.*', 
            'variant_stocks.*' => 'required|integer|min:0',
        ]);

        $data = $request->except(['image', '_token', '_method', 'variant_names', 'variant_prices', 'variant_promotion_prices', 'variant_stocks']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        
        // ... (gestion de l'image)

        $product->update($data);
        
        // 1. Suppression de toutes les anciennes variantes
        $product->variants()->delete();
        
        // 2. Enregistrement des nouvelles variantes
        if ($request->has('variant_names')) {
            $variants = [];
            foreach ($request->variant_names as $key => $name) {
                if (isset($request->variant_prices[$key]) && isset($request->variant_stocks[$key])) {
                    $variants[] = new \App\Models\ProductVariant([
                        'name' => $name,
                        'price' => $request->variant_prices[$key],
                        'promotion_price' => $request->variant_promotion_prices[$key] ?? null,
                        'stock' => $request->variant_stocks[$key],
                    ]);
                }
            }
            $product->variants()->saveMany($variants);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produit et variantes mis à jour avec succès.');
    }

    // ... (méthode destroy inchangée) ...
}