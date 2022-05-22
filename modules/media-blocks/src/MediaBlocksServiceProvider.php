<?php

namespace WezomCms\MediaBlocks;

use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;

class MediaBlocksServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.media-blocks.media-blocks.widgets';

    /**
     * Custom translation keys.
     *
     * @var array
     */
    protected $translationKeys = [
        'cms-media-blocks::admin.Home top categories 1',
        'cms-media-blocks::admin.Home top categories 2',
        'cms-media-blocks::admin.Home top categories 3',
    ];

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('media-blocks', __('cms-media-blocks::admin.Медиа блоки'));
    }

    public function adminMenu()
    {
        $this->contentGroup()
            ->add(__('cms-media-blocks::admin.Media blocks'), route('admin.media-blocks.index'))
            ->data('permission', 'media-blocks.view')
            ->data('icon', 'fa-quote-left')
            ->data('position', 9)
            ->nickname('media-blocks');
    }
}
