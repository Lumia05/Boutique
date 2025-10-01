<?php

namespace App\Http\Controllers;

// CORRECTION 1 : L'importation de Request était déjà présente, mais j'ajoute les imports qui manquaient potentiellement
use Illuminate\Http\Request; 
use App\Models\Products;
use App\Models\ProductVariant;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\CheckoutRequest;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CartController extends Controller
{
    /**
     * Affiche le contenu du panier.
     */
    public function index()
    {
        // CORRECTION 2 : Utilisation de Session::get('cart', []) pour garantir un tableau vide si null.
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += ($item['promotion_price'] ?? $item['price']) * $item['quantity'];
        }

        // J'ai mis à jour le compact pour correspondre à la variable $cart, comme dans votre version initiale.
        return view('cart.index', compact('cart', 'total'));
    }

    /**
     * Ajoute un produit au panier.
     */
    public function add(Request $request, Products $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'required'
        ]);
        
        $quantity = $request->input('quantity');
        $variantId = $request->input('variant_id');
        // Utilisation de Session::get('cart', []) ici aussi, pour la robustesse.
        $cart = Session::get('cart', []);
        
        $variant = ProductVariant::find($variantId);

        if (!$variant) {
            return redirect()->back()->with('error', 'La variante sélectionnée est introuvable.');
        }

        $isPromotionActive = $product->promotion_price && Carbon::now()->between($product->promotion_start_date, $product->promotion_end_date);
        
        $priceToStore = $isPromotionActive ? $product->promotion_price : $product->price;

        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $quantity;
        } else {
            $cart[$variantId] = [
                'id' => $variantId,
                'name' => $product->name . ' - ' . $variant->name, 
                'quantity' => $quantity,
                'price' => $product->price,
                'promotion_price' => $product->promotion_price, 
                'is_promotion_active' => $isPromotionActive,
            ];
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier.');
    }

    /**
     * Retire un article du panier.
     */
    public function remove(Request $request, $variantId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$variantId])) {
            unset($cart[$variantId]);
            Session::put('cart', $cart);
            return back()->with('success', 'Article retiré du panier.');
        }

        return back()->with('error', 'Article non trouvé dans le panier.');
    }

    /**
     * Vide complètement le panier.
     */
    public function clear()
    {
        Session::forget('cart');
        return back()->with('success', 'Votre panier a été vidé.');
    }
    
    /**
     * Gère la finalisation de la commande. (Votre méthode originale conservée)
     */
    public function checkout(CheckoutRequest $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'delivery_option' => 'required|in:store,home',
            'address' => 'nullable|string|max:255', // Requis si delivery_option est 'home'
        ]);

        // 1. Trouver ou créer le client
        $customer = Customer::firstOrCreate([
            'phone' => $request->input('phone'),
        ], [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('phone')), // ou un autre champ
        ]);

        // 3. Calcul du total avec les frais de livraison
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += ($item['promotion_price'] ?? $item['price']) * $item['quantity'];
        }

        if ($request->input('delivery_option') === 'home') {
            $total += 2000;
        }

        // 4. Création de la commande
        $order = new Order();
        $order->customer_id = $customer->id;
        $order->total_price = $total;
        $order->option = $request->input('delivery_option');
        
        if ($request->input('delivery_option') === 'home') {
             $order->delivery_address = $request->input('address');
        }

        $order->save();

        // 5. Enregistrement des articles de la commande
        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item['id'];
            $orderItem->quantity = $item['quantity'];
            $orderItem->price = $item['promotion_price'] ?? $item['price'];
            $orderItem->save();
        }

        // 6. Vider le panier
        Session::forget('cart');

        return redirect('/')->with('success', 'Votre commande a été passée avec succès. Nous vous contacterons bientôt !');
    }
}
