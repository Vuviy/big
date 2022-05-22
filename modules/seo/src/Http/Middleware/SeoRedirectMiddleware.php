<?php

namespace WezomCms\Seo\Http\Middleware;

use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Seo\Models\SeoRedirect;

class SeoRedirectMiddleware
{
    /**
     * @param  Request  $request
     * @param  Closure  $next
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('GET') && !$request->expectsJson()) {
            $uri = app('request')->getRequestUri();

            /** @var SeoRedirect|null $redirect */
            $redirect = SeoRedirect::select('link_to', 'http_status')
                ->where(function (Builder $query) use ($uri) {
                    $query->where('link_from', $uri)
                        ->orWhere('link_from', trim($uri, '/'))
                        ->orWhere(\DB::raw('TRIM(\'/\' FROM link_from)'), trim($uri, '/'));
                })
                ->where('published', true)
                ->first();

            if ($redirect) {
                return redirect($redirect->link_to, (int) $redirect->http_status);
            }
        }

        return $next($request);
    }
}
