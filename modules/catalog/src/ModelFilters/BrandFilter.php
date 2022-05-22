<?php

namespace WezomCms\Catalog\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Catalog\Models\Brand;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;

/**
 * Class BrandFilter
 * @package WezomCms\Catalog\ModelFilters
 * @mixin Brand
 */
class BrandFilter extends ModelFilter implements FilterListFieldsInterface
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

    public function name($name)
    {
        $this->related('translations', 'name', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
    }

    public function published($published)
    {
        $this->where('published', $published);
    }
}
