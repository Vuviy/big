<?php

namespace WezomCms\Users\Http\Livewire;

use Auth;
use Hash;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\Users\Models\User;

/**
 * Class ChangePassword
 * @package WezomCms\Users\Http\Livewire
 * @property User|Authenticatable $user
 */
class ChangePassword extends Component
{
    /**
     * @var string|null
     */
    public $oldPassword;

    /**
     * @var string|null
     */
    public $password;

    /**
     * @var string|null
     */
    public $password_confirmation;

    public $passwordMinLength;

    public function mount()
    {
        $this->passwordMinLength = config('cms.users.users.password_min_length');
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view('cms-users::site.livewire.change-password');
    }

    /**
     * @param  CheckForSpam  $checkForSpam
     * @throws ValidationException
     */
    public function submit(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this)) {
            return;
        }

        $this->validate(...$this->rules());

        if (!password_verify($this->oldPassword, $this->user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'oldPassword' => [__('cms-users::site.cabinet.Password is entered incorrectly')],
            ]);
        }

        $this->user->update(['password' => Hash::make($this->password)]);

        $this->reset();

        JsResponse::make()
            ->notification(__('cms-users::site.cabinet.Password successfully changed'))
            ->modal('close')
            ->emit($this);
    }

    /**
     * @param $field
     */
    public function updated($field)
    {
        call_user_func([$this, 'validateOnly'], $field, ...$this->rules());
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            [
                'oldPassword' => "required|string|min:{$this->passwordMinLength}|max:255",
                'password' => "required|string|min:{$this->passwordMinLength}|max:255|different:oldPassword",
                'password_confirmation' => ['required', 'string', 'same:password'],
            ],
            [
                'password.different' => __('cms-users::site.cabinet.New password must be different from the old one'),
            ],
            [
                'oldPassword' => __('cms-users::site.cabinet.Current password'),
                'password' => __('cms-users::site.cabinet.New password'),
                'password_confirmation' => __('cms-users::site.cabinet.Repeat new password'),
            ]
        ];
    }

    /**
     * @return User|Authenticatable
     */
    public function getUserProperty(): User
    {
        if (!Auth::check()) {
            abort(404);
        }

        return Auth::user();
    }
}
