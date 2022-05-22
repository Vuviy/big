<?php

namespace WezomCms\Contacts\Http\Livewire;

use Auth;
use Livewire\Component;
use Notification;
use NotifyMessage;
use WezomCms\Contacts\Models\Contact;
use WezomCms\Contacts\Notifications\ContactNotification;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Models\Administrator;
use WezomCms\Core\Services\CheckForSpam;

class Form extends Component
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
    public $comment = '';

    public function mount()
    {
        $user = optional(Auth::user());

        $this->name = $user->full_name;
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
        return view('cms-contacts::site.livewire.form');
    }

    /**
     * @param CheckForSpam $checkForSpam
     */
    public function submit(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this, $this->email, $this->name)) {
            return;
        }

        $this->validate(...$this->rules());

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'message' => strip_tags($this->comment),
        ];

        try {
            $contact = Contact::create($data);
        } catch (\Throwable $e) {
            report($e);

            JsResponse::make()
                ->notification(
                    NotifyMessage::error(__('cms-core::site.Server error'))
                )
                ->emit($this);
            return;
        }

        $administrators = Administrator::toNotifications('contacts.edit')->get();
        Notification::send($administrators, new ContactNotification($contact));

        $this->reset(['name', 'email', 'comment']);

        JsResponse::make()
            ->modal(['content' => view('cms-ui::modals.response-info', [
                'text' => __('cms-contacts::site.Thank you for your request') . ' ' . __('cms-contacts::site.The site administration will answer you as soon as possible')
            ])->render()])
            ->emit($this);
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            [
                'name' => 'required|string|max:255',
                'email' => 'required|email:filter|max:255',
                'comment' => 'required|string|max:65535',
            ],
            [],
            [
                'name' => __('cms-contacts::site.Your name'),
                'email' => __('cms-contacts::site.Email'),
                'comment' => __('cms-contacts::site.Comment'),
            ]
        ];
    }
}
