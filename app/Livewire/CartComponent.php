<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class CartComponent extends Component
{
    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function updateQuantity($cartItemId, $quantity)
    {
        $this->cartService->updateQuantity($cartItemId, $quantity);
        $this->dispatch('cart-updated');
    }

    public function removeItem($cartItemId)
    {
        $this->cartService->removeItem($cartItemId);
        $this->dispatch('cart-updated');
    }

    public function proceedToCheckout()
    {
        // Vérifier l'authentification
        if (!Auth::check()) {
            session()->flash('error', 'Vous devez être connecté pour valider votre commande.');
            return redirect()->route('login');
        }

        $cart = $this->cartService->getCart();

        if (!$cart || $cart->items->isEmpty()) {
            session()->flash('error', 'Votre panier est vide.');
            return;
        }

        // Rediriger vers l'étape de livraison
        return $this->redirect('/checkout/shipping', navigate: true);
    }

    public function render()
    {
        $cart = $this->cartService->getCart();
        $items = $cart ? $cart->items()->with('product')->get() : collect();

        $totalTTC = 0;
        if ($items->isNotEmpty()) {
            foreach ($items as $item) {
                $totalTTC += $item->product->getPriceTTC() * $item->quantity;
            }
        }

        $data = [
            'cart' => $cart,
            'items' => $items,
            'total' => $totalTTC,
            'itemCount' => $cart ? $cart->itemCount() : 0,
        ];

        if (Auth::check()) {
            return view('livewire.cart-component', $data)->layout('components.layouts.app', ['title' => 'Mon Panier']);
        }

        return view('livewire.cart-component', $data)->layout('components.app-layout');
    }
}
