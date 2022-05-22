<?php

namespace WezomCms\Contacts\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'read' => 'required|bool',
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'city' => 'nullable|string|max:255',
            'message' => 'required|string|max:65535',
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
            'read' => __('cms-contacts::admin.Status'),
            'name' => __('cms-contacts::admin.Name'),
            'phone' => __('cms-contacts::admin.Phone'),
            'email' => __('cms-contacts::admin.E-mail'),
            'city' => __('cms-contacts::admin.City'),
            'message' => __('cms-contacts::admin.Message'),
        ];
    }
}
