<?php

namespace WezomCms\PrivacyPolicy;

use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;

class PrivacyPolicyServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->editSettings('privacy-policy', __('cms-privacy-policy::admin.Edit privacy policy'));
    }

    public function adminMenu()
    {
        $this->serviceGroup()
            ->add(__('cms-privacy-policy::admin.Privacy policy'), route('admin.privacy-policy.settings'))
            ->data('permission', 'privacy-policy.edit-settings')
            ->data('icon', 'fa-user-secret')
            ->data('position', 30)
            ->nickname('privacy-policy-settings');
    }

    /**
     * @return array
     */
    public function sitemap()
    {
        return [
            [
                'sort' => 120,
                'parent_id' => 0,
                'name' => settings('privacy-policy.site.name'),
                'url' => route('privacy-policy'),
            ]
        ];
    }

    /**
     * @param  SitemapXmlGeneratorInterface  $sitemap
     */
    public function sitemapXml(SitemapXmlGeneratorInterface $sitemap)
    {
        $sitemap->addLocalizedRoute('privacy-policy');
    }
}
