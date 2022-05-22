<?php

namespace WezomCms\Seo\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Seo\Enums\RedirectHttpStatus;

class RedirectRequest extends FormRequest
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
            'published' => 'required',
            'link_from' => 'required|string|max:255|unique:seo_redirects,link_to'
                . '|unique:seo_redirects,link_from,' . $this->route('seo_redirect'),
            'link_to' => 'required|string|max:255|different:link_from|unique:seo_redirects,link_from',
            'http_status' => 'required|in:' . implode(',', RedirectHttpStatus::getValues()),
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
            'name' => __('cms-seo::admin.redirects.Name'),
            'published' => __('cms-core::admin.layout.Published'),
            'link_from' => __('cms-seo::admin.redirects.Link from'),
            'link_to' => __('cms-seo::admin.redirects.Link to'),
            'http_status' => __('cms-seo::admin.redirects.HTTP status')
        ];
    }
}
