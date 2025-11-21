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

    public function createOrder()
    {
        // Vérifier l'authentification
        if (!Auth::check()) {
            session()->flash('error', 'Vous devez être connecté pour valider votre commande.');
            return redirect()->route('login');
        }

        try {
            $order = $this->cartService->createOrder();
            session()->flash('success', 'Commande créée avec succès ! Numéro: ' . $order->order_number);
            $this->dispatch('cart-updated');

            // Utiliser redirect après la création de la commande
            return $this->redirect(route('orders'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Erreur lors de la création de la commande: ' . $e->getMessage());
            \Log::error('Erreur création commande', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
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
