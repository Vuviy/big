<?php

namespace WezomCms\Users\Http\Controllers\Site;

use Auth;
use Flash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use WezomCms\Core\Http\Controllers\SiteController;

class CabinetController extends SiteController
{
    protected function before()
    {
        $this->addBreadcrumb(settings('users.cabinet.name'), route('cabinet'));
    }

    /**
     * Page with form for edit profile info.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $this->before();

        $this->seo()->fill(settings('users.cabinet', []))->noIndex();

        return view('cms-users::site.cabinet.index', ['user' => Auth::user()]);
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return RedirectResponse|Redirector
     */
    public function logout(Request $request)
    {
        $guard = Auth::guard();

        $guard->logout();

        $request->session()->forget($guard->getName());

        Flash::info(__('cms-users::site.auth.Come back again!'));


        return redirect($this->homeUrl());
    }

    /**
     * @return string
     */
    protected function homeUrl(): string
    {
        return \Route::has('home') ? route('home') : '/';
    }
}
