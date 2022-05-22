<?php

namespace WezomCms\Slider\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Slider\Models\Slide;

/**
 * Class SlideFilter
 * @package WezomCms\Slider\ModelFilters
 * @mixin Slide
 */
class SlideFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::makeName()->size(2),
            FilterField::published(),
            FilterField::locale(),
        ];
    }

    public function published($published)
    {
        $this->related('translations', 'published', $published);
    }

    public function name($name)
    {
        $this->related('translations', 'name', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
    }

    public function locale($locale)
    {
        $this->related('translations', 'locale', $locale);
    }
}
