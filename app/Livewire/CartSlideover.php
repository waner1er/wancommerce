<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\On;

class CartSlideover extends Component
{
    public $isOpen = false;
    public $items = [];
    public $total = 0;
    public $itemCount = 0;

    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function mount()
    {
        $this->refreshCart();
    }

    #[On('open-cart')]
    public function openCart()
    {
        $this->isOpen = true;
        $this->refreshCart();
    }

    public function closeCart()
    {
        $this->isOpen = false;
    }

    #[On('cart-updated')]
    public function refreshCart()
    {
        $cart = $this->cartService->getCart();
        $this->items = $cart ? $cart->items()->with('product')->get() : collect();

        $totalTTC = 0;
        if ($this->items->isNotEmpty()) {
            foreach ($this->items as $item) {
                $totalTTC += $item->product->getPriceTTC() * $item->quantity;
            }
        }

        $this->total = $totalTTC;
        $this->itemCount = $cart ? $cart->itemCount() : 0;
    }

    public function removeItem($itemId)
    {
        $this->cartService->removeItem($itemId);
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function updateQuantity($itemId, $quantity)
    {
        if ($quantity < 1) {
            return;
        }

        $this->cartService->updateQuantity($itemId, $quantity);
        $this->refreshCart();
        $this->dispatch('cart-updated');
    }

    public function render()
    {
        return view('livewire.cart-slideover');
    }
}
