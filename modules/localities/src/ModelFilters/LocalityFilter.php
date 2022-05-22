<?php

namespace WezomCms\Localities\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Localities\Models\City;
use WezomCms\Core\Contracts\Filter\FilterFieldInterface;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Localities\Models\Locality;

/**
 * @mixin Locality
 */
class LocalityFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::makeName(),
            FilterField::make()
                ->type(FilterFieldInterface::TYPE_SELECT)
                ->name('city_id')
                ->label(__('cms-localities::admin.City'))
                ->class('js-select2')
                ->options(City::getForSelect(false)),
            FilterField::published(),
        ];
    }

    /**
     * @var  int $published
     */
    public function published($published)
    {
        $this->where('published', $published);
    }

    /**
     * @var  string $name
     */
    public function name($name)
    {
        $this->related('translations', 'name', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
    }

    public function city($id)
    {
        $this->where('city_id', $id);
    }
}
