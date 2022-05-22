<?php

namespace WezomCms\OurTeam\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class EmployeeRequest extends FormRequest
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
                'position' => 'required|string|max:255',
                'description' => 'required|string|max:30000',
            ],
            [
                'published' => 'required|bool',
                'image' => 'nullable|image|max:1024',
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
                'name' => __('cms-our-team::admin.Name'),
                'position' => __('cms-our-team::admin.Position'),
                'description' => __('cms-our-team::admin.Description'),
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'image' => __('cms-our-team::admin.Image'),
            ]
        );
    }
}
