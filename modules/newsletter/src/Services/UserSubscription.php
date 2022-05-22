<?php

namespace WezomCms\Newsletter\Services;

use Illuminate\Contracts\Auth\Authenticatable;
use WezomCms\Newsletter\Models\Subscriber;
use WezomCms\Newsletter\Storage\SubscriptionCookieStorage;
use WezomCms\Users\Models\User;

class UserSubscription
{
    /**
     * @param  Authenticatable|User  $user
     * @param  bool  $createMissing
     */
    public static function updateOrCreate(Authenticatable $user, bool $createMissing = false)
    {
        $emailMatchingSubscriber = static::attachToUnoccupied($user);

        $userMatchingSubscriber = Subscriber::whereUserId($user->id)->first();

        if ($userMatchingSubscriber) {
            // User has changed email with subscription
            $userMatchingSubscriber->update(['user_id' => null]);
        }

        if (!$emailMatchingSubscriber && ($userMatchingSubscriber || $createMissing)) {
            static::createOrReplicate($user, $userMatchingSubscriber);
        }
    }

    /**
     * @param  Authenticatable|User  $user
     * @return Subscriber|null
     */
    public static function attachToUnoccupied(Authenticatable $user): ?Subscriber
    {
        $emailMatchingSubscriber = Subscriber::whereEmail($user->email)->first();
        if ($emailMatchingSubscriber && !$emailMatchingSubscriber->user_id) {
            // Attach user to existing subscription
            $emailMatchingSubscriber->update(['user_id' => $user->id]);
        }

        return $emailMatchingSubscriber;
    }

    public static function isCurrentClientSubscribed(): bool
    {
        if (!$hash = SubscriptionCookieStorage::getHashFromCookie()) {
            return false;
        }

        return Subscriber::where('token', $hash)->where('active', true)->exists();
    }

    /**
     * @param  string  $email
     * @param  int|null  $userId
     * @return Subscriber
     */
    public static function createSubscription(string $email, int $userId = null): Subscriber
    {
        $subscriber = Subscriber::create([
            'email' => $email,
            'user_id' => $userId,
            'ip' => app('request')->getClientIp(),
            'active' => true,
            'locale' => app()->getLocale(),
        ]);

        SubscriptionCookieStorage::setHashToCookie($subscriber->token);

        return $subscriber;
    }

    public static function updateCurrentClientSubscription(Subscriber $subscriber)
    {
        $subscriber->update([
            'ip' => app('request')->getClientIp(),
            'active' => true,
        ]);

        SubscriptionCookieStorage::setHashToCookie($subscriber->token);
    }

    /**
     * @param  Authenticatable|User  $user
     * @param  Subscriber|null  $subscriber
     */
    protected static function createOrReplicate(Authenticatable $user, Subscriber $subscriber = null)
    {
        if (!$subscriber) {
            static::make($user->email, $user->id)->save();
        } else {
            // Generate new subscriber so unsubscription from old email won't affect new one
            $subscriber->replicate(['email', 'active', 'token'])
                ->fill([
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'active' => true,
                ])
                ->save();
        }
    }
}
