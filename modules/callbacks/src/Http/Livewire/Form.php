<?php

namespace WezomCms\Callbacks\Http\Livewire;

use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Livewire\Component;
use Notification;
use WezomCms\Callbacks\Models\Callback;
use WezomCms\Callbacks\Notifications\CallbackNotification;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Models\Administrator;
use WezomCms\Core\Rules\PhoneMask;
use WezomCms\Core\Services\CheckForSpam;

class Form extends Component
{
    /**
     * @var string|null
     */
    public $phone;

    public function mount()
    {
        $user = optional(Auth::user());

        $this->phone = $user->masked_phone;
    }

    /**
     * @return Application|Factory|View
     */
    public function render()
    {
        $settings = settings('contacts', []);

        return view('cms-callbacks::site.livewire.form', compact('settings'));
    }

    /**
     * Validate only updated field.
     *
     * @param $field
     */
    public function updated($field)
    {
        call_user_func([$this, 'validateOnly'], $field, ...$this->rules());
    }

    /**
     * Form submit handler
     * @param CheckForSpam $checkForSpam
     */
    public function submit(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this)) {
            return;
        }

        $this->validate(...$this->rules());

        $callback = new Callback([
            'phone' => remove_phone_mask($this->phone),
        ]);

        if ($callback->save()) {
            $administrators = Administrator::toNotifications('callbacks.edit')->get();
            Notification::send($administrators, new CallbackNotification($callback));

            $this->reset();

            JsResponse::make()
                ->modal(['content' => view('cms-ui::modals.response-info', [
                    'text' => __('cms-callbacks::site.Form successfully submitted!')
                ])->render()])
                ->emit($this);
        } else {
            JsResponse::make()
                ->success(false)
                ->notification(__('cms-callbacks::site.Error creating request!'), 'error')
                ->emit($this);
        }
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            [
                'phone' => ['required', new PhoneMask()]
            ],
            [],
            [
                'phone' => __('cms-callbacks::site.Phone'),
            ]
        ];
    }
}
