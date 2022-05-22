<?php

namespace WezomCms\Catalog\Traits;

use Illuminate\Support\Collection as SupportCollection;
use WezomCms\Catalog\Models\Product;

/**
 * Trait ProductFlagsTrait
 * @package WezomCms\Catalog\Traits
 * @mixin Product
 */
trait ProductFlagsTrait
{

    /**
     * @return bool
     */
    public function getHasFlagAttribute(): bool
    {
        return $this->novelty || $this->sale || $this->popular;
    }

    /**
     * @return string
     */
    public function getFlagColorAttribute(): string
    {
        if ($this->sale) {
            return 'sale';
        }

        if ($this->popular) {
            return 'popular';
        }

        if ($this->novelty) {
            return 'novelty';
        }

        return '';
    }

    /**
     * @return string
     */
    public function getFlagTextAttribute(): string
    {
        if ($this->sale) {
            return __('cms-catalog::site.flags.Sale');
        }
        if ($this->novelty) {
            return __('cms-catalog::site.flags.Novelty');
        }
        if ($this->popular) {
            return __('cms-catalog::site.flags.Popular');
        }

        return '';
    }

    /**
     * @return SupportCollection
     */
    public function getFlagsAttribute(): SupportCollection
    {
        $result = collect();

        if ($this->sale) {
            $result->put('sale', ['color' => 'sale', 'text' => __('cms-catalog::site.flags.Sale')]);
        }
        if ($this->novelty) {
            $result->put('novelty', ['color' => 'novelty', 'text' => __('cms-catalog::site.flags.Novelty')]);
        }
        if ($this->popular) {
            $result->put('popular', ['color' => 'popular', 'text' => __('cms-catalog::site.flags.Popular')]);
        }

        return $result;
    }
}
