<?php

namespace WezomCms\Newsletter\Contracts;

interface SubscriptionStorageInterface
{
    public const COOKIE_KEY = 'newsletter-subscription';
    public const COOKIE_LIFE_TIME = 525600; // 1 year

    public static function generateHash(): string;

    public static function getHashFromCookie(): ?string;

    public static function setHashToCookie(string $hash): void;
}
