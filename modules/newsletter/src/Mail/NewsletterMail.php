<?php

namespace WezomCms\Newsletter\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Swift_Message;
use WezomCms\Newsletter\Models\Subscriber;

class NewsletterMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var Subscriber
     */
    public $notifiable;

    /**
     * @var string
     */
    public $subject;

    /**
     * @var string
     */
    public $text;

    /**
     * Create a new message instance.
     * @param  Subscriber  $notifiable
     * @param $subject
     * @param $text
     */
    public function __construct(Subscriber $notifiable, $subject, $text)
    {
        $this->notifiable = $notifiable;
        $this->subject = $subject;
        $this->text = $text;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $unsubscribeUrl = $this->notifiable->getUnsubscribeUrl();

        // Add List-Unsubscribe header.
        $this->withSwiftMessage(function (Swift_Message $message) use ($unsubscribeUrl) {
            $message->getHeaders()->addTextHeader('List-Unsubscribe', "<{$unsubscribeUrl}>");
        });

        return $this->subject($this->subject)
            ->markdown(
                'cms-newsletter::site.notifications.newsletter',
                ['unsubscribe' => $unsubscribeUrl, 'text' => $this->text]
            );
    }
}
