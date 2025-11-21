<?php

namespace App\Livewire;

use Livewire\Component;

class OrderComponent extends Component
{
    public function render()
    {
        return view('livewire.order-component', [
            'orders' => \App\Models\Order::where('user_id', auth()->id())->get(),
        ]);
    }
}
