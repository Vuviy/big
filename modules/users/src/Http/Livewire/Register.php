<?php

namespace WezomCms\Users\Http\Livewire;

use Auth;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\Users\Models\User;

class Register extends Component
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $redirect;

    public function mount()
    {
        $this->redirect = request()->input('params.redirect', route('cabinet'));
    }

    /**
     * @param $field
     * @throws ValidationException
     */
    public function updated($field)
    {
        call_user_func([$this, 'validateOnly'], $field, ...$this->rules());
    }

    /**
     * @return Factory|View
     */
    public function render()
    {
        return view('cms-users::site.livewire.register');
    }

    /**
     * Form submit handler
     * @param  CheckForSpam  $checkForSpam
     */
    public function submit(CheckForSpam $checkForSpam, Request $request)
    {
        if (!$checkForSpam->checkInComponent($this)) {
            return;
        }

        if ($this->guard()->check()) {
            $this->redirect(route('cabinet'));

            return;
        }

        $user = $this->create($this->validate(...$this->rules()));

        $this->guard()->login($user);

        event(new Registered($user));

        JsResponse::make()
            ->modal(['component' => 'users.email-confirmation'])
            ->emit($this);
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            [
                'name' => ['required', 'string', 'max:255'],
                User::EMAIL => ['required', 'string', 'email:filter', 'unique:users,' . User::EMAIL],
                'password' => [
                    'required',
                    'string',
                    'min:' . config('cms.users.users.password_min_length'),
                    'max:' . config('cms.users.users.password_max_length'),
                ],
            ],
            [
            ],
            [
                'name' => __('cms-users::site.cabinet.Name'),
                User::EMAIL => __('cms-users::site.cabinet.E-mail'),
                'password' => __('cms-users::site.cabinet.Password'),
            ]
        ];
    }

    /**
     * Create a new user instance.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $userData = array_except($data, ['password']);
        $userData['password'] = Hash::make($data['password']);
        $userData['registered_through'] = User::EMAIL;
        $userData['active'] = true;

        return User::create($userData);
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
