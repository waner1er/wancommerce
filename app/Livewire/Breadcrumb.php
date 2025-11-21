<?php

namespace App\Livewire;

use Livewire\Component;

class Breadcrumb extends Component
{
    public $items = [];

    public function mount($items = [])
    {
        $this->items = $items;
    }

    public function render()
    {
        return view('livewire.breadcrumb');
    }
}
