<?php

namespace WezomCms\Users\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Http\Request;
use WezomCms\Core\Contracts\Filter\FilterFieldInterface;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Users\Models\User;
use WezomCms\Orders\Models\UserAddress;

/**
 * @mixin UserAddress
 */
class UserAddressFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * @var array
     */
    protected $users = [];

    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::make()
                ->type(FilterFieldInterface::TYPE_SELECT)
                ->options($this->users)
                ->name('user_id')
                ->label(__('cms-users::admin.User'))
                ->class('js-ajax-select2')
                ->attributes(['data-url' => route('admin.users.search')]),
            FilterField::make()
                ->name('street')
                ->label(__('cms-users::admin.Street')),
            FilterField::make()
                ->name('house')
                ->label(__('cms-users::admin.House'))
                ->size(2),
        ];
    }

    /**
     * @param Request $request
     */
    public function restoreSelectedOptions(Request $request)
    {
        if ($userId = $request->get('user_id')) {
            $user = User::find($userId);
            if ($user) {
                $this->users = [$user->id => $user->full_name];
            }
        }
    }

    public function user($id)
    {
        $this->where('user_id', $id);
    }

    public function city($id)
    {
        $this->where('city_id', $id);
    }

    public function street($street)
    {
        $this->whereLike('street', $street);
    }

    public function house($house)
    {
        $this->where('house', $house);
    }
}
