<?php

namespace WezomCms\Users\Http\Controllers\Site\Auth;

use Auth;
use Flash;
use Hash;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;
use Lang;
use NotifyMessage;
use Password;
use Str;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Users\Http\Requests\Auth\ResetPasswordRequest;
use WezomCms\Users\Models\User;

class ResetPasswordController extends SiteController
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
     * Display the password reset view for the given token.
     *
     * If no token is present, display the link request form.
     *
     * @param  Request  $request
     * @param  string|null  $token
     * @return ViewFactory|View
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('cms-users::site.auth.reset', ['token' => $token, 'email' => $request->get('email')]);
    }

    /**
     * Reset the given user's password.
     *
     * @param  ResetPasswordRequest  $request
     * @return JsonResponse|RedirectResponse|JsResponse
     */
    public function reset(ResetPasswordRequest $request)
    {
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()
            ->reset(
                $this->credentials($request),
                function ($user, $password) {
                    $this->resetPassword($user, $password);
                }
            );

        return $this->response($request, $response);
    }

    /**
     * Get the password reset credentials from the request.
     *
     * @param  Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only('email', 'password', 'password_confirmation', 'token');
        $credentials['active'] = true;

        return $credentials;
    }

    /**
     * Reset the given user's password.
     *
     * @param  CanResetPassword|User  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));

        $user->save();

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }


    /**
     * If the password was successfully reset, we will redirect the user back to
     * the application's home authenticated view. If there is an error we can
     * redirect them back to where they came from with their error message.
     *
     * @param  Request  $request
     * @param $response
     * @return RedirectResponse|Redirector|JsResponse
     */
    protected function response(Request $request, $response)
    {
        $messageKey = 'cms-users::site.auth.' . $response;

        if ($response == Password::PASSWORD_RESET) {
            if ($request->expectsJson()) {
                return JsResponse::make()
                    ->notification(NotifyMessage::make()->title(Lang::get($messageKey)))
                    ->redirect(route('cabinet'));
            } else {
                Flash::success(Lang::get($messageKey));

                return redirect(route('cabinet'));
            }
        } else {
            if ($request->expectsJson()) {
                return JsResponse::make()
                    ->success(false)
                    ->notification(Lang::get($messageKey), 'error');
            } else {
                Flash::error(Lang::get($messageKey));

                return redirect()->back()->withInput($request->only('email'));
            }
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
