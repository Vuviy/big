<?php

namespace WezomCms\Newsletter\Http\Livewire;

use Auth;
use Livewire\Component;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\Newsletter\Models\Subscriber;
use WezomCms\Newsletter\Notifications\Subscription;
use WezomCms\Newsletter\Services\UserSubscription;
use WezomCms\Users\Models\User;

class Subscribe extends Component
{
    /**
     * @var string
     */
    public $email;

    protected $listeners = ['$refresh'];

    public function mount()
    {
        $email = optional(Auth::user())->email;

        $this->email = $email && !Subscriber::active()->whereEmail($email)->doesntExist() ? $email : '';
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
        $isCurrentClientSubscribed = UserSubscription::isCurrentClientSubscribed();

        return view('cms-newsletter::site.livewire.subscribe', compact('isCurrentClientSubscribed'));
    }

    /**
     * @param CheckForSpam $checkForSpam
     */
    public function submit(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this, $this->email)) {
            return;
        }

        $this->validate(...$this->rules());

        /** @var User|null $user */
        $user = Auth::user();

        /** @var Subscriber $subscriber */
        $subscriber = Subscriber::whereEmail($this->email)->first();

        if ($subscriber) {
            UserSubscription::updateCurrentClientSubscription($subscriber);
        } else {
            $subscriber = UserSubscription::createSubscription($this->email, (optional($user)->email === $this->email) ? $user->id : null);
            $subscriber->notify(new Subscription());
        }

        JsResponse::make()
            ->modal(['content' => view('cms-ui::modals.response-info', [
                'text' => __('cms-newsletter::site.Thank you for subscribe!')
            ])->render()])
            ->emit($this);

        $this->emitSelf('$refresh');
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            [
                'email' => 'required|email:filter|max:80',
            ],
            [],
            [
                'email' => __('cms-newsletter::site.Email'),
            ]
        ];
    }
}
