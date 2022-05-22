<?php

namespace WezomCms\ProductReviews\Http\Livewire;

use Auth;
use DB;
use Event;
use Livewire\Component;
use Notification;
use NotifyMessage;
use WezomCms\Catalog\Models\Product;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Models\Administrator;
use WezomCms\Core\Services\CheckForSpam;
use WezomCms\Pages\Models\Page;
use WezomCms\ProductReviews\Enums\Ratings;
use WezomCms\ProductReviews\Models\ProductReview;
use WezomCms\ProductReviews\Notifications\ProductReviewNotification;

/**
 * Class Form
 * @package WezomCms\ProductReviews\Http\Livewire
 * @property-read ProductReview|null $replyToReview
 */
class Form extends Component
{
    /**
     * @var int
     */
    public $productId;

    /**
     * @var int|null
     */
    public $answerTo;

    /**
     * @var int
     */
    public $rating = 5;

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
    public $notify = false;

    /**
     * @param $id
     * @param  int|null  $answerTo
     */
    public function mount($productId, $answerTo = null)
    {
        Product::published()->findOrFail($productId);

        $this->answerTo = $answerTo;

        $user = optional(Auth::user());

        $this->name = $user->full_name;
        $this->email = $user->email;
    }

    public function render()
    {
        return view('cms-product-reviews::site.livewire.form', [
            'ratings' => Ratings::asSelectArray(),
            'ratingText' => Ratings::getDescription($this->rating),
            'replyToReview' => $this->replyToReview,
        ]);
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
                /** @var ProductReview $productReview */
                $productReview = ProductReview::make([
                    'product_id' => $this->productId,
                    'name' => $this->name,
                    'email' => $this->email,
                    'text' => $this->text,
                    'rating' => $this->rating,
                    'notify' => $this->notify,
                ]);

                if ($this->replyToReview) {
                    $productReview->parent()->associate($this->replyToReview);
                }

                if (Auth::check()) {
                    $productReview->user()->associate(Auth::user()->getAuthIdentifier());
                }

                $productReview->save();

                Event::dispatch('created_product_review', $productReview);

                $administrators = Administrator::toNotifications('product-reviews.edit')->get();
                Notification::send($administrators, new ProductReviewNotification($productReview));

                $this->reset('text', 'rating');

                JsResponse::make()
                    ->success(true)
                    ->modal(['content' => view('cms-ui::modals.response-info', [
                        'text' => __('cms-product-reviews::site.Your review for moderation thanks for your time')
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
     * @return ProductReview|null
     */
    public function getReplyToReviewProperty(): ?ProductReview
    {
        return $this->answerTo
            ? ProductReview::published()->whereProductId($this->productId)->find($this->answerTo)
            : null;
    }

    /**
     * @return array
     */
    protected function rules(): array
    {
        return [
            [
                'rating' => [$this->replyToReview ? 'nullable' : 'required', 'int', 'min:1', 'max:5'],
                'name' => 'required|string|max:255',
                'email' => 'required|email:filter|max:255',
                'text' => 'required|string|max:65535',
                'notify' => 'nullable|bool'
            ],
            [],
            [
                'rating' => __('cms-product-reviews::site.Rating'),
                'name' => __('cms-product-reviews::site.Name'),
                'email' => __('cms-product-reviews::site.E-mail'),
                'text' => __('cms-product-reviews::site.Text'),
            ]
        ];
    }
}
