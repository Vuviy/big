<?php

namespace WezomCms\Localities\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Localities\Models\City;
use WezomCms\Core\Contracts\Filter\FilterFieldInterface;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;

/**
 * @mixin City
 */
class CityFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::makeName(),
            FilterField::published(),
        ];
    }

    /**
     * @var  int  $published
     */
    public function published($published)
    {
        $this->where('published', $published);
    }

    /**
     * @var  string  $name
     */
    public function name($name)
    {
        $this->related('translations', 'name', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
    }
}
