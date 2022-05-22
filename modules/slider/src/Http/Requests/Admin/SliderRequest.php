<?php

namespace WezomCms\Slider\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use WezomCms\Core\Http\Requests\ChangeStatus\RequiredIfMessageTrait;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class SliderRequest extends FormRequest
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
        $rules = [
            'slider' => 'nullable',
            'open_in_new_tab' => 'bool',
            'price' => 'nullable|numeric',
        ];

        $sliders = collect(config('cms.slider.slider.sliders'))->keys();
        if ($sliders->count() > 1) {
            $rules['slider'] .= '|required|in:' . $sliders->implode(',');
        }

        return $this->localizeRules(
            [
                'published' => 'required',
                'url' => 'nullable|string|max:255',
                'image' => 'nullable|image|max:1024',
                'image_mobile' => 'nullable|image|max:1024',
                'name' => 'required|string|max:255',
                'description_1' => 'nullable|string|max:65535',
                'description_2' => 'nullable|string|max:65535',
            ],
            $rules
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
                'url' => __('cms-slider::admin.Link'),
                'image' => __('cms-slider::admin.Image'),
                'image_mobile' => __('cms-slider::admin.Image Mobile'),
                'name' => __('cms-slider::admin.Name'),
                'description_1' => __('cms-slider::admin.Description 1'),
                'description_2' => __('cms-slider::admin.Description 2'),
            ],
            [
                'slider' => __('cms-slider::admin.Slider'),
                'price' => __('cms-slider::admin.Price')
            ]
        );
    }
}
