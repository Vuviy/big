<?php

namespace WezomCms\Faq\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class FaqRequest extends FormRequest
{
    use LocalizedRequestTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'published' => 'required',
        ];

        if (config('cms.faq.faq.use_groups')) {
            $rules['faq_group_id'] = 'required|exists:faq_groups,id';
        }

        return $this->localizeRules(
            [
                'question' => 'required|string|max:255',
                'answer' => 'nullable|string|max:16777215',
            ],
            $rules
        );
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        $attributes = [
            'published' => __('cms-core::admin.layout.Published'),
        ];

        if (config('cms.faq.faq.use_groups')) {
            $attributes['faq_group_id'] = __('cms-faq::admin.Group');
        }

        return $this->localizeAttributes(
            [
                'question' => __('cms-faq::admin.Question'),
                'answer' => __('cms-faq::admin.Answer'),
            ],
            $attributes
        );
    }
}
