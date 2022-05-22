<?php

namespace WezomCms\Favorites\Storage;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use WezomCms\Favorites\Contracts\Favorable;
use WezomCms\Favorites\Contracts\FavoritesStorageInterface;
use WezomCms\Favorites\Models\Favorite;
use WezomCms\Users\Models\User;

class DatabaseStorage extends AbstractStorage implements FavoritesStorageInterface
{
    /**
     * @var Collection|Favorable[]
     */
    protected $favorites;

    /**
     * @var Authenticatable|User
     */
    private $user;

    /**
     * @var int
     */
    protected $perPage;

    /**
     * DatabaseStorage constructor.
     *
     * @param  Authenticatable|User  $user
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;

        $this->favorites = collect($this->user->favorites()->with('favorable')->get())
            ->map(function (Favorite $favorite) {
                $favorable = $favorite->favorable;

                if (!$favorable || !$favorable instanceof Favorable) {
                    return false;
                }

                return $favorable;
            })
            ->filter();
    }

    /**
     * @return bool
     */
    public function hasNotSynced(): bool
    {
        return false;
    }

    protected function updateStorage()
    {
        $this->user->favorites()->delete();

        foreach ($this->favorites as $favorite) {
            $this->user->favorites()->create([
                'favorable_type' => $favorite->favorableType(),
                'favorable_id' => $favorite->favorableId(),
            ]);
        }
    }
}
