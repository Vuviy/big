<?php

namespace WezomCms\Newsletter\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Support\Carbon;
use WezomCms\Core\Contracts\Filter\FilterFieldInterface;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Newsletter\Models\Subscriber;

/**
 * Class SubscriberFilter
 * @package WezomCms\Newsletter\ModelFilters
 * @mixin Subscriber
 */
class SubscriberFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with filter fields.
     * @return iterable|FilterFieldInterface[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::make()->name('email')->label(__('cms-newsletter::admin.E-mail')),
            FilterField::active(),
            FilterField::make()->name('created_at')->label(__('cms-newsletter::admin.Created at'))
                ->type(FilterField::TYPE_DATE_RANGE),
        ];
    }

    public function email($email)
    {
        $this->whereLike('email', $email);
    }

    public function active($active)
    {
        $this->where('active', $active);
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
