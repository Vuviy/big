<?php

namespace WezomCms\Ui\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use WezomCms\Core\Http\Controllers\SiteController;

class NotFoundController extends SiteController
{
    /**
     * @param  Request  $request
     * @return JsonResponse|RedirectResponse|Response
     */
    public function __invoke(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => __('cms-ui::site.Page not found')], 404);
        } else {
            $this->seo()->setTitle(__('cms-ui::site.Page not found'));

            return response()->view('cms-ui::errors.404', [], 404);
        }
    }
}
