<?php

namespace WezomCms\Slider;

use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;

class SliderServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.slider.slider.widgets';

    /**
     * Custom translation keys.
     *
     * @var array
     */
    protected $translationKeys = ['cms-slider::admin.Main slider'];

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('slides', __('cms-slider::admin.Sliders'))->withEditSettings();
    }

    public function adminMenu()
    {
        $this->contentGroup()
            ->add(__('cms-slider::admin.Slider'), route('admin.slides.index'))
            ->data('permission', 'slides.view')
            ->data('icon', 'fa-file-image-o')
            ->data('position', 9)
            ->nickname('slides');
    }
}
