<?php

namespace WezomCms\Benefits\Http\Requests\Admin;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use WezomCms\Benefits\Enums\BenefitsTypes;
use WezomCms\Core\Http\Requests\ChangeStatus\RequiredIfMessageTrait;
use WezomCms\Core\Traits\LocalizedRequestTrait;

class BenefitsRequest extends FormRequest
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
				'name' => 'required|string|max:255',
                'description' => 'required|string|max:20000',
			],
			[
			    'type' => ['required', 'string', Rule::in(BenefitsTypes::getValues())],
				'icon' => 'required|string',
				'published' => 'required|bool',
				'sort' => 'nullable|integer',
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
				'name' => __('cms-benefits::admin.Name'),
				'description' => __('cms-benefits::admin.Description'),
			],
			[
				'type' => __('cms-benefits::admin.Location'),
				'sort' => __('cms-core::admin.layout.Position'),
				'published' => __('cms-core::admin.layout.Published'),
				'icon' => __('cms-benefits::admin.Icon'),
			]
		);
	}
}
