<?php

namespace WezomCms\Users\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use WezomCms\Users\Models\User;

class VerifyPhoneRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => [
                'required',
                'int',
                'digits:' . User::TEMPORARY_CODE_LENGTH,
                Rule::exists('users', 'temporary_code')->where('id', \Auth::user()->getKey())
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
            'code' => __('cms-users::site.auth.Verification code'),
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
            'code.exists' => __('cms-users::site.auth.The code entered is incorrect'),
        ];
    }
}
