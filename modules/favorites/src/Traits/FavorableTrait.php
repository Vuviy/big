<?php

namespace WezomCms\Favorites\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use WezomCms\Favorites\Contracts\Favorable;

/**
 * Trait FavorableTrait
 *
 * @package WezomCms\Favorites\Traits
 * @mixin Model
 */
trait FavorableTrait
{
    /**
     * @return bool
     */
    public function isFavorite(): bool
    {
        return app('favorites')->contains($this);
    }

    /**
     * @return int
     */
    public function favorableId(): int
    {
        return $this->getKey();
    }

    /**
     * @return string
     */
    public function favorableType(): string
    {
        return get_class($this);
    }

    /**
     * @param  int  $id
     * @return Favorable|null
     */
    public function favorableInstance(int $id): ?Favorable
    {
        return static::query()
            ->when(method_exists($this, 'published'), function ($query) {
                $query->published();
            })->find($id);
    }

    /**
     * @param $ids
     * @return Collection
     */
    public function favorableInstances($ids): Collection
    {
        return static::query()
            ->whereKey($ids)
            ->when(method_exists($this, 'published'), function ($query) {
                $query->published();
            })->get();
    }

    /**
     * @return string
     */
    public function favorablePayload(): string
    {
        return app('favorites')->encryptPayload($this);
    }
}
