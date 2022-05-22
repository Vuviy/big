<?php

namespace WezomCms\Catalog\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class ProductRequest extends FormRequest
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
            'published' => 'required|bool',
            'available' => 'required|bool',
            'group_key' => 'nullable|string|max:255',
            'vendor_code' => 'required|string|max:100',
            'novelty' => 'required|bool',
            'popular' => 'required|bool',
            'sale' => 'required|bool',
            'cost' => 'required|int|min:0|max:99999999',
            'old_cost' => 'nullable|int|min:0|max:99999999|required_if:sale,1',
            'videos.*' => 'required|string|distinct|url',
            'category_id' => 'required|int|exists:categories,id',
            'expires_at' => 'nullable|date',
            'discount_percentage' => 'nullable|int|between:1,99',
        ];

        if (config('cms.catalog.brands.enabled', false)) {
            $rules['brand_id'] = 'nullable|exists:brands,id';
        }
        if (config('cms.catalog.models.enabled', false)) {
            $rules['model_id'] = 'nullable|exists:models,id';
        }

        $request = app('request');
        if ($request->has('cost') && $request->get('sale')) {
            $rules['old_cost'] .= '|gt:cost';
        }

        return $this->localizeRules(
            [
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'text' => 'nullable|string|max:16777215',
                'title' => 'nullable|string|max:255',
                'h1' => 'nullable|string|max:255',
                'keywords' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
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
        return $this->localizeAttributes(
            [
                'name' => __('cms-catalog::admin.products.Name'),
                'slug' => __('cms-core::admin.layout.Slug'),
                'text' => __('cms-catalog::admin.products.Text'),
                'title' => __('cms-core::admin.seo.Title'),
                'h1' => __('cms-core::admin.seo.H1'),
                'keywords' => __('cms-core::admin.seo.Keywords'),
                'description' => __('cms-core::admin.seo.Description'),
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'available' => __('cms-catalog::admin.products.Are available'),
                'group_key' => __('cms-catalog::admin.products.Group key'),
                'vendor_code' => __('cms-catalog::admin.products.Vendor code'),
                'novelty' => __('cms-catalog::admin.products.Novelty'),
                'popular' => __('cms-catalog::admin.products.Popular'),
                'cost' => __('cms-catalog::admin.products.Cost'),
                'old_cost' => __('cms-catalog::admin.products.Old cost'),
                'sale' => __('cms-catalog::admin.products.Sale'),
                'category_id' => __('cms-catalog::admin.products.Category'),
                'expires_at' => __('cms-catalog::admin.products.Expires at'),
                'discount_percentage' => __('cms-catalog::admin.products.Discount percentage'),
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
        return [
            'videos.*.url' => __('cms-catalog::admin.products.Invalid video url'),
            'expires_at.after' => __('cms-catalog::admin.products.End date of the promotion'),
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->sometimes('expires_at', 'after:yesterday', function ($request) {
            return 1 == $request->get('sale');
        });
    }
}
