<?php

namespace WezomCms\Users\Http\Livewire;

use Livewire\Component;

/**
 * Class Modal
 * @package WezomCms\Users\Http\Livewire
 */
class AuthModal extends Component
{
    /**
     * @var array
     */
    public $data;

    /**
     * @var string|null
     */
    public $phone;

    /**
     * @var string
     */
    public $redirect;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function render()
    {
        return view('cms-users::site.livewire.auth-modal');
    }
}
