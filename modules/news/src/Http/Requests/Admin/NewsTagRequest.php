<?php

namespace WezomCms\News\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class NewsTagRequest extends FormRequest
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
                'title' => 'nullable|string|max:255',
                'h1' => 'nullable|string|max:255',
                'keywords' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
            ],
            [
                'published' => 'required',
                'slug' => 'required|string|max:255|unique:news_tags,slug,' . $this->route('news_tag')
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
        return $this->localizeAttributes([
            'name' => __('cms-news::admin.Name'),
            'title' => __('cms-core::admin.seo.Title'),
            'h1' => __('cms-core::admin.seo.H1'),
            'keywords' => __('cms-core::admin.seo.Keywords'),
            'description' => __('cms-core::admin.seo.Description'),
        ], [
            'published' => __('cms-core::admin.layout.Published'),
            'slug' => __('cms-core::admin.layout.Slug'),
        ]);
    }
}
