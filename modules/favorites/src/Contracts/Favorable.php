<?php

namespace WezomCms\Favorites\Contracts;

use Illuminate\Support\Collection;

/**
 * Interface Favorable
 *
 * @package WezomCms\Favorites\Contracts
 */
interface Favorable
{
    /**
     * @return bool
     */
    public function isFavorite(): bool;

    /**
     * @return int
     */
    public function favorableId(): int;

    /**
     * @return string
     */
    public function favorableType(): string;

    /**
     * @param  int  $id
     * @return Favorable|null
     */
    public function favorableInstance(int $id): ?Favorable;

    /**
     * @param $ids
     * @return Collection
     */
    public function favorableInstances($ids): Collection;

    /**
     * @return string
     */
    public function favorablePayload(): string;
}
