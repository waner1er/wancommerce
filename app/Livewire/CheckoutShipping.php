<?php

namespace App\Livewire;

use App\Services\CartService;
use App\Services\ShippingService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutShipping extends Component
{
    public $cart;
    public $cartWeight;
    public $availableRates;
    public $selectedRateId;

    // Address fields
    public $first_name = '';
    public $last_name = '';
    public $address = '';
    public $address_complement = '';
    public $city = '';
    public $postal_code = '';
    public $country = 'France';
    public $phone = '';

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'address_complement' => 'nullable|string|max:255',
        'city' => 'required|string|max:255',
        'postal_code' => 'required|string|max:10',
        'country' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'selectedRateId' => 'required|exists:shipping_rates,id',
    ];

    public function mount(CartService $cartService, ShippingService $shippingService)
    {
        if (!Auth::check()) {
            return $this->redirect('/login', navigate: true);
        }

        $this->cart = $cartService->getCart();

        if (!$this->cart || $this->cart->items->isEmpty()) {
            session()->flash('error', 'Votre panier est vide.');
            return $this->redirect('/cart', navigate: true);
        }

        // Calculate weight
        $this->cartWeight = $shippingService->calculateCartWeight($this->cart);

        // Get available shipping rates
        $this->availableRates = $shippingService->getAvailableRates($this->cartWeight);

        if ($this->availableRates->isEmpty()) {
            session()->flash('error', 'Aucun mode de livraison disponible pour ce poids (' . $this->cartWeight . ' kg).');
        }

        // Pre-fill with user data
        $user = Auth::user();
        $this->first_name = $user->first_name ?? '';
        $this->last_name = $user->last_name ?? '';
        $this->phone = $user->phone ?? '';
        $this->address = $user->address ?? '';
        $this->city = $user->city ?? '';
        $this->postal_code = $user->postal_code ?? '';
        $this->country = $user->country ?? 'France';
    }

    public function submitShipping()
    {
        $this->validate();

        // Store shipping info in session
        session([
            'checkout.shipping_rate_id' => $this->selectedRateId,
            'checkout.shipping_address' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'address' => $this->address,
                'address_complement' => $this->address_complement,
                'city' => $this->city,
                'postal_code' => $this->postal_code,
                'country' => $this->country,
                'phone' => $this->phone,
            ],
            'checkout.cart_weight' => $this->cartWeight,
        ]);

        // Redirect to payment page
        return $this->redirect('/checkout/payment', navigate: true);
    }

    public function render()
    {
        return view('livewire.checkout-shipping')->layout('components.app-layout');
    }
}
