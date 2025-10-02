<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Products;
use App\Models\ProductVariant;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\CheckoutRequest; // Non utilisé, mais laissé pour compatibilité
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect; // <-- ESSENTIEL POUR LA REDIRECTION

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
            $price = $item['promotion_price'] ?? $item['price'];
            $total += $price * $item['quantity'];
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

        // --- DÉTERMINATION DU NOM DE L'ARTICLE AVEC VARIANTE ---
        $itemName = $product->name;
        if ($variant->color) {
            $itemName .= ' - ' . $variant->color;
        }
        if ($variant->size) {
            $itemName .= ' / ' . $variant->size;
        }
        // --- FIN DE LA DÉTERMINATION DU NOM ---

        // 1. Détermination du prix de base et promotionnel à partir de la VARIANTE.
        // NOTE: On suppose que ProductVariant a les champs 'price' et 'promotion_price'.
        $basePrice = $variant->price;
        $promoPrice = $variant->promotion_price;
        
        // 2. Détermination si la promotion est active (utilisation des dates du produit principal pour la période)
        // On vérifie que le prix promo de la variante existe ET que les dates du produit principal sont valides.
        $isPromotionActive = $promoPrice && $product->promotion_price && Carbon::now()->between($product->promotion_start_date, $product->promotion_end_date);
        
        $itemData = [
            'id' => $product->id, 
            'variant_id' => $variantId, // ID de la variante (clé critique pour le panier)
            'name' => $itemName, 
            // CORRECTION: Utilisation des prix de la variante pour l'enregistrement en session:
            'price' => $basePrice, 
            'promotion_price' => $isPromotionActive ? $promoPrice : null,
            'image' => $product->image_url,
            // Récupération des attributs de la variante pour l'affichage (optionnel car déjà dans 'name')
            'color' => $variant->color, 
            'size' => $variant->size,
            'quantity' => $quantity
        ];

        // Si l'article (variante) existe déjà, on ajoute la quantité
        if (isset($cart[$variantId])) {
            $cart[$variantId]['quantity'] += $quantity;
        } else {
            // Sinon, on l'ajoute
            $cart[$variantId] = $itemData;
        }

        Session::put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier avec succès !');
    }

    /**
     * Met à jour la quantité d'une variante dans le panier.
     */
    public function update(Request $request, $variantId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $newQuantity = (int) $request->input('quantity');
        $cart = Session::get('cart', []);

        if (isset($cart[$variantId])) {
            // Mettre à jour la quantité
            $cart[$variantId]['quantity'] = $newQuantity;
            Session::put('cart', $cart);
            $message = 'Quantité mise à jour avec succès.';
        } else {
            $message = 'Erreur : Article introuvable dans le panier.';
        }
        
        // Redirection vers la page du panier pour rafraîchir
        return Redirect::route('cart.index')->with('success', $message);
    }
    
    /**
     * Retire un produit du panier.
     */
    public function remove($variantId)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$variantId])) {
            unset($cart[$variantId]);
            Session::put('cart', $cart);
            return redirect()->route('cart.index')->with('success', 'Article retiré du panier.');
        }

        return redirect()->route('cart.index')->with('error', 'Erreur : Article introuvable.');
    }

    // --- LOGIQUE DE CHECKOUT ---

    /**
     * Affiche la page de checkout.
     */
    public function indexCheckout()
    {
         $cart = Session::get('cart', []);
         $total = 0;
         foreach ($cart as $item) {
             $total += ($item['promotion_price'] ?? $item['price']) * $item['quantity'];
         }

        // On initialise les frais de livraison à 2000 FCFA par défaut (Livraison à Domicile)
        // L'initialisation du total est nécessaire pour l'affichage initial
        $deliveryFee = 2000; 
        $grandTotal = $total + $deliveryFee;

        // Si la validation échoue, old('delivery_option') est utilisé. 
        // Si old('delivery_option') existe et n'est PAS 'home', on ajuste le total pour l'affichage post-échec.
        $oldDeliveryOption = old('delivery_option');
        if($oldDeliveryOption && $oldDeliveryOption !== 'home') {
            $deliveryFee = 0;
            $grandTotal = $total;
        }


        // Vous devriez utiliser une vue spécifique pour le checkout
        return view('checkout.index', compact('cart', 'total', 'deliveryFee', 'grandTotal'));
    }

    /**
     * Traite la commande.
     */
    public function storeCheckout(Request $request)
    {
        // Validation des données de commande
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255', // Mail est optionnel
            'phone' => 'required|string|max:20',
            'delivery_option' => 'required|in:home,pickup',
            'address' => 'required_if:delivery_option,home|nullable|string|max:255',
        ]);
        
        // 1. Vérification du panier
        if (empty(Session::get('cart', []))) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        // 2. Trouver ou créer le client
        $customer = Customer::firstOrCreate([
            'email' => $request->input('email')
        ], [
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('phone')), // ou un autre champ
        ]);

        // 3. Calcul du total avec les frais de livraison
        $cart = Session::get('cart', []);
        $total = 0;
        
        foreach ($cart as $item) {
            $total += ($item['promotion_price'] ?? $item['price']) * $item['quantity'];
        }

        $deliveryFee = 0;
        if ($request->input('delivery_option') === 'home') {
            $deliveryFee = 2000; // Frais de livraison fixe
        }
        $grandTotal = $total + $deliveryFee;


        // 4. Création de la commande
        $order = new Order();
        $order->customer_id = $customer->id;
        $order->total_price = $grandTotal; 
        $order->option = $request->input('delivery_option'); 
        
        if ($request->input('delivery_option') === 'home') {
             $order->address = $request->input('address');
        }

        $order->save();

        // 5. Enregistrement des articles de la commande
        foreach ($cart as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            
            // Ligne corrigée : Utilisation de 'quantite' pour correspondre à la DB.
            $orderItem->product_variant_id = $item['variant_id']; 

            // CORRECTION CRITIQUE: Changement de 'quantity' à 'quantite' pour correspondre à la DB.
            $orderItem->quantite = $item['quantity']; 

            $orderItem->price = $item['promotion_price'] ?? $item['price'];
            $orderItem->save();
        }

        // 6. Vider le panier
        Session::forget('cart');

        // Redirection vers l'accueil avec succès
        return redirect('/')->with('success', 'Votre commande a été passée avec succès et est en cours de traitement. Un email de confirmation vous sera envoyé.');
    }
}
