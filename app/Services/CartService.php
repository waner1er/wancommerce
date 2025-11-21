<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): ?Cart
    {
        if (Auth::check()) {
            $userCart = Cart::with('items.product')->firstOrCreate([
                'user_id' => Auth::id(),
            ]);

            $this->mergeSessionCart($userCart);

            return $userCart;
        }

        $cartId = session('guest_cart_id');

        if ($cartId) {
            $cart = Cart::with('items.product')
                ->where('id', $cartId)
                ->whereNull('user_id')
                ->first();

            if ($cart) {
                return $cart;
            }
        }

        $cart = Cart::create([
            'session_id' => Session::getId(),
        ]);

        session(['guest_cart_id' => $cart->id]);

        return Cart::with('items.product')->find($cart->id);
    }

    protected function mergeSessionCart(Cart $userCart): void
    {
        $guestCartId = session('guest_cart_id');

        if (!$guestCartId) {
            return;
        }

        $sessionCart = Cart::with('items.product')
            ->where('id', $guestCartId)
            ->whereNull('user_id')
            ->first();

        if ($sessionCart && $sessionCart->items->isNotEmpty()) {
            foreach ($sessionCart->items as $sessionItem) {
                $existingItem = $userCart->items()
                    ->where('product_id', $sessionItem->product_id)
                    ->first();

                if ($existingItem) {
                    $existingItem->quantity += $sessionItem->quantity;
                    $existingItem->save();
                } else {
                    $sessionItem->cart_id = $userCart->id;
                    $sessionItem->save();
                }
            }

            $sessionCart->delete();
            session()->forget('guest_cart_id');
        }
    }

    public function addToCart(int $productId, int $quantity = 1): CartItem
    {
        $product = Product::findOrFail($productId);
        $cart = $this->getCart();

        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        return $cartItem;
    }

    public function updateQuantity(int $cartItemId, int $quantity): void
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        if ($quantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }
    }

    public function removeItem(int $cartItemId): void
    {
        CartItem::destroy($cartItemId);
    }

    public function clearCart(): void
    {
        $cart = $this->getCart();
        if ($cart) {
            $cart->items()->delete();
        }
    }

    public function createOrder(): Order
    {
        if (!Auth::check()) {
            throw new \Exception('Vous devez être connecté pour créer une commande.');
        }

        $cart = $this->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            throw new \Exception('Votre panier est vide.');
        }

        // Calculer le total TTC
        $totalTTC = 0;
        foreach ($cart->items as $item) {
            $totalTTC += $item->product->getPriceTTC() * $item->quantity;
        }

        return DB::transaction(function () use ($cart, $totalTTC) {
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total' => $totalTTC,
                'status' => 'pending',
            ]);

            foreach ($cart->items as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->price,
                ]);
            }

            $this->clearCart();

            return $order;
        });
    }
}
