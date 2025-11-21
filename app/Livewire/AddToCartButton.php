<?php

namespace App\Livewire;

use App\Services\CartService;
use Livewire\Component;

class AddToCartButton extends Component
{
    public int $productId;

    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart()
    {
        $this->cartService->addToCart($this->productId, 1);
        $this->dispatch('cart-updated');
        session()->flash('cart-message', 'Produit ajouté au panier !');
    }

    public function render()
    {
        return view('livewire.add-to-cart-button');
    }
}
