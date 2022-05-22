<?php

namespace WezomCms\Orders\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Support\Carbon;
use WezomCms\Core\Contracts\Filter\FilterFieldInterface;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Orders\Models\Order;
use WezomCms\Orders\Models\OrderStatus;

/**
 * Class OrderTrashedFilter
 * @package WezomCms\Orders\ModelFilters
 * @mixin Order
 */
class OrderTrashedFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with filter fields.
     * @return iterable|FilterFieldInterface[]
     */
    public function getFields(): iterable
    {
        $status = FilterField::make()
            ->name('status')
            ->label(__('cms-orders::admin.orders.Status'))
            ->size(2)
            ->type(FilterField::TYPE_SELECT)
            ->options(OrderStatus::getForSelect());

        return [
            FilterField::id(),
            FilterField::makeName()->label(__('cms-orders::admin.orders.Name'))->size(2),
            FilterField::make()->name('phone')->label(__('cms-orders::admin.orders.Phone'))->size(2),
            FilterField::make()->name('email')->label(__('cms-orders::admin.orders.E-mail')),
            $status,
            FilterField::published([
                'name' => 'payed',
                'label' => __('cms-orders::admin.orders.Payed'),
                'options' => [
                    1 => __('cms-core::admin.layout.Yes'),
                    0 => __('cms-core::admin.layout.No'),
                ]
            ]),
            FilterField::make()->name('created_at')->label(__('cms-orders::admin.orders.Date'))
                ->type(FilterField::TYPE_DATE_RANGE),
        ];
    }

    public function id($id)
    {
        $this->where('id', $id);
    }

    public function name($name)
    {
        $this->related('client', function ($query) use ($name) {
            $query->whereLike('name', $name)
                ->orWhereLike('patronymic', $name)
                ->orWhereLike('surname', $name);
        });
    }

    public function phone($phone)
    {
        $this->related('client', function ($query) use ($phone) {
            $query->whereRaw(
                'REPLACE(REPLACE(REPLACE(REPLACE(phone, "+", ""), "(", ""), ")", ""), " ", "") LIKE ?',
                '%' . preg_replace('/[^\d]/', '', $phone) . '%'
            );
        });
    }

    public function email($email)
    {
        $this->related('client', function ($query) use ($email) {
            $query->whereLike('email', $email);
        });
    }

    public function status($status)
    {
        $this->where('status_id', $status);
    }

    public function payed($payed)
    {
        $this->where('payed', $payed);
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
