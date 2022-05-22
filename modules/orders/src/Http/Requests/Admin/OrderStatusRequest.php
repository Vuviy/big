<?php

namespace WezomCms\Orders\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class OrderStatusRequest extends FormRequest
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
            [
                'color' => 'nullable|string|max:50',
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
            ['name' => __('cms-orders::admin.statuses.Name')],
            [
                'color' => __('cms-orders::admin.statuses.Color'),
            ]
        );
    }
}
