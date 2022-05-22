<?php

namespace WezomCms\Orders\Http\Controllers\Site;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Core\Traits\LoadMoreTrait;
use WezomCms\Orders\Models\Order;

class CabinetOrdersController extends SiteController
{
    use LoadMoreTrait;


    public function index(Request $request)
    {
        // Meta
        $this->addBreadcrumb(settings('orders.site.name'));
        $this->seo()
            ->setPageName(settings('orders.site.name'))
            ->setTitle(settings('orders.site.title'))
            ->setH1(settings('orders.site.h1'));

        // Select orders
        $result = Order::where('user_id', Auth::id())
            ->with('delivery', 'payment')
            ->latest('id')
            ->paginate(settings('orders.site.limit', 10));

        if ($request->expectsJson()) {
            return $this->makeJsonResponse(
                $result,
                $request->query(),
                view('cms-orders::site.partials.cabinet-orders-list', compact('result'))->render()
            );
        }

        // Render
        return view('cms-orders::site.cabinet.orders', compact('result'));
    }

    protected function makeJsonResponse(LengthAwarePaginator $result, array $query, $content)
    {
        return JsResponse::make(
            [
                'html' => $content,
                'titleDocument' => $this->seo()->getTitle(),
                'more' => $result->hasMorePages(),
                'pagination' => $result->links()->toHtml(),
                'newPageUrl' => $result->url($result->currentPage() + 1),
                'countMore' => count_more($result),
            ]
        );
    }

    public function reviewsPopup($id)
    {
        $order = Order::where('user_id', Auth::id())
            ->with('items')
            ->where('id', $id)
            ->first();

        $items = $order->items;

        return view('cms-orders::site.partials.orders-leave-review', compact('items'));
    }
}
