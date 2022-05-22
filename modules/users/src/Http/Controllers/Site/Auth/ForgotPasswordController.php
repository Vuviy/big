<?php

namespace WezomCms\Users\Http\Controllers\Site\Auth;

use Flash;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Lang;
use Password;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Users\Http\Requests\Auth\SendResetLinkRequest;
use WezomCms\Users\Models\User;

class ForgotPasswordController extends SiteController
{
    /**
     * Display the form to request a password reset link.
     *
     * @return Factory|View
     */
    public function showPopup()
    {
        return view('cms-users::site.auth.popups.restore-password');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  SendResetLinkRequest  $request
     * @return RedirectResponse|JsonResponse
     */
    public function sendResetLink(SendResetLinkRequest $request)
    {
        if (User::emailOrPhone($request->get('login')) === User::EMAIL) {
            return $this->sendEmailWithResetLink($request);
        } else {
            return $this->sendSmsWithResetCode($request);
        }
    }

    /**
     * @param  SendResetLinkRequest  $request
     * @return RedirectResponse|JsResponse
     */
    protected function sendEmailWithResetLink(SendResetLinkRequest $request)
    {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink([
            'active' => true,
            'email' => $request->get('login'),
        ]);

        if ($response == Password::RESET_LINK_SENT) {
            $message = __('cms-users::site.auth.To the specified email sent a link to reset your password');
            if ($request->expectsJson()) {
                return JsResponse::make()->notification($message, 'info');
            }

            Flash::info($message);

            return back();
        } else {
            if ($request->expectsJson()) {
                return JsResponse::make()
                    ->success(false)
                    ->notification(Lang::get('cms-users::site.auth.' . $response), 'error');
            } else {
                Flash::error(Lang::get('cms-users::site.auth.' . $response));

                return back()->withInput($request->only('login'));
            }
        }
    }

    /**
     * @param  SendResetLinkRequest  $request
     * @return JsonResponse|RedirectResponse|JsResponse
     */
    protected function sendSmsWithResetCode(SendResetLinkRequest $request)
    {
        /** @var User $user */
        $user = $this->broker()->getUser([
            'active' => true,
            'phone' => $request->get('login'),
        ]);

        if ($user) {
            $error = $user->sendPasswordResetByCodeNotification()
                ? null
                : __('cms-users::site.auth.An error occurred while sending a message Please contact the site administration');
        } else {
            $error = __('cms-users::site.auth.User not found');
        }

        if ($error) {
            if ($request->expectsJson()) {
                return JsResponse::make()
                    ->success(false)
                    ->notification(Lang::get($error), 'error');
            } else {
                Flash::error(Lang::get($error));

                return back()->withInput($request->only('login'));
            }
        } else {
            $message = __('cms-users::site.auth.To the specified phone sent a code to reset your password');
            if ($request->expectsJson()) {
                return JsResponse::make()
                    ->notification($message, 'info')
                    ->magnific(['url' => route('auth.password.reset-by-code-form', $user->id)]);
            }

            Flash::info($message);

            return redirect(route('auth.password.reset-by-code-form', $user->id));
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }
}
