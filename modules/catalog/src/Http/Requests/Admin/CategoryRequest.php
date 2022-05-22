<?php

namespace WezomCms\Catalog\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class CategoryRequest extends FormRequest
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
                'text' => 'nullable|string|max:100000',
                'title' => 'nullable|string|max:255',
                'h1' => 'nullable|string|max:255',
                'keywords' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
            ],
            [
                'published' => 'required|bool',
                'parent_id' => 'nullable|int|exists:categories,id',
                'show_on_main' => 'required|bool',
                'show_on_menu' => 'required|bool',
                'SPECIFICATIONS' => 'nullable|array',
                'SPECIFICATIONS.*' => 'required|int|exists:specifications,id',
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
                'name' => __('cms-catalog::admin.categories.Name'),
                'slug' => __('cms-core::admin.layout.Slug'),
                'text' => __('cms-catalog::admin.categories.Text'),
                'title' => __('cms-core::admin.seo.Title'),
                'h1' => __('cms-core::admin.seo.H1'),
                'keywords' => __('cms-core::admin.seo.Keywords'),
                'description' => __('cms-core::admin.seo.Description'),
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'parent_id' => __('cms-catalog::admin.categories.Parent'),
                'show_on_main' => __('cms-catalog::admin.categories.Show on main'),
                'show_on_menu' => __('cms-catalog::admin.categories.Show on menu'),
                'SPECIFICATIONS' => __('cms-catalog::admin.products.Sales'),
                'SPECIFICATIONS.*' => __('cms-catalog::admin.products.Sales'),
            ]
        );
    }
}
