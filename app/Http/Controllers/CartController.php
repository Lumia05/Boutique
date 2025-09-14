<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Products;

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        return view('cart.index', compact('cart'));
    }

    /**
     * Ajoute un produit au panier.
     */
    public function add(Request $request, Products $product)
    {
        $quantity = $request->input('quantity', 1);

        // Vérification de la quantité disponible en stock
        if ($product->quantite < $quantity) {
            return back()->with('error', 'Stock insuffisant pour ce produit.');
        }

        $cart = Session::get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'image' => $product->image,
            ];
        }

        Session::put('cart', $cart);

        // Utilisation d'une route nommée pour la redirection
        return redirect()->route('products.show', $product->id)->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Met à jour la quantité d'un produit dans le panier.
     */
    public function update(Request $request)
    {
        $productId = $request->product_id;
        $quantity = $request->quantite;
    
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            $product = Products::find($productId);
            if ($product->quantite < $quantity) {
                return back()->with('error', 'Quantité demandée supérieure au stock disponible.');
            }
            $cart[$productId]['quantity'] = $quantity;
        }
    
        Session::put('cart', $cart);
    
        return back()->with('success', 'Quantité mise à jour.');
    }

    /**
     * Retire un produit du panier.
     */
    public function remove(Request $request)
    {
        $productId = $request->product_id;
        $cart = Session::get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);
        }

        return back()->with('success', 'Produit retiré du panier.');
    }
}