<?php

namespace WezomCms\Localities\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class CityRequest extends FormRequest
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
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
            ],
            [
                'published' => 'required|bool',
                'index' => 'required|string',
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
                'name' => __('cms-localities::admin.Name'),
                'slug' => __('cms-core::admin.layout.Slug'),
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'index' => __('cms-localities::admin.Index'),
            ]
        );
    }
}
