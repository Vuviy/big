<?php

namespace WezomCms\Menu\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Menu\Models\Menu;

/**
 * Class MenuFilter
 * @package WezomCms\Menu\ModelFilters
 * @mixin Menu
 */
class MenuFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        $groups = array_map(function ($el) {
            return __($el['name']);
        }, config('cms.menu.menu.groups'));

        $groupField = FilterField::make()
            ->name('group')
            ->label(__('cms-menu::admin.Group'))
            ->type(FilterField::TYPE_SELECT)
            ->size(2)
            ->options($groups);

        return [
            FilterField::makeName()->size(4),
            $groupField,
            FilterField::published(),
            FilterField::locale(),
        ];
    }

    public function name($name)
    {
        $this->related('translations', 'name', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
    }

    public function group($group)
    {
        $this->where('group', $group);
    }

    public function published($published)
    {
        $this->related('translations', 'published', $published);
    }

    public function locale($locale)
    {
        $this->related('translations', 'locale', $locale);
    }
}
