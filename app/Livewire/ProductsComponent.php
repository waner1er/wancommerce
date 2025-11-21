<?php

namespace App\Livewire;

use App\Models\Category;
use App\Services\CartService;
use Livewire\Component;

class ProductsComponent extends Component
{
    public ?int $categoryId = null;

    protected $cartService;

    public function boot(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function addToCart($productId)
    {
        $this->cartService->addToCart($productId, 1);
        $this->dispatch('cart-updated');
        session()->flash('message', 'Produit ajouté au panier !');
    }

    public function render()
    {
        $query = Category::with('products');

        if ($this->categoryId) {
            $query->where('id', $this->categoryId);
        }

        return view('livewire.products-component', [
            'categories' => $query->get(),
        ]);
    }
}
