<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Products;
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
        'price' => 'required|numeric',
        'quantite' => 'required|numeric',
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
    
    /**
     * Affiche le formulaire de modification d'un produit.
     * @param  Product  $product
     * @return \Illuminate\View\View
     */
    public function edit(Products $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Met à jour un produit dans la base de données.
     * @param  \Illuminate\Http\Request  $request
     * @param  Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Products $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantite' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'technical_info' => 'nullable|string',
            'hex_colors' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'promotion_price' => 'nullable|numeric|min:0',
            'promotion_start_date' => 'nullable|date',
            'promotion_end_date' => 'nullable|date|after_or_equal:promotion_start_date',
        ]);
    
        // Mettre à jour les champs existants
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->quantite = $request->input('quantite');
        $product->description = $request->input('description');
        $product->technical_info = $request->input('technical_info');
        $product->color = $request->input('hex_colors');
    
        // Gérer les nouveaux champs de promotion
        $product->promotion_price = $request->input('promotion_price');
        $product->promotion_start_date = $request->input('promotion_start_date');
        $product->promotion_end_date = $request->input('promotion_end_date');
    
        if ($request->hasFile('image')) {
            // Logique pour sauvegarder la nouvelle image
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = 'storage/' . $imagePath;
        }
    
        $product->save();
    
        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès !');
    }
}