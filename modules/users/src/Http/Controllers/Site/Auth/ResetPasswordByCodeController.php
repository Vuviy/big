<?php

namespace WezomCms\Users\Http\Controllers\Site\Auth;

use Auth;
use Flash;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Lang;
use NotifyMessage;
use Password;
use Str;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Users\Http\Requests\Auth\ResetPasswordByCodeRequest;
use WezomCms\Users\Models\User;

class ResetPasswordByCodeController extends SiteController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display the password reset view with the prompted code.
     *
     * @param  int  $id
     * @return ViewFactory|View
     */
    public function showResetForm($id)
    {
        return view('cms-users::site.auth.popups.reset-by-code', compact('id'));
    }

    /**
     * Reset the given user's password.
     *
     * @param  ResetPasswordByCodeRequest  $request
     * @return RedirectResponse|JsResponse
     */
    public function reset(ResetPasswordByCodeRequest $request)
    {
        $this->resetPassword(
            User::whereId($request->get('id'))->first(),
            $request->get('password')
        );

        return $this->sendResetResponse($request, Password::PASSWORD_RESET);
    }

    /**
     * Reset the given user's password.
     *
     * @param  User  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->temporary_code = null;

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Get the response for a successful password reset.
     *
     * @param  Request  $request
     * @param  string  $response
     * @return RedirectResponse|JsResponse
     */
    protected function sendResetResponse(Request $request, $response)
    {
        $response = 'cms-users::site.auth.code.' . $response;

        if ($request->expectsJson()) {
            return JsResponse::make()
                ->notification(NotifyMessage::make()->title(Lang::get($response)))
                ->redirect(route('cabinet'));
        } else {
            Flash::success(Lang::get($response));

            return redirect(route('cabinet'));
        }
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
