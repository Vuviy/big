<?php

namespace WezomCms\Newsletter\Storage;

use Cookie;
use Illuminate\Support\Str;
use WezomCms\Newsletter\Contracts\SubscriptionStorageInterface;

class SubscriptionCookieStorage implements SubscriptionStorageInterface
{
    public static function generateHash(): string
    {
        return sha1(microtime() . Str::random());
    }

    public static function getHashFromCookie(): ?string
    {
        return Cookie::get(static::COOKIE_KEY);
    }

    public static function setHashToCookie(string $hash): void
    {
        Cookie::queue(Cookie::make(static::COOKIE_KEY, $hash, static::COOKIE_LIFE_TIME, '/'));
    }
}
