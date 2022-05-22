<?php

namespace WezomCms\Catalog\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class ModelRequest extends FormRequest
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
            ],
            [
                'published' => 'required',
                'slug' => 'required|string|max:255',
                'brand_id' => ['nullable', 'exists:brands,id', Rule::requiredIf(config('cms.catalog.brands.enabled'))],
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
                'name' => __('cms-catalog::admin.models.Name'),
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'slug' => __('cms-core::admin.layout.Slug'),
                'brand_id' => __('cms-catalog::admin.models.Brand'),
            ]
        );
    }
}
