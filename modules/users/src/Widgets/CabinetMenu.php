<?php

namespace WezomCms\Users\Widgets;

use Lavary\Menu\Builder;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class CabinetMenu extends AbstractWidget
{
    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        if (!auth()->check()) {
            return null;
        }

        /** @var Builder $menu */
        $menu = app('cabinetMenu');

        $menu->sortBy(function ($elements) {
            // Sort elements by position meta data
            usort($elements, function ($a, $b) {
                return ($a->data('position') ?? 0) <=> ($b->data('position') ?? 0);
            });

            return $elements;
        });

        return compact('menu');
    }
}
