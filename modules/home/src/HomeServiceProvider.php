<?php

namespace WezomCms\Home;

use SidebarMenu;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\NavBar\NavBarInterface;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;
use WezomCms\Home\NavBarItems\Home;

class HomeServiceProvider extends BaseServiceProvider
{
    protected function afterBootForAdminPanel()
    {
        $this->app[NavBarInterface::class]->add(new Home());
    }

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->editSettings('home', __('cms-home::admin.Edit home page'));
    }

    public function adminMenu()
    {
        SidebarMenu::add(__('cms-home::admin.Home'), route('admin.home.settings'))
            ->data('permission', 'home.edit-settings')
            ->data('icon', 'fa-home')
            ->data('position', -9)
            ->nickname('home-settings');
    }

    /**
     * @return array
     */
    public function sitemap()
    {
        return [
            [
                'sort' => -99,
                'parent_id' => 0,
                'name' => settings('home.site.name'),
                'url' => route('home'),
            ]
        ];
    }

    /**
     * @param  SitemapXmlGeneratorInterface  $sitemap
     */
    public function sitemapXml(SitemapXmlGeneratorInterface $sitemap)
    {
        $sitemap->addLocalizedRoute('home');
    }
}
