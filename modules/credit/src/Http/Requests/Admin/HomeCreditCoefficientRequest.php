<?php

namespace WezomCms\Credit\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use WezomCms\Credit\Enums\CreditType;

class HomeCreditCoefficientRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'published' => 'required|boolean',
            'month' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('home_credit_coefficients', 'month')
                    ->ignore($this->route('home_credit_coefficient'))
            ],
            'type' => ['required', 'string', Rule::in(CreditType::getValues())],
            'coefficient' => 'required|numeric|min:0',
            'availability' => 'required|numeric|min:0',
            'max_sum' => 'required|numeric|min:1|gt:availability',
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
            'published' => __('cms-core::admin.layout.Published'),
            'month' => __('cms-credit::admin.Month'),
            'type' => __('cms-credit::admin.Type'),
            'coefficient' => __('cms-credit::admin.Coefficient'),
            'availability' => __('cms-credit::admin.Availability'),
            'max_sum' => __('cms-credit::admin.Max sum'),
        ];
    }
}
