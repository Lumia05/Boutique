<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Products;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /**
     * Affiche la page de validation du panier (checkout).
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $totalPrice = 0;

        foreach ($cart as $id => $details) {
            $product = Products::find($id);
            if (!$product) {
                continue;
            }

            $isPromotionActive = $product->promotion_price &&
                                 $product->promotion_start_date &&
                                 $product->promotion_end_date &&
                                 Carbon::now()->between($product->promotion_start_date, $product->promotion_end_date);

            $finalPrice = $isPromotionActive ? $product->promotion_price : $product->price;
            $totalPrice += $finalPrice * $details['quantity'];
        }

        return view('cart.checkout', compact('cart', 'totalPrice'));
    }

    /**
     * Gère la soumission du formulaire de paiement.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function process(Request $request)
    {
         $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_surname' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            // 'shipping_address' => 'required|string',
        ]);
        
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        try {
            // 1. Cherche un client existant ou en crée un nouveau
            $customer = Customer::firstOrCreate(
                ['surname' => $request->input('customer_surnanme')],
                [
                    'name' => $request->input('customer_name'),
                    'phone' => $request->input('customer_phone'),
                ]
            );

            // 2. Création de la commande
            $totalPrice = 0;
            $orderItems = [];
            foreach ($cart as $id => $details) {
                $product = Products::find($id);
                if (!$product) {
                    continue;
                }
                $finalPrice = $product->price;
                $totalPrice += $finalPrice * $details['quantite'];
                $orderItems[] = [
                    'product_id' => $id,
                    'quantite' => $details['quantite'],
                    'price' => $finalPrice,
                ];
            }

            $order = new Order();
            $order->customer_id = $customer->id; // Associe la commande au client
            $order->total_price = $totalPrice;
            $order->address = $request->input('shipping_address');
            $order->status = 'pending';
            $order->save();

            // 3. Sauvegarde des articles
            foreach ($orderItems as $item) {
                $orderItem = new OrderItem($item);
                $orderItem->order_id = $order->id;
                $orderItem->save();
            }

            $request->session()->forget('cart');
            return redirect()->route('products.index')->with('success', 'Votre commande a été soumise avec succès !');

        } catch (\Exception $e) {
            \Log::error('Erreur lors de la soumission de la commande : ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Une erreur inattendue est survenue. Veuillez réessayer plus tard.');
        }
    }
}