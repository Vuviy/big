<?php

namespace WezomCms\Users\Http\Controllers\Site\Auth;

use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Users\Http\Requests\Auth\RegisterRequest;
use WezomCms\Users\Models\User;

class RegisterController extends SiteController
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return ViewFactory|View
     */
    public function showRegistrationForm()
    {
        return view('cms-users::site.auth.popups.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  RegisterRequest  $request
     * @return RedirectResponse|JsResponse
     */
    public function register(RegisterRequest $request)
    {
        event(new Registered($user = $this->create($request->all())));

        Auth::guard()->login($user);

        if ($request->expectsJson()) {
            return JsResponse::make()->redirect(route('cabinet'));
        } else {
            return redirect()->route('cabinet');
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $login = $data['login'];
        $loginField = User::emailOrPhone($login);

        return User::create([
            'name' => $data['username'],
            $loginField => $login,
            'registered_through' => $loginField,
            'active' => true,
            'password' => Hash::make($data['password']),
        ]);
    }
}
