<?php

namespace WezomCms\Users\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:filter|exists:users,email',
            'password' => [
                'required',
                'string',
                'min:' . config('cms.users.users.password_min_length'),
                'max:' . config('cms.users.users.password_max_length'),
            ],
            'password_confirmation' => ['required', 'string', 'same:password'],
            'token' => 'required',
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
            'email' => __('cms-users::site.cabinet.E-mail'),
            'password' => __('cms-users::site.cabinet.Password'),
            'password_confirmation' => __('cms-users::site.cabinet.Repeat password'),
            'token' => __('cms-users::site.auth.Token'),
        ];
    }
}
