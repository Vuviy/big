<?php

namespace WezomCms\Seo\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ImportRedirectsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'required|file|mimes:xls,xlsx,csv,tsv,txt',
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
            'file' => __('cms-seo::admin.redirects.File'),
        ];
    }
}
