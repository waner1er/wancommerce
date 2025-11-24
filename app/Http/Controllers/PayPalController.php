<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CartService;
use App\Services\PayPalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PayPalController extends Controller
{
    public function success(Request $request)
    {
        $token = $request->query('token'); // PayPal order ID

        if (!$token) {
            return redirect()->route('checkout.payment')->with('error', 'Paiement invalide');
        }

        try {
            DB::beginTransaction();

            // Capture PayPal payment
            $paypalService = app(PayPalService::class);
            $result = $paypalService->captureOrder($token);

            if (!$result['success']) {
                DB::rollBack();
                return redirect()->route('checkout.payment')->with('error', 'Le paiement PayPal a échoué: ' . $result['error']);
            }

            // Get checkout data from session
            $shippingAddress = session('checkout.shipping_address');
            $shippingRateId = session('checkout.shipping_rate_id');
            $cartWeight = session('checkout.cart_weight');

            if (!$shippingAddress || !$shippingRateId) {
                DB::rollBack();
                return redirect()->route('checkout.shipping')->with('error', 'Données de livraison manquantes');
            }

            // Get cart
            $cartService = app(CartService::class);
            $cart = $cartService->getCart();

            if (!$cart || $cart->items->isEmpty()) {
                DB::rollBack();
                return redirect()->route('cart')->with('error', 'Votre panier est vide');
            }

            // Calculate totals
            $taxService = app(\App\Services\TaxService::class);
            $cartTotal = 0;
            foreach ($cart->items as $item) {
                $priceTTC = $taxService->calculatePriceWithTax($item->product->price);
                $cartTotal += $priceTTC * $item->quantity;
            }

            $shippingRate = \App\Models\ShippingRate::findOrFail($shippingRateId);

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total' => $cartTotal,
                'shipping_cost' => $shippingRate->price,
                'shipping_rate_id' => $shippingRate->id,
                'shipping_address' => $shippingAddress,
                'total_weight' => $cartWeight,
                'status' => 'paid',
                'payment_method' => 'paypal',
                'payment_id' => $token,
            ]);

            // Create order items
            foreach ($cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart and session
            $cartService->clearCart();
            session()->forget(['checkout.shipping_rate_id', 'checkout.shipping_address', 'checkout.cart_weight']);

            DB::commit();

            // Store order ID for confirmation page
            session(['last_order_id' => $order->id]);

            return redirect()->route('checkout.confirmation')->with('success', 'Paiement PayPal réussi !');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.payment')->with('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request)
    {
        return redirect()->route('checkout.payment')->with('info', 'Paiement PayPal annulé. Vous pouvez réessayer quand vous êtes prêt.');
    }
}
