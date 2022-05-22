<?php

namespace WezomCms\Ui\View\Components;

use Illuminate\View\Component;

class PhoneInput extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string|null
     */
    public $label;

    /**
     * @var string|null
     */
    public $value;

    /**
     * @var string|null
     */
    public $placeholder;

    /**
     * Create a new component instance.
     *
     * @param  string  $name
     * @param  string|null  $label
     * @param  string|null  $value
     */
    public function __construct(string $name = 'phone', ?string $label = null, ?string $value = null, ?string $placeholder = null)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('cms-ui::components.phone-input');
    }
}
