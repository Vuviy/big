<?php

namespace WezomCms\MediaBlocks\Models;

use EloquentFilter\ModelFilter;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;

/**
 * Class MediaBlockFilter
 * @package WezomCms\MediaBlocks\Models
 * @mixin MediaBlock
 */
class MediaBlockFilter extends ModelFilter implements FilterListFieldsInterface
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
        ];
    }

    public function published($published)
    {
        $this->where('published', $published);
    }

    public function name($name)
    {
        $this->related('translations', 'name', 'LIKE', '%'.$name.'%');
    }
}
