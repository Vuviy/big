<?php

namespace WezomCms\Ui\Http\Livewire;

use Livewire\Component;

class ExampleModal extends Component
{
    /**
     * @var string
     */
    public $message;

    /**
     * @param  string  $message
     */
    public function mount(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return view('cms-ui::livewire.example-modal');
    }
}
