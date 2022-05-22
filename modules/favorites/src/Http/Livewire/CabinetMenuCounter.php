<?php

namespace WezomCms\Favorites\Http\Livewire;

use Livewire\Component;

class CabinetMenuCounter extends Component
{
    /**
     * @var string[]
     */
    protected $listeners = [
        'favorableAdded' => '$refresh',
        'favorableRemoved' => '$refresh',
    ];

    /**
     * @return string
     */
    public function render()
    {
        $count = app('favorites')->count();

        return $count ? "<span>{$count}</span>" : '<span>0</span>';
    }
}
