<?php

namespace WezomCms\Users\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserAddressRequest extends FormRequest
{
    public function rules() : array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'city' => 'required',
            'street' => 'required|string|max:50',
            'house' => 'required|string|max:10',
            'room' => 'nullable|int|min:0',
            'primary' => 'required|bool',
        ];
    }

    public function attributes() : array
    {
        return [
            'user_id' => __('cms-users::admin.Пользователь'),
            'city' => __('cms-users::admin.Город'),
            'street' => __('cms-users::admin.Улица'),
            'house' => __('cms-users::admin.Дом'),
            'room' => __('cms-users::admin.Квартира'),
            'primary' => __('cms-users::admin.Основной адрес'),
        ];
    }
}
