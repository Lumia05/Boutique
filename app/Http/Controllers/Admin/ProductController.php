<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
use App\Models\ProductsVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Affiche une liste de tous les produits.
     */
    public function index()
    {
        $products = Products::with('category')->latest()->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Affiche le formulaire pour créer un nouveau produit.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Stocke un nouveau produit dans la base de données.
     */
  public function store(Request $request)
{
    // 1. Validez les données du produit principal
    // Nous retirons 'price' et 'quantite' de cette validation
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'reference' => 'nullable|string|max:255|unique:products',
        'description' => 'nullable|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id' => 'required|exists:categories,id',
        'color' => 'nullable|string|max:255',
        'features' => 'nullable|string',
        'recommended_use' => 'nullable|string',
        'technical_info' => 'nullable|string',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image'] = 'storage/' . $imagePath;
    }

    // Gérer les chaînes de caractères pour les colonnes JSON ou texte
    $validatedData['features'] = $request->features;
    $validatedData['technical_info'] = $request->technical_info;
    
    // 2. Créez le produit de base sans les données de variantes
    $product = Products::create($validatedData);

    // 3. Validez et enregistrez les variantes
    if ($request->has('variants')) {
        // Le formulaire a été soumis avec plusieurs variantes
        $request->validate([
            'variants' => 'required|array',
            'variants.*.size' => 'required|string',
            'variants.*.price' => 'required|numeric|min:0',
            'variants.*.quantite' => 'required|integer|min:0',
        ]);

        foreach ($request->variants as $variantData) {
            ProductsVariant::create([
                'product_id' => $product->id,
                'size' => $variantData['size'],
                'price' => $variantData['price'],
                'quantite' => $variantData['quantite'],
            ]);
        }
    } else {
        // C'est un produit simple, nous créons une seule variante par défaut
        ProductsVariant::create([
            'product_id' => $product->id,
            'size' => 'Taille unique', // Ou un autre libellé par défaut
            'price' => $request->input('price', 0), // Assurez-vous d'avoir ce champ dans le formulaire
            'quantite' => $request->input('quantite', 0), // Assurez-vous d'avoir ce champ dans le formulaire
        ]);
    }

    return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès.');
}

    /**
     * Affiche les détails d'un produit.
     */
    public function show(Products $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Affiche le formulaire pour modifier un produit existant.
     */
    public function edit(Products $product)
    {
        $categories = Category::all();
          $product->load('variants'); // Chargement des variantes associées
        return view('admin.products.edit', compact('product', 'categories'));
    }
    public function editModal(Products $product)
    {
        $categories = Category::all();
        return view('admin.products.edit_modal_content', compact('product', 'categories'));
    }

    /**
     * Met à jour un produit existant dans la base de données.
     */
   public function update(Request $request, Products $product)
{
    // 1. Validez les données du produit parent
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'reference' => ['nullable', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'category_id' => 'required|exists:categories,id',
        'color' => 'nullable|string|max:255',
        'features' => 'nullable|string',
        'recommended_use' => 'nullable|string',
        'technical_info' => 'nullable|string',
    ]);

    // 2. Traitez l'image si elle est mise à jour
    if ($request->hasFile('image')) {
        if ($product->image && Storage::disk('public')->exists(str_replace('storage/', '', $product->image))) {
            Storage::disk('public')->delete(str_replace('storage/', '', $product->image));
        }
        $imagePath = $request->file('image')->store('images', 'public');
        $validatedData['image'] = 'storage/' . $imagePath;
    }

    // 3. Mettez à jour le produit parent
    $product->update($validatedData);

    // 4. Gérez la synchronisation des variantes
    $submittedVariants = collect($request->input('variants', []));
    $existingVariantIds = $product->variants->pluck('id');
    
    // Identifiez les variantes à supprimer (celles qui ne sont plus dans le formulaire)
    $variantsToDelete = $existingVariantIds->diff($submittedVariants->pluck('id'));
    if ($variantsToDelete->isNotEmpty()) {
        $product->variants()->whereIn('id', $variantsToDelete)->delete();
    }
    
    // Mettez à jour les variantes existantes et créez les nouvelles
    foreach ($submittedVariants as $variantData) {
        if (isset($variantData['id'])) {
            // C'est une variante existante, on la met à jour
            $variant = $product->variants()->find($variantData['id']);
            if ($variant) {
                $variant->update([
                    'size' => $variantData['size'],
                    'price' => $variantData['price'],
                    'quantite' => $variantData['quantite'],
                ]);
            }
        } else {
            // C'est une nouvelle variante, on la crée
            $product->variants()->create([
                'size' => $variantData['size'],
                'price' => $variantData['price'],
                'quantite' => $variantData['quantite'],
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès.');
}

    /**
     * Supprime un produit de la base de données.
     */
    public function destroy(Products $product)
    {
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès.');
    }
    
}