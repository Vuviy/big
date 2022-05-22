<?php

namespace WezomCms\Newsletter;

use Event;
use Illuminate\Auth\Events\Login;
use SidebarMenu;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Newsletter\Listeners\AttachToUnoccupied;
use WezomCms\Newsletter\Observers\UserObserver;
use WezomCms\Users\Models\User;
use WezomCms\Users\UsersServiceProvider;

class NewsletterServiceProvider extends BaseServiceProvider
{
    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.newsletter.newsletter.dashboards';

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('subscribers', __('cms-newsletter::admin.Subscribers'));

        $permissions->add(
            'newsletter',
            __('cms-newsletter::admin.Newsletter'),
            [
                'view', __('cms-newsletter::admin.View mailing list'),
                'send' => __('cms-newsletter::admin.Send letters'),
                'show' => __('cms-newsletter::admin.Watch sent letter'),
            ]
        );
    }

    public function adminMenu()
    {
        $newsletter = SidebarMenu::add(__('cms-newsletter::admin.Newsletter'))
            ->data('icon', 'fa-rss')
            ->data('position', 60)
            ->nickname('newsletter');

        $newsletter->add(__('cms-newsletter::admin.Send a letter'), route('admin.newsletter.form'))
            ->data('permission', 'newsletter.send')
            ->data('icon', 'fa-paper-plane')
            ->data('position', 1);

        $newsletter->add(__('cms-newsletter::admin.Mailing list'), route('admin.newsletter.index'))
            ->data('permission', 'newsletter.view')
            ->data('icon', 'fa-clock-o')
            ->data('position', 2);

        $newsletter->add(__('cms-newsletter::admin.Subscribers list'), route('admin.subscribers.index'))
            ->data('permission', 'subscribers.view')
            ->data('icon', 'fa-users')
            ->data('position', 3);
    }

    /**
     * Register module listeners.
     */
    protected function registerListeners()
    {
        parent::registerListeners();

        if (Helpers::providerLoaded(UsersServiceProvider::class)) {
            User::observe(UserObserver::class);

            if (!$this->app['isBackend']) {
                Event::listen(Login::class, AttachToUnoccupied::class);
            }
        }
    }
}
