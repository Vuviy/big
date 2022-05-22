<?php

namespace WezomCms\Users\Http\Controllers\Site\Auth;

use Flash;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\RedirectsUsers;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Users\Http\Requests\Auth\VerifyPhoneRequest;
use WezomCms\Users\Models\User;

class VerificationController extends SiteController
{
    use RedirectsUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Show the email verification notice.
     *
     * @param  Request  $request
     * @return ViewFactory|RedirectResponse|Response|Redirector|View
     * @throws BindingResolutionException
     */
    public function show(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        switch ($request->user()->registered_through) {
            case User::PHONE:
                return $this->phoneVerificationForm($request);
            case User::EMAIL:
                return $this->emailVerificationForm($request);
            default:
                $request->user()->markEmailAsVerified();

                return redirect($this->redirectPath());
        }
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param  Request  $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function verify(Request $request)
    {
        if ($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException();
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        Flash::success(__('cms-users::site.auth.You have successfully confirmed your email'));

        return redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * Mark the authenticated user's phone as verified.
     *
     * @param  VerifyPhoneRequest  $request
     * @return RedirectResponse|JsResponse
     */
    public function verifyPhone(VerifyPhoneRequest $request)
    {
        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($request->expectsJson()) {
            return JsResponse::make()
                ->notification(__('cms-users::site.auth.You have successfully confirmed your phone'))
                ->redirect($this->redirectPath());
        }

        Flash::success(__('cms-users::site.auth.You have successfully confirmed your phone'));

        return redirect($this->redirectPath())->with('verified', true);
    }

    /**
     * Resend the account verification notification.
     *
     * @param  Request  $request
     * @return RedirectResponse|Redirector
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();

        if ($request->user()->registered_through === User::PHONE) {
            Flash::info(__('cms-users::site.auth.A fresh verification code has been sent to your phone'));
        } else {
            Flash::info(__('cms-users::site.auth.A fresh verification link has been sent to your email address'));
        }

        return back();
    }

    /**
     * @param  Request  $request
     * @return ViewFactory|RedirectResponse|Redirector|View
     * @throws BindingResolutionException
     */
    protected function phoneVerificationForm(Request $request)
    {
        if ($request->user()->phone === null || $request->user()->temporary_code === null) {
            $request->user()->markEmailAsVerified();

            return redirect($this->redirectPath());
        }

        $title = __('cms-users::site.auth.Phone confirmation');
        $this->addBreadcrumb($title);
        $this->seo()->setPageName($title);

        return view('cms-users::site.auth.verification.phone', [
            'formValidator' => \JsValidator::formRequest(VerifyPhoneRequest::class, '#verify-phone'),
        ]);
    }

    /**
     * @param  Request  $request
     * @return ViewFactory|RedirectResponse|Redirector|View
     */
    protected function emailVerificationForm(Request $request)
    {
        if ($request->user()->email === null) {
            $request->user()->markEmailAsVerified();

            return redirect($this->redirectPath());
        }

        $title = __('cms-users::site.auth.Email confirmation');
        $this->addBreadcrumb($title);
        $this->seo()->setPageName($title);

        return view('cms-users::site.auth.verification.email');
    }

    /**
     * Redirect to cabinet.
     *
     * @return string
     */
    public function redirectTo()
    {
        return route('cabinet');
    }
}
