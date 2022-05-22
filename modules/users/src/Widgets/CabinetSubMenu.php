<?php

namespace WezomCms\Users\Widgets;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class CabinetSubMenu extends AbstractWidget
{
    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        return ['menu' => app('cabinetSubMenu')];
    }
}
