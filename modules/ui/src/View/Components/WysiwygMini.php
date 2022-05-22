<?php

namespace WezomCms\Ui\View\Components;

use Illuminate\View\Component;

class WysiwygMini extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('cms-ui::components.wysiwyg-mini');
    }
}
