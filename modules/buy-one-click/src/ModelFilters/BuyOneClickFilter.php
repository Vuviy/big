<?php

namespace WezomCms\BuyOneClick\ModelFilters;

use Carbon\Carbon;
use EloquentFilter\ModelFilter;
use WezomCms\BuyOneClick\Models\BuyOneClick;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;

/**
 * Class BuyOneClickFilter
 * @package WezomCms\BuyOneClick\ModelFilters
 * @mixin BuyOneClick
 */
class BuyOneClickFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            //FilterField::makeName()->label(__('cms-buy-one-click::admin.Name'))->size(2),
            FilterField::make()->name('phone')->label(__('cms-buy-one-click::admin.Phone'))->size(2),
            FilterField::make()->name('product_name')->label(__('cms-buy-one-click::admin.Product'))->size(2),
            FilterField::read(),
            FilterField::make()->name('created_at')->label(__('cms-buy-one-click::admin.Date'))
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

    public function productName($name)
    {
        $this->related('product', function ($query) use ($name) {
            $query->withTrashed()->whereTranslationLike('name', '%' . Helpers::escapeLike($name) . '%');
        });
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
