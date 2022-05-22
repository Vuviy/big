<?php

namespace WezomCms\Users\Http\Livewire\Cabinet;

use Livewire\Component;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\Users\Dto\UserDto;
use WezomCms\Users\Services\UserService;

class EditPersonalInfo extends Component
{
    public $user;
    public $name;
    public $surname;
    public $birthday;
    public $disabled = true;

    /**
     * @var UserService
     */
    protected $service;

    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->service = resolve(UserService::class);
    }

    public function render()
    {
        $this->initialization();

        return view('cms-users::site.livewire.cabinet.edit-personal-info');
    }

    public function submit(CheckForSpam $checkForSpam)
    {
        if (!$checkForSpam->checkInComponent($this)) {
            return;
        }

        $this->resetErrorBag();

        $this->validate(...$this->rules());

        try {
            $this->service->updatePersonalInfo($this->user, UserDto::dataRequest($this->getData()));

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
            'name'     => $this->name,
            'surname'  => $this->surname,
            'birthday' => $this->birthday,
        ];
    }

    public function initialization(): void
    {
        if (!$this->name) {
            $this->name = $this->user->name;
        }

        if (!$this->surname) {
            $this->surname = $this->user->surname;
        }

        if (!$this->birthday) {
            $this->birthday = $this->user->birthday ? $this->user->birthday->format('d.m.Y') : null;
        }
    }

    protected function rules(): array
    {
        return [
            [
                'name' => 'required|string|max:100',
                'surname' => 'required|string|max:100',
                'birthday' => 'required|date|before:today|date_format:d.m.Y',
            ],
            [],
            [
                'name' => __('cms-users::site.cabinet.Name'),
                'surname' => __('cms-users::site.cabinet.Surname'),
                'birthday' => __('cms-users::site.cabinet.Birthday date'),
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
