<?php

namespace WezomCms\BuyOneClick\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BuyOneClickRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'product_id' => 'required|exists:products,id',
            'count' => 'nullable|numeric',
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:255|regex:/^\+?[\d\s\(\)-]+$/',
            'read' => 'required',
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
            'product_id' => __('cms-buy-one-click::admin.Product'),
            'count' => __('cms-buy-one-click::admin.Count'),
            'name' => __('cms-buy-one-click::admin.Name'),
            'phone' => __('cms-buy-one-click::admin.Phone'),
            'read' => __('cms-buy-one-click::admin.Read'),
        ];
    }
}
