<?php

namespace WezomCms\Favorites\Http\Livewire;

use Livewire\Component;

class HeaderButton extends Component
{
    /**
     * @var string
     */
    protected $view = 'cms-favorites::site.livewire.header-button';

    /**
     * @var string[]
     */
    protected $listeners = [
        'favorableAdded' => '$refresh',
        'favorableRemoved' => '$refresh',
    ];

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view($this->view, [
            'count' => app('favorites')->count(),
        ]);
    }
}
