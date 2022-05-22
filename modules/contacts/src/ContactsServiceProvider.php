<?php

namespace WezomCms\Contacts;

use SidebarMenu;
use WezomCms\Contacts\Models\Contact;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;

class ContactsServiceProvider extends BaseServiceProvider
{
    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.contacts.contacts.widgets';

    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.contacts.contacts.dashboards';

    public function adminMenu()
    {
        $count = Contact::unread()->count();

        $contacts = SidebarMenu::add(__('cms-contacts::admin.Contacts'))
            ->data('icon', 'fa-address-book-o')
            ->data('badge', $count)
            ->data('badge_type', 'warning')
            ->data('position', 8)
            ->nickname('contacts');

        $contacts->add(__('cms-branches::admin.Branches'), route('admin.branches.index'))
            ->data('icon', 'fa-university')
            ->data('permission', 'branches.view')
            ->data('position', 1)
            ->nickname('branches');

        $contacts->add(__('cms-contacts::admin.Requests'), route('admin.contacts.index'))
            ->data('permission', 'contacts.view')
            ->data('icon', 'fa-envelope')
            ->data('badge', $count)
            ->data('badge_type', 'warning')
            ->data('position', 2);
    }

    /**
     * @return array
     */
    public function sitemap()
    {
        return [
            [
                'id' => 'contacts',
                'sort' => 11,
                'parent_id' => 0,
                'name' => settings('contacts.site.name'),
                'url' => route('contacts'),
            ],
        ];
    }

    /**
     * @param  SitemapXmlGeneratorInterface  $sitemap
     */
    public function sitemapXml(SitemapXmlGeneratorInterface $sitemap)
    {
        $sitemap->addLocalizedRoute('contacts');
    }

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('contacts', __('cms-contacts::admin.Requests'))->withEditSettings();
    }
}
