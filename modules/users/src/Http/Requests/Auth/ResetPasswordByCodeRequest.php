<?php

namespace WezomCms\Users\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use WezomCms\Users\Models\User;

class ResetPasswordByCodeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'password' => [
                'required',
                'confirmed',
                'string',
                'min:' . config('cms.users.users.password_min_length'),
                'max:255'
            ],
            'code' => [
                'required',
                'int',
                'digits:' . User::TEMPORARY_CODE_LENGTH,
                Rule::exists('users', 'temporary_code')->where('id', $this->get('id'))
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
            'password' => __('cms-users::site.cabinet.Password'),
            'code' => __('cms-users::site.cabinet.Code'),
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.exists' => __('cms-users::site.cabinet.Invalid code entered'),
        ];
    }
}
