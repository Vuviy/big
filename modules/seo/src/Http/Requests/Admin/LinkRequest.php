<?php

namespace WezomCms\Seo\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LinkRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'link' => 'required|max:255|unique:seo_links,link,' . $this->route('seo_link'),
            'title' => 'nullable|string|max:255',
            'h1' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:255',
            'keywords' => 'nullable|string|max:255',
            'seo_text' => 'nullable|string',
            'published' => 'required',
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
            'name' => __('cms-core::admin.seo.Name'),
            'published' => __('cms-core::admin.layout.Published'),
            'link' => __('cms-core::admin.seo.Link'),
            'title' => __('cms-core::admin.seo.Title'),
            'h1' => __('cms-core::admin.seo.H1'),
            'description' => __('cms-core::admin.seo.Description'),
            'keywords' => __('cms-core::admin.seo.Keywords'),
            'seo_text' => __('cms-core::admin.seo.Seo text'),
        ];
    }
}
