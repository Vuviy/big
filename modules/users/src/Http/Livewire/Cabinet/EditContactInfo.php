<?php

namespace WezomCms\Users\Http\Livewire\Cabinet;

use Auth;
use Livewire\Component;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Rules\PhoneMask;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\Users\Dto\UserDto;
use WezomCms\Users\Services\UserService;
use WezomCms\Orders\Models\Communication;

class EditContactInfo extends Component
{
    public $phone;
    public $email;
    public $communication = [];
    public $user;
    public $communicationTypes = [];
    public $disabled = true;

    /**
     * @var UserService
     */
    protected $service;

    public function render()
    {
        $this->initialization();

        return view('cms-users::site.livewire.cabinet.edit-contact-info');
    }

    public function initialization()
    {
        if (!$this->phone) {
            $this->phone = $this->user->phone;
        }

        if (!$this->email) {
            $this->email = $this->user->email;
        }

        if (!$this->communication) {
            $this->communication = $this->user->selectedCommunications();
        }

        if (!$this->communicationTypes) {
            $this->communicationTypes = $this->user->communicationTypes();
        }
    }

    public function submit(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this)) {
            return;
        }

        $this->resetErrorBag();

        $this->validate(...$this->rules());

        try {
            $this->service->updateContactInfo($this->user, UserDto::dataRequest($this->getData()));

            $this->disabled = true;

            $response = JsResponse::make()
                ->success(true)
                ->notification(__('cms-core::site.Data saved'));

            $response->emit($this);
        } catch (\Throwable $exception) {
            JsResponse::make()
                ->success(false)
                ->notification(__('cms-core::site.Internal server error! Please try again later'), 'error')
                ->emit($this);
        }
    }

    public function getData() : array
    {
        return [
            'phone'         => $this->phone,
            'email'         => $this->email,
            'communication' => $this->communication
        ];
    }

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->service = resolve(UserService::class);
    }

    protected function rules(): array
    {
        return [
            [
                'email'         => 'required|string|email:filter|max:255|unique:users,email,' . Auth::user()->id,
                'phone'         => ['nullable', new PhoneMask(), 'unique:users,phone,' . Auth::user()->id],
                'communication' => 'nullable'
            ],
            [
                'email.unique' => __('cms-users::site.auth.User with provided email already exists'),
                'phone.unique' => __('cms-users::site.auth.User with provided phone already exists'),
            ],
            [
                'email'         => __('cms-users::site.cabinet.E-mail'),
                'phone'         => __('cms-users::site.cabinet.Phone'),
                'communication' => __('cms-users::site.cabinet.Удобный способ связи')
            ]
        ];
    }

    /**
     * Validate only updated field.
     *
     * @param $field
     */
    public function updated($field)
    {
        $this->disabled = false;
        call_user_func([$this, 'validateOnly'], $field, ...$this->rules());
    }
}
