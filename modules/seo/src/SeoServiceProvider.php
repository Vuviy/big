<?php

namespace WezomCms\Seo;

use Event;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;
use WezomCms\Seo\Http\Middleware\SeoRedirectMiddleware;
use WezomCms\Seo\Models\SeoLink;

class SeoServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.seo.seo.widgets';

    protected function afterBoot()
    {
        app('router')->pushMiddlewareToGroup('web', SeoRedirectMiddleware::class);
    }

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('seo-links', __('cms-seo::admin.links.SEO links'));

        $permissions->add('seo-redirects', __('cms-seo::admin.redirects.SEO redirects'));
        $permissions->addItem('seo-redirects.import', __('cms-seo::admin.redirects.Import'));

        $permissions->editSettings('seo', __('cms-seo::admin.SEO'));
    }

    /**
     * Register all admin sidebar menu links.
     */
    public function adminMenu()
    {
        $seo = $this->serviceGroup()
            ->add(__('cms-seo::admin.SEO'))
            ->data('position', 50)
            ->data('icon', 'fa-line-chart')
            ->nickname('seo');

        $seo->add(__('cms-seo::admin.links.Links'), route('admin.seo-links.index'))
            ->data('permission', 'seo-links.view')
            ->data('icon', 'fa-link')
            ->data('position', 1);

        $seo->add(__('cms-seo::admin.redirects.Redirects'), route('admin.seo-redirects.index'))
            ->data('permission', 'seo-redirects.view')
            ->data('icon', 'fa-exchange')
            ->data('position', 2);

        $seo->add(__('cms-seo::admin.Settings'), route('admin.seo.settings'))
            ->data('permission', 'seo.edit-settings')
            ->data('icon', 'fa-cog')
            ->data('position', 10);
    }

    /**
     * Register module listeners.
     */
    protected function registerListeners()
    {
        parent::registerListeners();

        Event::listen('seo_tools:get_tags_for_current_link', function () {
            return SeoLink::findByCurrentLink();
        });

        Event::listen('after-modules-sitemap:xml', function (SitemapXmlGeneratorInterface $sitemap) {
            $seoLinks = SeoLink::published()->pluck('link');

            if ($seoLinks->isEmpty()) {
                return;
            }

            foreach ($seoLinks as $link) {
                $fullLink = url($link);

                if ($sitemap->doesNotHave($fullLink)) {
                    $sitemap->add($fullLink);
                }
            }
        });
    }
}
