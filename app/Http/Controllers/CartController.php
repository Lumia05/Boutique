<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductVariant; // Si vous utilisez les variantes

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier.
     */
    public function index()
    {
        $cartItems = session()->get('cart', []); 
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Ajoute un produit ou une variante au panier (STORE).
     */
    public function add(Request $request)
    {
        $request->validate([
            // product_id est la référence, variant_id est l'élément précis
            'product_id' => 'required|exists:products,id', 
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $itemId = $request->input('variant_id') ?? $request->input('product_id');
        $isVariant = (bool)$request->input('variant_id');
        $quantity = $request->input('quantity');

        // Logique pour gérer la session du panier ici...
        
        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier.');
    }
    
    /**
     * Met à jour la quantité d'un article.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required', // ID de l'article dans le panier
            'quantity' => 'required|integer|min:0',
        ]);
        
        // Logique pour mettre à jour la quantité dans la session
        
        return redirect()->route('cart.index')->with('success', 'Quantité mise à jour.');
    }

    /**
     * Retire un article spécifique du panier.
     */
    public function remove($itemId)
    {
        // Logique pour retirer l'article de la session
        
        return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
    }

    /**
     * Vide complètement le panier.
     */
    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Le panier a été vidé.');
    }
}