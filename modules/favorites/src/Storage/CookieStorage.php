<?php

namespace WezomCms\Favorites\Storage;

use Cookie;
use Illuminate\Support\Collection;
use WezomCms\Favorites\Contracts\Favorable;
use WezomCms\Favorites\Contracts\FavoritesStorageInterface;

class CookieStorage extends AbstractStorage implements FavoritesStorageInterface
{
    protected const KEY = 'favorites';
    protected const LIFE_TIME = 525600;

    /**
     * CookieStorage constructor.
     */
    public function __construct()
    {
        $this->favorites = collect(json_decode(base64_decode(Cookie::get(static::KEY, '[]')), true))
            ->filter(function ($favorite) {
                return array_get($favorite, 'type') && array_get($favorite, 'id');
            })
            ->mapToGroups(function (array $favorite) {
                return [array_get($favorite, 'type') => array_get($favorite, 'id')];
            })
            ->filter(function (Collection $ids, string $class) {
                return $ids->isNotEmpty() && in_array(Favorable::class, class_implements($class));
            })->map(function (Collection $ids, string $class) {
                return (new $class())->favorableInstances($ids)
                    ->sortBy(function (Favorable $favorite) use ($ids) {
                        return $ids->search($favorite->favorableId());
                    });
            })->flatten();
    }

    /**
     * @return bool
     */
    public function hasNotSynced(): bool
    {
        return $this->favorites->isNotEmpty();
    }

    protected function updateStorage()
    {
        $favorites = $this->favorites->map(function (Favorable $favorite) {
            return [
                'type' => $favorite->favorableType(),
                'id' => $favorite->favorableId(),
            ];
        })->toJson();

        Cookie::queue(Cookie::make(static::KEY, base64_encode($favorites), static::LIFE_TIME));
    }
}
