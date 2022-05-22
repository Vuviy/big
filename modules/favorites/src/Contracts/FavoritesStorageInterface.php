<?php

namespace WezomCms\Favorites\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface FavoritesStorageInterface
{
    /**
     * @return bool
     */
    public function hasNotSynced(): bool;

    /**
     * @param  Favorable  $favorable
     * @return bool
     */
    public function contains(Favorable $favorable): bool;

    /**
     * @param  Favorable  $favorable
     * @return FavoritesStorageInterface
     */
    public function add(Favorable $favorable): FavoritesStorageInterface;

    /**
     * @param  Favorable  $favorable
     * @return FavoritesStorageInterface
     */
    public function remove(Favorable $favorable): FavoritesStorageInterface;

    /**
     * @param  string|null  $type
     * @return Collection|Favorable[]
     */
    public function getAll(?string $type = null);

    /**
     * @param  int  $perPage
     * @param  string|null  $type
     * @param  string  $pageName
     * @param  int|null  $page
     * @return LengthAwarePaginator|LengthAwarePaginatorContract|Favorable[]
     */
    public function paginate(int $perPage, ?string $type = null, $pageName = 'page', ?int $page = null);

    /**
     * @param  string|null  $type
     * @return int
     */
    public function count(?string $type = null): int;

    /**
     * @return FavoritesStorageInterface
     */
    public function clear(): FavoritesStorageInterface;
}
