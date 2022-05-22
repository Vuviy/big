<?php

namespace WezomCms\Callbacks\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use WezomCms\Callbacks\Models\Callback;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;

/**
 * Class CallbackFilter
 * @package WezomCms\Callbacks\ModelFilters
 * @mixin Callback
 */
class CallbackFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::makeName()->label(__('cms-callbacks::admin.Name'))->size(2),
            FilterField::make()->name('phone')->label(__('cms-callbacks::admin.Phone'))->size(2),
            FilterField::read(),
            FilterField::make()->name('created_at')->label(__('cms-callbacks::admin.Date'))
                ->type(FilterField::TYPE_DATE_RANGE),
        ];
    }

    public function name($name)
    {
        $this->whereLike('name', $name);
    }

    public function phone($phone)
    {
        $this->whereRaw(
            'REPLACE(REPLACE(REPLACE(REPLACE(phone, "+", ""), "(", ""), ")", ""), " ", "") LIKE ?',
            '%' . preg_replace('/[^\d]/', '', $phone) . '%'
        );
    }

    public function read($read)
    {
        $this->where('read', $read);
    }

    public function createdAtFrom($date)
    {
        $this->where('created_at', '>=', Carbon::parse($date));
    }

    public function createdAtTo($date)
    {
        $this->where('created_at', '<=', Carbon::parse($date)->endOfDay());
    }
}
