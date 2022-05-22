<?php

namespace WezomCms\Users\Http\Livewire;

use Illuminate\Contracts\Auth\PasswordBroker;
use Lang;
use Livewire\Component;
use Password;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Services\CheckForSpam;

class ForgotPassword extends Component
{
    /**
     * @var string
     */
    public $email;

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
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updated($field)
    {
        call_user_func([$this, 'validateOnly'], $field, ...$this->rules());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        return view('cms-users::site.livewire.forgot-password');
    }

    /**
     * Form submit handler
     * @param  CheckForSpam  $checkForSpam
     */
    public function submit(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this)) {
            return;
        }

        $this->resetErrorBag();

        $this->validate(...$this->rules());

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink([
            'active' => true,
            'email' => $this->email,
        ]);

        if ($response == Password::RESET_LINK_SENT) {
            JsResponse::make()
                ->notification(__('cms-users::site.auth.To the specified email sent a link to reset your password'))
                ->modal('close')
                ->emit($this);
        } else {
            $this->addError('email', Lang::get('cms-users::site.auth.' . $response));
        }
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            ['email' => ['required', 'string', 'email:filter', 'exists:users,email']],
            [],
            ['email' => __('cms-users::site.cabinet.E-mail')]
        ];
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
