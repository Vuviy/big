<?php

namespace WezomCms\About\Http\Livewire;

use Auth;
use DB;
use Livewire\Component;
use Notification;
use NotifyMessage;
use WezomCms\About\Models\AboutReview;
use WezomCms\About\Notifications\AboutReviewNotification;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Models\Administrator;
use WezomCms\Core\Services\CheckForSpam;


class ReviewForm extends Component
{
    /**
     * @var string|null
     */
    public $name;

    /**
     * @var string|null
     */
    public $email;

    /**
     * @var string|null
     */
    public $text;

    /**
     * @var bool|null
     */
    public $notify = true;


    public function mount()
    {
        $user = optional(Auth::user());

        $this->name = $user->full_name;
        $this->email = $user->email;
    }

    public function render()
    {
        return view('cms-about::site.livewire.review-form');
    }

    /**
     * @param $field
     */
    public function updated($field)
    {
        call_user_func([$this, 'validateOnly'], $field, ...$this->rules());
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

        $this->validate(...$this->rules());

        try {
            DB::transaction(function () {
                /** @var AboutReview $aboutReview */
                $aboutReview = AboutReview::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'text' => $this->text,
                    'notify' => $this->notify,
                    'published' => false,
                ]);

                $administrators = Administrator::toNotifications('about-reviews.edit')->get();
                Notification::send($administrators, new AboutReviewNotification($aboutReview));

                $this->reset('text');

                JsResponse::make()
                    ->success(true)
                    ->modal(['content' => view('cms-ui::modals.response-info', [
                        'text' => __('cms-about::site.Your review for moderation thanks for your time')
                    ])->render()])
                    ->emit($this);
            });
        } catch (\Throwable $e) {
            report($e);

            JsResponse::make()
                ->success(false)
                ->notification(
                    NotifyMessage::error(__('cms-core::site.Server error'))
                )
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
                'name' => 'required|string|max:255',
                'email' => 'required|email:filter|max:255',
                'text' => 'required|string|max:65535',
                'notify' => 'nullable|bool'
            ],
            [],
            [
                'name' => __('cms-about::site.Your name'),
                'email' => __('cms-about::site.Email'),
                'text' => __('cms-about::site.Your feedback'),
            ]
        ];
    }
}
