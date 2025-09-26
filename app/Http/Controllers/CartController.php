<?php

namespace App\Http\Controllers;

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
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += ($item['promotion_price'] ?? $item['price']) * $item['quantity'];
        }

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
        $cart = Session::get('cart', []);
        
        $variant = ProductVariant::find($variantId);

        if (!$variant) {
            return redirect()->back()->with('error', 'La variante sélectionnée est introuvable.');
        }

        $isPromotionActive = $product->promotion_price && Carbon::now()->between($product->promotion_start_date, $product->promotion_end_date);
        
        $price = $variant->price;
        $promotion_price = $isPromotionActive ? $product->promotion_price : null;

        $rowId = uniqid();

        foreach ($cart as $key => $item) {
            if ($item['variant_id'] == $variantId) {
                $cart[$key]['quantity'] += $quantity;
                Session::put('cart', $cart);
                return redirect()->route('cart.index')->with('success', 'Quantité mise à jour!');
            }
        }

        $cart[$rowId] = [
            'id' => $product->id,
            'variant_id' => $variantId,
            'name' => $product->name,
            'quantity' => $quantity,
            'price' => $price,
            'promotion_price' => $promotion_price,
            'image' => $product->image,
            'color' => $variant->color,
            'size' => $variant->size,
            'weight' => $variant->weight,
            'rowId' => $rowId
        ];
        
        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier!');
    }

    /**
     * Met à jour la quantité d'un produit dans le panier.
     */
    public function update(Request $request, $rowId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
    
        $cart = Session::get('cart', []);
        
        if (isset($cart[$rowId])) {
            $cart[$rowId]['quantity'] = $request->input('quantity');
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Quantité mise à jour!');
        }
        
        return redirect()->route('cart.index')->with('error', 'Produit introuvable dans le panier.');
    }

    /**
     * Retire un produit du panier.
     */
    public function remove($rowId)
    {
        $cart = Session::get('cart', []);
        
        if (isset($cart[$rowId])) {
            unset($cart[$rowId]);
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Produit retiré du panier.');
        }

        return redirect()->route('cart.index')->with('error', 'Produit introuvable dans le panier.');
    }

    /**
     * Vide le panier.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Le panier a été vidé.');
    }

    /**
     * Affiche la page de confirmation de la commande.
     */
    public function checkout()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += ($item['promotion_price'] ?? $item['price']) * $item['quantity'];
        }

        return view('cart.checkout', compact('cart', 'total'));
    }

    /**
     * Gère le processus de finalisation de la commande.
     */
    public function processCheckout(CheckoutRequest $request)
    {
        // 1. Validation des données du formulaire
            $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'required|string|max:20',
            'delivery_option' => 'required|string|in:home,store',
            'address' => 'required_if:delivery_option,home|string|max:255|nullable',
        ]);

        // 2. Trouver ou créer le client
        if ($request->input('email')) {
            $customer = Customer::firstOrCreate(
                ['email' => $request->input('email')],
                [
                    'name' => $request->input('name'),
                    'phone' => $request->input('phone'),
                    'password' => Hash::make($request->input('email')),
                ]
            );
        } else {
            // Si l'e-mail n'est pas fourni, on crée un nouveau client à chaque fois
            $customer = Customer::create([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('phone')), // ou un autre champ
            ]);
        }

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

        return redirect('/')->with('success', 'Votre commande a été passée avec succès ! Montant total : ' . number_format($total, 0, ',', '.') . ' FCFA');
    }
}