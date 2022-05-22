<?php

namespace WezomCms\Newsletter\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SendLetterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'locale' => 'required|in:' . implode(',', array_keys(app('locales'))),
            'subject' => 'required|max:255',
            'text' => 'required|max:16777215',
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
            'locale' => __('cms-newsletter::admin.Locale'),
            'subject' => __('cms-newsletter::admin.Subject'),
            'text' => __('cms-newsletter::admin.Text'),
        ];
    }
}
