<?php

namespace WezomCms\Favorites\Storage;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use WezomCms\Favorites\Contracts\Favorable;
use WezomCms\Favorites\Contracts\FavoritesStorageInterface;

abstract class AbstractStorage
{
    /**
     * @var Collection
     */
    protected $favorites;

    /**
     * @param  Favorable  $favorable
     * @return bool
     */
    public function contains(Favorable $favorable): bool
    {
        return $this->favorites->filter(function (Favorable $favorite) use ($favorable) {
            return $favorite->favorableType() === $favorable->favorableType()
                && $favorite->favorableId() === $favorable->favorableId();
        })->isNotEmpty();
    }

    /**
     * @param  Favorable  $favorable
     * @return FavoritesStorageInterface|static
     */
    public function add(Favorable $favorable): FavoritesStorageInterface
    {
        if (!$this->contains($favorable)) {
            $this->favorites->push($favorable);
        }

        $this->updateStorage();

        return $this;
    }

    /**
     * @param  Favorable  $favorable
     * @return FavoritesStorageInterface|static
     */
    public function remove(Favorable $favorable): FavoritesStorageInterface
    {
        $this->favorites = $this->favorites->filter(function (Favorable $favorite) use ($favorable) {
            return !($favorite->favorableType() === $favorable->favorableType()
                && $favorite->favorableId() === $favorable->favorableId());
        });

        $this->updateStorage();

        return $this;
    }

    /**
     * @param  int  $perPage
     * @param  string|null  $type
     * @param  string  $pageName
     * @param  int|null  $page
     * @return LengthAwarePaginator|LengthAwarePaginatorContract|Favorable[]
     */
    public function paginate(int $perPage, ?string $type = null, $pageName = 'page', ?int $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $allFavorites = $this->getAll($type);

        return new LengthAwarePaginator(
            $allFavorites->forPage($page, $perPage),
            $allFavorites->count(),
            $perPage,
            $page
        );
    }

    /**
     * @param  string|null  $type
     * @return Collection|Favorable[]
     */
    public function getAll(?string $type = null)
    {
        if ($type) {
            return $this->favorites->filter(function (Favorable $favorite) use ($type) {
                return $favorite->favorableType() === $type;
            });
        }

        return $this->favorites;
    }

    /**
     * @param  string|null  $type
     * @return int
     */
    public function count(?string $type = null): int
    {
        if ($type) {
            return $this->favorites->filter(function (Favorable $favorite) use ($type) {
                return $favorite->favorableType() === $type;
            })->count();
        }

        return $this->favorites->count();
    }

    /**
     * @return FavoritesStorageInterface|static
     */
    public function clear(): FavoritesStorageInterface
    {
        $this->favorites = collect();

        $this->updateStorage();

        return $this;
    }

    abstract protected function updateStorage();
}
