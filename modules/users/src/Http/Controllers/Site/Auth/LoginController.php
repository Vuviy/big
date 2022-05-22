<?php

namespace WezomCms\Users\Http\Controllers\Site\Auth;

use Auth;
use Flash;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\RedirectsUsers;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Core\Http\Controllers\ThrottlesLogins;
use WezomCms\Users\Http\Requests\Auth\LoginRequest;
use WezomCms\Users\Models\User;

class LoginController extends SiteController
{
    use RedirectsUsers;
    use ThrottlesLogins;

    /**
     * @var string
     */
    protected $username = 'email';

    /**
     * LoginController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return ViewFactory|View
     */
    public function showLoginForm()
    {
        return view('cms-users::site.auth.popups.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  LoginRequest $request
     * @return JsonResponse|RedirectResponse|Response|void|JsResponse
     *
     * @throws ValidationException
     */
    public function login(LoginRequest $request)
    {
        $this->username = User::emailOrPhone($request->get('login'));

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            $this->sendLockoutResponse($request);
            return;
        }

        if ($this->attemptLogin($request)) {
            if ($redirectPath = $request->get('redirect')) {
                redirect()->setIntendedUrl($redirectPath);
            }

            $request->session()->regenerate();

            $this->clearLoginAttempts($request);

            return $this->authenticated($request, $this->guard()->user());
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        throw ValidationException::withMessages([
            $this->username() => [__('cms-users::site.auth.failed')],
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            [
                $this->username() => $request->get('login'),
                'password' => $request->get('password'),
                'active' => true,
            ],
            $request->filled('remember')
        );
    }

    /**
     * The user has been authenticated.
     *
     * @param  Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        Flash::success(__('cms-users::site.auth.You are successfully logged in'));

        $redirect = redirect()->intended(route('cabinet'));

        if ($request->expectsJson()) {
            return JsResponse::make()
                ->redirect($redirect->getTargetUrl());
        } else {
            return $redirect;
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    /**
     * Log the user out of the application.
     *
     * @param  Request  $request
     * @return RedirectResponse|Redirector
     */
    public function logout(Request $request)
    {
        $guard = $this->guard();

        $guard->logout();

        $request->session()->forget($guard->getName());

        Flash::info(__('cms-users::site.auth.Come back again!'));

        return \Route::has('home') ? redirect()->route('home') : redirect('/');
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  Request  $request
     * @return void
     *
     * @throws ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [__('cms-users::site.auth.throttle', ['seconds' => $seconds])],
        ])->status(429);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
