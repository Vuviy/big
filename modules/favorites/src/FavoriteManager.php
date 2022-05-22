<?php

namespace WezomCms\Favorites;

use Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Manager;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Favorites\Contracts\Favorable;
use WezomCms\Favorites\Storage\CookieStorage;
use WezomCms\Favorites\Storage\DatabaseStorage;
use WezomCms\Users\UsersServiceProvider;

class FavoriteManager extends Manager
{
    /**
     * @param  Favorable  $favorable
     * @return string
     */
    public function encryptPayload(Favorable $favorable): string
    {
        return base64_encode(json_encode(['type' => $favorable->favorableType(), 'id' => $favorable->favorableId()]));
    }

    /**
     * @param  string  $payload
     * @return Favorable|null
     */
    public function decryptPayload(string $payload): ?Favorable
    {
        $data = json_decode(base64_decode($payload), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        $class = array_get($data, 'type');
        $id = array_get($data, 'id');

        if (!$class || !$id) {
            return null;
        }

        $object = new $class();
        if (!$object instanceof Favorable) {
            return null;
        }

        return $object->favorableInstance($id);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        if (
            Helpers::providerLoaded(UsersServiceProvider::class)
            && ($user = $this->guard()->user())
            && (!$user instanceof MustVerifyEmail || $user->hasVerifiedEmail())
        ) {
            return 'database';
        }

        return 'cookie';
    }

    /**
     * Create an instance of the DatabaseStorage Driver.
     *
     * @return DatabaseStorage
     */
    public function createDatabaseDriver()
    {
        if (!$user = $this->guard()->user()) {
            throw new \LogicException('Cannot use "database" storage without an authorized user');
        }

        return new DatabaseStorage($user);
    }

    /**
     * Create an instance of the CookieStorage Driver.
     *
     * @return CookieStorage
     */
    public function createCookieDriver()
    {
        return new CookieStorage();
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }
}
