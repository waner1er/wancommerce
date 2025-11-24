<?php

namespace App\Livewire;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CheckoutConfirmation extends Component
{
    public $order;

    public function mount()
    {
        if (!Auth::check()) {
            return $this->redirect('/login', navigate: true);
        }

        $orderId = session('last_order_id');

        if (!$orderId) {
            return $this->redirect('/', navigate: true);
        }

        $this->order = Order::with(['items.product', 'shippingRate'])
            ->where('user_id', Auth::id())
            ->findOrFail($orderId);

        // Clear the session
        session()->forget('last_order_id');
    }

    public function render()
    {
        return view('livewire.checkout-confirmation')->layout('components.app-layout');
    }
}
