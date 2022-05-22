<?php

namespace WezomCms\OurTeam\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\OurTeam\Models\Employee;

/**
 * Class EmployeeFilter
 * @package WezomCms\OurTeam\ModelFilters
 * @mixin Employee
 */
class EmployeeFilter extends ModelFilter implements FilterListFieldsInterface
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
        $this->related('translations', 'name', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
    }
}
