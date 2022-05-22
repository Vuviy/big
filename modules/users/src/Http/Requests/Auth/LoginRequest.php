<?php

namespace WezomCms\Users\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Users\Models\User;
use WezomCms\Users\Rules\EmailOrPhone;

class LoginRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', new EmailOrPhone()],
            'password' => [
                'required',
                'string',
                'min:' . config('cms.users.users.password_min_length'),
                'max:255',
            ],
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
            'login' => __('cms-users::site.cabinet.Login'),
            'password' => __('cms-users::site.cabinet.Password'),
        ];
    }
}
