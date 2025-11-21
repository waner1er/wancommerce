<?php

namespace App\Livewire;

use App\Models\Product;
use App\Services\CartService;
use Livewire\Component;

class ProductDetail extends Component
{
    public $product;
    public $quantity = 1;

    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function mount($sku)
    {
        $this->product = Product::where('sku', $sku)
            ->with(['category.parent.parent'])
            ->firstOrFail();
    }

    public function incrementQuantity()
    {
        if ($this->quantity < $this->product->stock) {
            $this->quantity++;
        }
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        if ($this->quantity > $this->product->stock) {
            session()->flash('error', 'Stock insuffisant');
            return;
        }

        $this->cartService->addToCart($this->product->id, $this->quantity);
        $this->dispatch('cart-updated');
        $this->dispatch('open-cart');

        session()->flash('message', 'Produit ajouté au panier');
    }

    public function render()
    {
        return view('livewire.product-detail')
            ->layout('components.app-layout', ['title' => $this->product->name]);
    }
}
