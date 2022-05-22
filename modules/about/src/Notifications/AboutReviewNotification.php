<?php

namespace WezomCms\About\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use WezomCms\About\Models\AboutReview;

class AboutReviewNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var AboutReview
     */
    private $review;

    /**
     * Create a new notification instance.
     */
    public function __construct(AboutReview $review)
    {
        $this->review = $review;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $review = $this->review;

        return [
            'route_name' => 'admin.about-reviews.edit',
            'route_params' => $review->id,
            'icon' => 'fa-comments',
            'color' => 'warning',
            'heading' => __('cms-about::admin.Feedback about company'),
            'description' => __('cms-about::admin.New message from the contact form')
        ];
    }
}
