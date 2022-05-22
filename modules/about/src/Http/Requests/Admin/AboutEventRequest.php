<?php

namespace WezomCms\About\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Http\Requests\ChangeStatus\RequiredIfMessageTrait;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class AboutEventRequest extends FormRequest
{
    use LocalizedRequestTrait;
    use RequiredIfMessageTrait;

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
                'description' => 'required|string|max:30000',
            ],
            [
                'published' => 'required|bool',
                'happened_at' => 'required|date',
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
                'name' => __('cms-about::admin.Name'),
                'description' => __('cms-about::admin.Description'),
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'happened_at' => __('cms-about::admin.Happened at'),
            ]
        );
    }
}
