<?php

namespace WezomCms\Benefits;

use WezomCms\Benefits\Enums\BenefitsTypes;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;

class BenefitsServiceProvider extends BaseServiceProvider
{
	use SidebarMenuGroupsTrait;

	/**
	 * All module widgets.
	 *
	 * @var array|string|null
	 */
	protected $widgets = 'cms.benefits.benefits.widgets';

    /**
     * List of enum classes for auto scanning localization keys.
     *
     * @var array
     */
    protected $enumClasses = [
        BenefitsTypes::class,
    ];

	/**
	 * @param  PermissionsContainerInterface  $permissions
	 */
	public function permissions(PermissionsContainerInterface $permissions)
	{
		$permissions->add('benefits', __('cms-benefits::admin.Benefits'));
	}

	public function adminMenu()
	{
		$this->contentGroup()
			->add(__('cms-benefits::admin.Benefits'), route('admin.benefits.index'))
			->data('permission', 'benefits.view')
			->data('icon', 'fa-newspaper-o')
			->nickname('benefits')
		;
	}
}
