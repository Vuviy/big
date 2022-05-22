<?php

namespace WezomCms\Users\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Users\Models\User;

/**
 * Class UserFilter
 * @package WezomCms\Users\ModelFilters
 * @mixin User
 */
class UserFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        $email = FilterField::make()
            ->name('email')
            ->label(__('cms-users::admin.E-mail'))
            ->size(2);

        return [
            FilterField::makeName(['label' => __('cms-users::admin.First name & Second name')]),
            FilterField::make()->name('phone')->label(__('cms-users::admin.Phone'))->size(2),
            $email,
            FilterField::active(),
        ];
    }

    public function name($name)
    {
        $this->where(function ($query) use ($name) {
            $query->where('name', 'LIKE', '%' . Helpers::escapeLike($name) . '%')
                ->orWHere('surname', 'LIKE', '%' . Helpers::escapeLike($name) . '%')
                ->orWHere(
                    \DB::raw('CONCAT_WS(" ", `name`, `surname`)'),
                    'LIKE',
                    '%' . Helpers::escapeLike($name) . '%'
                );
        });
    }

    public function phone($phone)
    {
        $this->whereRaw(
            'REPLACE(REPLACE(REPLACE(REPLACE(phone, "+", ""), "(", ""), ")", ""), " ", "") LIKE ?',
            '%' . preg_replace('/[^\d]/', '', $phone) . '%'
        );
    }

    public function email($email)
    {
        $this->whereLike('email', $email);
    }

    public function active($active)
    {
        $this->where('active', $active);
    }
}
