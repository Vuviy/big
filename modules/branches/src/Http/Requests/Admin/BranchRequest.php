<?php

namespace WezomCms\Branches\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Http\Requests\ChangeStatus\RequiredIfMessageTrait;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class BranchRequest extends FormRequest
{
    use LocalizedRequestTrait;
    use RequiredIfMessageTrait {
        RequiredIfMessageTrait::messages as traitMessages;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->localizeRules(
            [
                'name' => 'required|string|max:255',
                'address' => 'required|string|max:255',
                'schedule' => 'required|string|max:255',
            ],
            [
                'published' => 'required',
                'phones.*' => 'required|string|max:255|distinct|regex:/^\+?[\d\s\(\)-]+$/',
                'email' => 'nullable|email|max:255',
            ]
        );
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return $this->localizeAttributes(
            [
                'name' => __('cms-branches::admin.Name'),
                'address' => __('cms-branches::admin.Address'),
                'schedule' => __('cms-branches::admin.Schedule'),
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'phones.*' => __('cms-branches::admin.Phones'),
                'email' => __('cms-branches::admin.E-mail'),
            ]
        );
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        $messages = $this->traitMessages();

        $messages['phones.*.regex'] = __('cms-core::admin.layout.Invalid phone value');

        return $messages;
    }
}
