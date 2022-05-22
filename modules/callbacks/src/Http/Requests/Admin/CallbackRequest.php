<?php

namespace WezomCms\Callbacks\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CallbackRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
            'name' => __('cms-callbacks::admin.Name'),
            'phone' => __('cms-callbacks::admin.Phone'),
            'read' => __('cms-callbacks::admin.Read'),
        ];
    }
}
