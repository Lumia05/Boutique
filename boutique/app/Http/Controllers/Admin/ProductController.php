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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => 'nullable|string|max:255|unique:products',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'color' => 'nullable|string|max:255',
            'features' => 'nullable|string', // On gère ça comme une chaîne de caractères
            'recommended_use' => 'nullable|string',
            'technical_info' => 'nullable|string',
            // Ajoutez d'autres règles de validation si nécessaire
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = 'storage/' . $imagePath;
        }

        // On gère les chaînes de caractères pour les colonnes JSON ou texte
        $validatedData['features'] = $request->features;
        $validatedData['technical_info'] = $request->technical_info;
        
        Products::create($validatedData);

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'reference' => ['nullable', 'string', 'max:255', Rule::unique('products')->ignore($product->id)],
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'color' => 'nullable|string|max:255',
            'features' => 'nullable|string',
            'recommended_use' => 'nullable|string',
            'technical_info' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('images', 'public');
            $validatedData['image'] = 'storage/' . $imagePath;
        }

        $validatedData['features'] = $request->features;
        $validatedData['technical_info'] = $request->technical_info;
        
        $product->update($validatedData);

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