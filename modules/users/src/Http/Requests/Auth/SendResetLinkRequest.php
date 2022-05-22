<?php

namespace WezomCms\Users\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Users\Models\User;
use WezomCms\Users\Rules\EmailOrPhone;

class SendResetLinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'login' => ['required', 'string', new EmailOrPhone()]
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
            'login' => User::emailOrPhone($this->get('login')) === User::EMAIL
            ? __('cms-users::site.cabinet.E-mail')
            : __('cms-users::site.cabinet.Phone')
        ];
    }
}
