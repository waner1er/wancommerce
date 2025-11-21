<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;
use Livewire\Attributes\On;

class CartBadge extends Component
{
    public $itemCount = 0;

    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function mount()
    {
        $this->updateCartCount();
    }

    #[On('cart-updated')]
    public function updateCartCount()
    {
        $cart = $this->cartService->getCart();
        $this->itemCount = $cart ? $cart->itemCount() : 0;
    }

    public function render()
    {
        return view('livewire.cart-badge');
    }
}
