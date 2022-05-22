<?php

namespace WezomCms\Contacts\Http\Livewire;

class PopupForm extends Form
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view('cms-contacts::site.livewire.popup-form');
    }
}
