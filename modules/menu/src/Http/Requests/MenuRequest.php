<?php

namespace WezomCms\Menu\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Http\Requests\ChangeStatus\RequiredIfMessageTrait;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class MenuRequest extends FormRequest
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
                'name' => 'nullable|required_if:{locale}.published,1|string|max:255',
                'url' => 'nullable|required_if:{locale}.published,1|string|max:255',
            ],
            [
                'parent_id' => 'nullable|int|exists:menu,id',
                'group' => 'required|in:' . implode(',', array_keys(config('cms.menu.menu.groups', []))),
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
                'name' => __('cms-menu::admin.Name'),
                'url' => __('cms-menu::admin.Url'),
            ],
            [
                'parent_id' => __('cms-menu::admin.Parent'),
                'group' => __('cms-menu::admin.Group'),
            ]
        );
    }
}
