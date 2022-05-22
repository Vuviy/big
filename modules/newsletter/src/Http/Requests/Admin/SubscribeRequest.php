<?php

namespace WezomCms\Newsletter\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SubscribeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'active' => 'required',
            'email' => 'required|email|max:255|unique:subscribers,email,' . $this->route('subscriber'),
            'locale' => 'required|in:' . implode(',', array_keys(app('locales'))),
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
            'active' => __('cms-newsletter::admin.Status'),
            'email' => __('cms-newsletter::admin.E-mail'),
            'locale' => __('cms-newsletter::admin.Locale'),
        ];
    }
}
