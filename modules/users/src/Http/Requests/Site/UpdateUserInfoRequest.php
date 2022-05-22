<?php

namespace WezomCms\Users\Http\Requests\Site;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Rules\PhoneOrPhoneMask;

class UpdateUserInfoRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'phone' => ['nullable', new PhoneOrPhoneMask(), 'unique:users,phone,' . Auth::user()->id],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => __('cms-users::site.cabinet.Username'),
            'surname' => __('cms-users::site.cabinet.Surname'),
            'email' => __('cms-users::site.cabinet.E-mail'),
            'phone' => __('cms-users::site.cabinet.Phone'),
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => __('cms-users::site.auth.User with provided email already exists'),
            'phone.unique' => __('cms-users::site.auth.User with provided phone already exists'),
        ];
    }
}
