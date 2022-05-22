<?php

namespace WezomCms\Orders\Http\Livewire;

use Livewire\Component;
use WezomCms\Orders\Models\Order;

class CabinetMenuCounter extends Component
{
    /**
     * @return string
     */
    public function render()
    {
        $count = Order::where('user_id', auth()->id())->count();

        return "<span>{$count}</span>";
    }
}
