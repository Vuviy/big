<?php

namespace WezomCms\Faq\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class FaqGroupRequest extends FormRequest
{
    use LocalizedRequestTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->localizeRules(
            ['name' => 'required|string|max:255'],
            ['published' => 'required']
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
            ['name' => __('cms-faq::admin.Name')],
            ['published' => __('cms-core::admin.layout.Published')]
        );
    }
}
