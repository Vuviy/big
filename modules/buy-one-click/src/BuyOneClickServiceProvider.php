<?php

namespace WezomCms\BuyOneClick;

use Auth;
use Event;
use SidebarMenu;
use WezomCms\BuyOneClick\Models\BuyOneClick;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\ProductReviews\Models\ProductReview;
use WezomCms\ProductReviews\ProductReviewsServiceProvider;

class BuyOneClickServiceProvider extends BaseServiceProvider
{
    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.buy-one-click.buy-one-click.dashboards';

    /**
     * Custom translation keys.
     *
     * @var array
     */
    protected $translationKeys = [
        'cms-buy-one-click::admin.pieces',
        'cms-buy-one-click::site.pieces',
    ];

    /**
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('buy-one-click', __('cms-buy-one-click::admin.Buy one click'))->withEditSettings();
    }

    public function adminMenu()
    {
        $orders = SidebarMenu::get('orders');
        if (!$orders) {
            $orders = SidebarMenu::add(__('cms-buy-one-click::admin.Orders'))
                ->data('icon', 'fa-shopping-cart')
                ->data('badge_type', 'warning')
                ->data('position', 7)
                ->nickname('orders');
        }

        $count = BuyOneClick::whereRead(false)->count();

        $orders->data('badge', $orders->data('badge') + $count);

        $orders->add(__('cms-buy-one-click::admin.Buy one click'), route('admin.buy-one-click.index'))
            ->data('permission', 'buy-one-click.view')
            ->data('icon', 'fa-rocket')
            ->data('badge', $count)
            ->data('badge_type', 'warning')
            ->data('position', 2);
    }

    /**
     * Register module listeners.
     */
    protected function registerListeners()
    {
        parent::registerListeners();

        if (!$this->app['isBackend'] && Helpers::providerLoaded(ProductReviewsServiceProvider::class)) {
            Event::listen('created_product_review', function (ProductReview $review) {
                if (Auth::guest()) {
                    return;
                }

                $exists = BuyOneClick::where('user_id', Auth::user()->getAuthIdentifier())
                    ->where('product_id', $review->product_id)
                    ->exists();

                if ($exists) {
                    $review->update(['already_bought' => true]);
                }
            });
        }
    }
}
