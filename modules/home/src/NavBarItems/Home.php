<?php

namespace WezomCms\Home\NavBarItems;

use WezomCms\Core\Foundation\NavBar\AbstractNavBarItem;

class Home extends AbstractNavBarItem
{
    protected $position = 1;

    /**
     * @return mixed
     */
    protected function render()
    {
        return view('cms-home::admin.home');
    }
}
