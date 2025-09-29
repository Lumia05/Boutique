<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Products;
use App\Models\ProductVariant;

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier.
     */
    public function index()
    {
        $cartItems = Session::get('cart', []);
        return view('cart.index', compact('cartItems'));
    }

    /**
     * Ajoute un produit ou une variante au panier.
     */
    public function add(Request $request)
    {
        // 🚨 ÉTAPE DE DÉBOGAGE 1: Validation de la requête
        // Laissez la validation pour tester l'intégrité des données
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ]);
        
        $itemId = $request->input('variant_id') ?? $request->input('product_id');
        $quantity = (int) $request->input('quantity');

        $item = null;
        $name = '';
        $price = 0;
        $image = null;

        if ($request->filled('variant_id')) {
            // Tente de trouver la VARIANTE avec son produit parent
            $item = ProductVariant::with('product')->find($itemId);
            
            if (!$item || !$item->product) {
                return redirect()->back()->with('error', 'Variante ou produit parent introuvable.');
            }

            // Récupération des informations de la variante
            $name = $item->product->name . ' - ' . ($item->color ?? '') . ($item->size ? ', ' . $item->size : '') . ($item->weight ? ', ' . $item->weight : '');
            $price = $item->promotion_price ?? $item->price;
            $image = $item->product->image;

        } else {
            // Tente de trouver le PRODUIT simple
            $item = Products::find($itemId);
            
            if (!$item) {
                return redirect()->back()->with('error', 'Produit introuvable.');
            }

            // Récupération des informations du produit simple
            $name = $item->name;
            $price = $item->promotion_price ?? $item->price;
            $image = $item->image;
        }

        // --- Logique d'ajout/mise à jour du panier en session ---

        $cart = Session::get('cart', []);

        $cartItemData = [
            'id' => $itemId,
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity,
            'image' => $image,
            'is_variant' => $request->filled('variant_id'),
        ];

        if (isset($cart[$itemId])) {
            $cart[$itemId]['quantity'] += $quantity;
        } else {
            $cart[$itemId] = $cartItemData;
        }

        Session::put('cart', $cart);

        // 🚨 POINT D'ARRÊT FORCÉ : Si l'exécution atteint cette ligne, le panier est rempli.
        dd(['Statut' => 'Prêt à rediriger', 'Panier Actuel' => $cart]); 

        // Si la ligne dd() est commentée, la redirection ci-dessous sera exécutée
        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier.');
    }
    
    /**
     * Met à jour la quantité d'un article spécifique.
     */
    public function update(Request $request)
    {
        $request->validate([
            'item_id' => 'required',
            'quantity' => 'required|integer|min:0',
        ]);

        $itemId = $request->input('item_id');
        $newQuantity = (int) $request->input('quantity');
        $cart = Session::get('cart', []);

        if (isset($cart[$itemId])) {
            if ($newQuantity <= 0) {
                unset($cart[$itemId]);
                $message = 'Produit retiré du panier.';
            } else {
                $cart[$itemId]['quantity'] = $newQuantity;
                $message = 'Quantité mise à jour.';
            }
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', $message);
        }

        return redirect()->route('cart.index')->with('error', 'Article non trouvé dans le panier.');
    }

    /**
     * Retire un article spécifique du panier.
     */
    public function remove($itemId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$itemId])) {
            unset($cart[$itemId]);
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
        }
        
        return redirect()->route('cart.index')->with('error', 'Article non trouvé dans le panier.');
    }

    /**
     * Vide complètement le panier.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Le panier a été vidé.');
    }
}