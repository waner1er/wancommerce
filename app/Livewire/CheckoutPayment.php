<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingRate;
use App\Services\CartService;
use App\Services\TaxService;
use App\Services\PayPalService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\On;

class CheckoutPayment extends Component
{
    public $cart;
    public $shippingAddress;
    public $shippingRate;
    public $cartWeight;
    public $paymentMethod = 'card'; // card or paypal

    public function mount(CartService $cartService)
    {
        if (!Auth::check()) {
            return $this->redirect('/login', navigate: true);
        }

        // Check if shipping info exists in session
        if (!session()->has('checkout.shipping_rate_id') || !session()->has('checkout.shipping_address')) {
            session()->flash('error', 'Veuillez d\'abord renseigner votre adresse de livraison.');
            return $this->redirect('/checkout/shipping', navigate: true);
        }

        $this->cart = $cartService->getCart();

        if (!$this->cart || $this->cart->items->isEmpty()) {
            session()->flash('error', 'Votre panier est vide.');
            return $this->redirect('/cart', navigate: true);
        }

        $this->shippingAddress = session('checkout.shipping_address');
        $this->shippingRate = ShippingRate::findOrFail(session('checkout.shipping_rate_id'));
        $this->cartWeight = session('checkout.cart_weight');
    }

    public function getCartTotalProperty()
    {
        $taxService = app(TaxService::class);
        $total = 0;

        foreach ($this->cart->items as $item) {
            $priceTTC = $taxService->calculatePriceWithTax($item->product->price);
            $total += $priceTTC * $item->quantity;
        }

        return $total;
    }

    public function getShippingCostTTCProperty()
    {
        $taxService = app(TaxService::class);
        return $taxService->calculatePriceWithTax($this->shippingRate->price);
    }

    public function getTotalWithShippingProperty()
    {
        return $this->cartTotal + $this->shippingCostTTC;
    }

    /**
     * Redirect to PayPal for payment
     */
    public function redirectToPayPal()
    {
        try {
            $paypalService = app(PayPalService::class);

            // Prepare items for PayPal
            $items = [];
            foreach ($this->cart->items as $item) {
                $items[] = [
                    'name' => $item->product->name,
                    'description' => substr($item->product->description ?? '', 0, 127),
                    'price' => $item->product->getPriceTTC(),
                    'quantity' => $item->quantity,
                ];
            }

            // Add shipping as item
            $items[] = [
                'name' => 'Frais de port - ' . $this->shippingRate->name,
                'description' => $this->shippingRate->carrier,
                'price' => $this->shippingCostTTC,
                'quantity' => 1,
            ];

            $result = $paypalService->createOrder($this->totalWithShipping, 'EUR', $items);

            if ($result['success']) {
                // Get approval URL from PayPal response
                $approvalUrl = null;
                foreach ($result['data']->links as $link) {
                    if ($link->rel === 'approve') {
                        $approvalUrl = $link->href;
                        break;
                    }
                }

                if ($approvalUrl) {
                    return redirect()->away($approvalUrl);
                } else {
                    session()->flash('error', 'Impossible de récupérer l\'URL PayPal');
                }
            } else {
                session()->flash('error', 'Erreur PayPal: ' . $result['error']);
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Une erreur est survenue: ' . $e->getMessage());
        }
    }

    /**
     * Create PayPal order (called from frontend)
     */
    public function createPayPalOrder()
    {
        try {
            $paypalService = app(PayPalService::class);

            // Prepare items for PayPal
            $items = [];
            foreach ($this->cart->items as $item) {
                $items[] = [
                    'name' => $item->product->name,
                    'description' => substr($item->product->description ?? '', 0, 127),
                    'price' => $item->product->getPriceTTC(),
                    'quantity' => $item->quantity,
                ];
            }

            // Add shipping as item
            $items[] = [
                'name' => 'Frais de port - ' . $this->shippingRate->name,
                'description' => $this->shippingRate->carrier,
                'price' => $this->shippingCostTTC,
                'quantity' => 1,
            ];

            $result = $paypalService->createOrder($this->totalWithShipping, 'EUR', $items);

            if ($result['success']) {
                return [
                    'success' => true,
                    'order_id' => $result['order_id'],
                ];
            } else {
                return [
                    'success' => false,
                    'error' => $result['error'],
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Capture PayPal payment and create order
     */
    #[On('paypal-payment-approved')]
    public function capturePayPalPayment($paypalOrderId)
    {
        try {
            DB::beginTransaction();

            $paypalService = app(PayPalService::class);
            $result = $paypalService->captureOrder($paypalOrderId);

            if (!$result['success']) {
                DB::rollBack();
                $this->dispatch('paypal-payment-error', error: 'Le paiement PayPal a échoué: ' . $result['error']);
                return;
            }

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total' => $this->cartTotal,
                'shipping_cost' => $this->shippingRate->price,
                'shipping_rate_id' => $this->shippingRate->id,
                'shipping_address' => $this->shippingAddress,
                'total_weight' => $this->cartWeight,
                'status' => 'paid',
            ]);

            // Create order items
            foreach ($this->cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Clear cart
            $cartService = app(CartService::class);
            $cartService->clearCart();

            // Clear checkout session
            session()->forget(['checkout.shipping_rate_id', 'checkout.shipping_address', 'checkout.cart_weight']);

            DB::commit();

            // Store order ID for confirmation page
            session(['last_order_id' => $order->id]);

            // Redirect to confirmation
            $this->dispatch('paypal-payment-success');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('paypal-payment-error', error: 'Erreur: ' . $e->getMessage());
        }
    }

    public function processPayment()
    {
        // This is for card payments (demo mode)
        try {
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total' => $this->cartTotal,
                'shipping_cost' => $this->shippingRate->price,
                'shipping_rate_id' => $this->shippingRate->id,
                'shipping_address' => $this->shippingAddress,
                'total_weight' => $this->cartWeight,
                'status' => 'pending',
            ]);

            // Create order items
            foreach ($this->cart->items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                // Update stock
                $item->product->decrement('stock', $item->quantity);
            }

            // Simulate successful payment
            $order->update(['status' => 'paid']);

            // Clear cart
            $cartService = app(CartService::class);
            $cartService->clearCart();

            // Clear checkout session
            session()->forget(['checkout.shipping_rate_id', 'checkout.shipping_address', 'checkout.cart_weight']);

            DB::commit();

            // Store order ID for confirmation page
            session(['last_order_id' => $order->id]);

            // Redirect to confirmation
            return $this->redirect('/checkout/confirmation', navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Une erreur est survenue lors du paiement: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.checkout-payment')->layout('components.app-layout');
    }
}
