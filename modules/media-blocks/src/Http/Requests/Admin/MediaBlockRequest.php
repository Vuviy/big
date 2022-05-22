<?php

namespace WezomCms\MediaBlocks\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Http\Requests\ChangeStatus\RequiredIfMessageTrait;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class MediaBlockRequest extends FormRequest
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
                'url' => 'required|url',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:65535',
                'image' => 'nullable|image|mimetypes:image/jpeg,image/png',
                'video' => 'nullable|mimetypes:video/mp4|max:' . config('cms.media-blocks.media-blocks.video.max_file_size', '20') . '000'
            ],
            [
                'published' => 'required|bool',
                'open_in_new_tab' => 'required|bool',
                'icon' => 'nullable|string|max:255',
                'type' => 'required|string',
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
                'url' => __('cms-media-blocks::admin.Link'),
                'name' => __('cms-media-blocks::admin.Name'),
                'description' => __('cms-media-blocks::admin.Description'),
                'image' => __('cms-media-blocks::admin.Image'),
                'video' => __('cms-core::admin.video.Video'),
            ],
            [
                'published' => __('cms-core::admin.layout.Published'),
                'open_in_new_tab' => __('cms-media-blocks::admin.Open link in new tab'),
                'icon' => __('cms-media-blocks::admin.Icon'),
                'type' => __('cms-media-blocks::admin.Location'),
            ]
        );
    }
}
