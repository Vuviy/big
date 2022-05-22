<?php

namespace WezomCms\About\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AboutReviewRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'published' => 'required|bool',
            'notify' => 'required|bool',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'text' => 'required|string|max:65535',
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
            'published' => __('cms-core::admin.layout.Published'),
            'name' => __('cms-about::admin.Name'),
            'email' => __('cms-about::admin.E-mail'),
            'text' => __('cms-about::admin.Text'),
            'notify' => __('cms-about::admin.Notify about replies'),
        ];
    }
}
