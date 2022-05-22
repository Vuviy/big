<?php

namespace WezomCms\News\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Http\Requests\ChangeStatus\RequiredIfMessageTrait;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class NewsRequest extends FormRequest
{
    use LocalizedRequestTrait;
    use RequiredIfMessageTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return $this->localizeRules(
            [
                'published' => 'required',
                'name' => 'nullable|string|max:255|required_if:{locale}.published,1',
                'slug' => 'nullable|string|max:255|required_if:{locale}.published,1',
                'text' => 'nullable|string|max:16777215',
                'title' => 'nullable|string|max:255',
                'h1' => 'nullable|string|max:255',
                'keywords' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:255',
            ],
            [
                'published_at' => 'required|date',
                'image' => 'nullable|image',
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
            [
                'published' => __('cms-core::admin.layout.Published'),
                'name' => __('cms-news::admin.Name'),
                'slug' => __('cms-core::admin.layout.Slug'),
                'text' => __('cms-news::admin.Text'),
                'title' => __('cms-core::admin.seo.Title'),
                'h1' => __('cms-core::admin.seo.H1'),
                'keywords' => __('cms-core::admin.seo.Keywords'),
                'description' => __('cms-core::admin.seo.Description'),
            ],
            [
                'published_at' => __('cms-news::admin.Published at'),
                'image' => __('cms-news::admin.Image'),
            ]
        );
    }
}
