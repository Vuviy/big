<?php

namespace WezomCms\Branches\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Branches\Models\Branch;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;

/**
 * Class BranchFilter
 * @package WezomCms\Branches\ModelFilters
 * @mixin Branch
 */
class BranchFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::makeName(),
            new FilterField(['name' => 'address', 'label' => __('cms-branches::admin.Address'), 'colSize' => 2]),
            FilterField::published(),
            FilterField::locale(),
        ];
    }

    public function name($name)
    {
        $this->related('translations', 'name', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
    }

    public function email($email)
    {
        $this->whereLike('email', $email);
    }

    public function address($name)
    {
        $this->related('translations', 'address', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
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
