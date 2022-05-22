<?php

namespace WezomCms\Newsletter\Http\Controllers\Site;

use Auth;
use Flash;
use NotifyMessage;
use WezomCms\Core\Foundation\JsResponse;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Newsletter\Http\Requests\Site\SubscribeRequest;
use WezomCms\Newsletter\Models\Subscriber;
use WezomCms\Newsletter\Notifications\Subscription;
use WezomCms\Newsletter\Notifications\Unsubscribe;

class NewsletterController extends SiteController
{
    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribe($token)
    {
        /** @var Subscriber $subscriber */
        $subscriber = Subscriber::whereToken($token)->firstOrFail();

        // Already unsubscribed.
        if (false === $subscriber->active) {
            Flash::push(
                NotifyMessage::info(
                    __('cms-newsletter::site.You are already unsubscribed')
                )->asToast(false)
            );

            return redirect()->route('home');
        }

        // Unsubscribe
        $subscriber->active = false;
        $subscriber->save();

        $subscriber->notify(new Unsubscribe());

        Flash::push(NotifyMessage::success(
            __('cms-newsletter::site.You have successfully unsubscribed from our newsletter')
        )->asToast(false));

        return redirect()->route('home');
    }
}
