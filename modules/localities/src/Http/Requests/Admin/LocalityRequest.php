<?php

namespace WezomCms\Localities\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class LocalityRequest extends FormRequest
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
                'published' => 'required|bool',
                'city_id' => 'required|exists:cities,id',
                'delivery_cost' => 'required|int|min:0',
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
                'name' => __('cms-localities::admin.Name')
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'city_id' => __('cms-localities::admin.City'),
                'delivery_cost' => __('cms-localities::admin.Delivery cost'),
            ]
        );
    }
}
