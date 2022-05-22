<?php

namespace WezomCms\Users\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Rules\Phone;
use WezomCms\Users\Models\User;
use WezomCms\Users\Rules\EmailOrPhone;

class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string', 'max:255'],
            'login' => ['required', 'string', new EmailOrPhone(true)],
            'password' => [
                'required',
                'string',
                'min:' . config('cms.users.users.password_min_length'),
                'max:255',
                'confirmed'
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
            'username' => __('cms-users::site.cabinet.Username'),
            'login' => __('cms-users::site.cabinet.Login'),
            'password' => __('cms-users::site.cabinet.Password'),
            'agree' => __('cms-users::site.auth.Agree'),
        ];
    }
}
