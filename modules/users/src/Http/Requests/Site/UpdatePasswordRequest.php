<?php

namespace WezomCms\Users\Http\Requests\Site;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $passwordMinLength = config('cms.users.users.password_min_length');

        return [
            'old_password' => 'required|string|min:' . $passwordMinLength . '|max:255',
            'password' => 'required|string|min:' . $passwordMinLength . '|max:255|different:old_password|confirmed',
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
            'old_password' => __('cms-users::site.cabinet.Old password'),
            'password' => __('cms-users::site.cabinet.New password'),
        ];
    }

    public function messages()
    {
        return [
            'password.different' => __('cms-users::site.cabinet.New password must be different from the old one')
        ];
    }
}
