<?php

namespace WezomCms\Faq;

use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;

class FaqServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.faq.faq.dashboards';

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('faq', __('cms-faq::admin.FAQ questions'))->withEditSettings();

        if (config('cms.faq.faq.use_groups')) {
            $permissions->add('faq-groups', __('cms-faq::admin.FAQ groups'));
        }
    }

    public function adminMenu()
    {
        $group = $this->contentGroup()
            ->add(__('cms-faq::admin.FAQ'))
            ->data('icon', 'fa-question-circle-o')
            ->data('position', 8)
            ->nickname('faq');

        $position = 1;

        if (config('cms.faq.faq.use_groups')) {
            // Groups
            $group->add(__('cms-faq::admin.Groups'), route('admin.faq-groups.index'))
                ->data('permission', 'faq-groups.view')
                ->data('icon', 'fa-th-large')
                ->data('position', $position++);
        }

        // Questions
        $group->add(__('cms-faq::admin.Questions'), route('admin.faq.index'))
            ->data('permission', 'faq.view')
            ->data('icon', 'fa-question')
            ->data('position', $position++);

        // Settings
        $group->add(__('cms-core::admin.layout.Settings'), route('admin.faq.settings'))
            ->data('permission', 'faq.edit-settings')
            ->data('icon', 'fa-cog')
            ->data('position', $position);
    }

    /**
     * @return array
     */
    public function sitemap()
    {
        return [
            [
                'id' => 'faq',
                'parent_id' => 0,
                'name' => settings('faq.site.name'),
                'url' => route('faq'),
            ],
        ];
    }

    /**
     * @param  SitemapXmlGeneratorInterface  $sitemap
     */
    public function sitemapXml(SitemapXmlGeneratorInterface $sitemap)
    {
        $sitemap->addLocalizedRoute('faq');
    }
}
