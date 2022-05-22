<?php

namespace WezomCms\Catalog\Filter\Handlers;

use Illuminate\Support\Collection;
use WezomCms\Catalog\Filter\Contracts\FilterFormBuilder;
use WezomCms\Catalog\Filter\Contracts\FilterInterface;
use WezomCms\Catalog\Filter\Contracts\SelectedAttributesInterface;
use WezomCms\Catalog\Filter\Exceptions\IncorrectUrlParameterException;
use WezomCms\Catalog\Filter\SelectionHandlers\KeywordSearch;

class ProductFlagsHandler extends AbstractHandler implements SelectedAttributesInterface
{
    public const NAME = 'flag';

    public const NOVELTY = 'novelty';
    public const POPULAR = 'popular';
    public const SALE = 'sale';

    /**
     * Return array of all supported keys.
     *
     * @return array
     */
    public function supportedParameters(): array
    {
        return [static::NOVELTY, static::POPULAR, static::SALE];
    }

    /**
     * @return bool
     * @throws IncorrectUrlParameterException
     */
    public function validateParameters(): bool
    {
        $urlBuilder = $this->filter->getUrlBuilder();

        $validateKey = function ($key) use ($urlBuilder) {
            if ($urlBuilder->has($key)) {
                $value = (int) $urlBuilder->first($key);
                if ($value !== 1) {
                    throw new IncorrectUrlParameterException();
                }
            }
        };

        foreach ($this->supportedParameters() as $flag) {
            $validateKey($flag);
        }

        return true;
    }

    /**
     * @param $queryBuilder
     * @param  FilterInterface  $filter
     * @param  array  $criteria
     */
    public function filter($queryBuilder, FilterInterface $filter, array $criteria = [])
    {
        $urlBuilder = $filter->getUrlBuilder();

        $filterKey = function ($key) use ($urlBuilder, $queryBuilder) {
            if ($urlBuilder->has($key) || isset($criteria[$key])) {
                $queryBuilder->where($key, true);
            }
        };

        foreach ($this->supportedParameters() as $flag) {
            $filterKey($flag);
        }
    }

    /**
     * @param  FilterInterface  $filter
     * @return iterable
     */
    public function buildFormData(FilterInterface $filter): iterable
    {
        $urlBuilder = $filter->getUrlBuilder();
        $options = collect();

        /** @var Collection $rows */
        $rows = tap(
            $this->filter->getStorage()
                ->beginSelection(false)
                ->select('products.novelty', 'products.popular', 'products.sale'),
            function ($query) {
                $this->filter->applyOnlyHandlers(
                    $query,
                    [
                        KeywordSearch::class,
                        CategoryHandler::class,
                        CategoryWithSubCategoriesHandler::class
                    ]
                );
            }
        )->toBase()->get();

        $containsKey = function ($key) use ($urlBuilder, $rows, $options, $filter) {
            if ($rows->contains($key, 1)) {
                $selected = $urlBuilder->present($key, 1);
                $options->push([
                    'name' => __('cms-catalog::site.filter.' . ucfirst($key)),
                    'input_name' => $key,
                    'value' => 1,
                    'disabled' => $selected ? false : !$filter->hasResultByCriteria([$key => 1]),
                    'selected' => $selected,
                    'url' => $urlBuilder->autoBuild($key, 1),
                ]);
            }
        };

        foreach ($this->supportedParameters() as $flag) {
            $containsKey($flag);
        }

        if ($options->isEmpty()) {
            return [];
        }

        /**
         * @var $disabled Collection
         * @var $enabled Collection
         */
        list($disabled, $enabled) = $options->partition('disabled');

        return [
            [
                'type' => FilterFormBuilder::TYPE_CHECKBOX,
                'name' => static::NAME,
                'sort' => 15,
                'title' => __('cms-catalog::site.filter.Tags'),
                'options' => $enabled->merge($disabled)->values()->all(),
                'visible' => false
            ],
        ];
    }

    /**
     * Generate array with all selected values.
     *
     * @return array
     */
    public function selectedAttributes(): iterable
    {
        $result = [];

        $urlBuilder = $this->filter->getUrlBuilder();

        $addSelected = function ($key) use ($urlBuilder, &$result) {
            if ($urlBuilder->has($key) && $urlBuilder->get($key)) {
                $result[] = [
                    'group' => $key,
                    'name' => __('cms-catalog::site.filter.' . ucfirst($key)),
                    'removeUrl' => $urlBuilder->buildUrlWithout($key, 1),
                ];
            }
        };

        foreach ($this->supportedParameters() as $flag) {
            $addSelected($flag);
        }

        return $result;
    }
}
