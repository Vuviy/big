<?php

namespace WezomCms\About;

use SidebarMenu;
use WezomCms\About\Models\AboutReview;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;

class AboutServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.about.about.widgets';

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->editSettings('about', __('cms-about::admin.Edit about page'));
        $permissions->add('about-events', __('cms-faq::admin.Events'))->withEditSettings();
        $permissions->add('about-reviews', __('cms-faq::admin.Reviews'))->withEditSettings();
    }

    public function adminMenu()
    {
        $group = SidebarMenu::add(__('cms-about::admin.About'))
            ->data('icon', 'fa-info-circle')
            ->data('position', 9)
            ->nickname('about');

        $position = 1;

        $count = AboutReview::where('published', false)->count();

        $group->data('badge', $group->data('badge') + $count)
            ->data('badge_type', 'warning');

        $group->add(__('cms-about::admin.Events'), route('admin.about-events.index'))
            ->data('permission', 'about-events.view')
            ->data('icon', 'fa-th-large')
            ->data('position', $position++);

        $group->add(__('cms-our-team::admin.Our team'), route('admin.employees.index'))
            ->data('permission', 'employees.view')
            ->data('icon', 'fa-users')
            ->data('position', $position++)
            ->nickname('employees');

        $group->add(__('cms-about::admin.Reviews'), route('admin.about-reviews.index'))
            ->data('permission', 'about-reviews.view')
            ->data('icon', 'fa-comments')
            ->data('badge', $count)
            ->data('badge_type', 'warning')
            ->data('position', $position++);

        $group->add(__('cms-core::admin.layout.Settings'), route('admin.about.settings'))
            ->data('permission', 'about.edit-settings')
            ->data('icon', 'fa-cog')
            ->data('position', $position++)
            ->nickname('about-settings');
    }

    /**
     * @return array
     */
    public function sitemap()
    {
        return [
            [
                'sort' => 11,
                'parent_id' => 0,
                'url' => route('about'),
                'name' => settings('about.site.name'),
            ]
        ];
    }

    /**
     * @param  SitemapXmlGeneratorInterface  $sitemap
     */
    public function sitemapXml(SitemapXmlGeneratorInterface $sitemap)
    {
        $sitemap->addLocalizedRoute('about');
    }
}
