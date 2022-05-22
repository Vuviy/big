<?php

namespace WezomCms\Catalog\Filter\Handlers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use WezomCms\Catalog\Filter\Contracts\FilterFormBuilder;
use WezomCms\Catalog\Filter\Contracts\FilterInterface;
use WezomCms\Catalog\Filter\Contracts\SelectedAttributesInterface;
use WezomCms\Catalog\Filter\Exceptions\IncorrectUrlParameterException;
use WezomCms\Catalog\Filter\SelectionHandlers\KeywordSearch;

class ProductLabelsHandler extends AbstractHandler implements SelectedAttributesInterface
{
    public $inList = false;

    public const NAME = 'label';

    /**
     * Return array of all supported keys.
     *
     * @return array
     */
    public function supportedParameters(): array
    {
        return [static::NAME];
    }

    public function validateParameters(): bool
    {
        $urlBuilder = $this->filter->getUrlBuilder();

        if (!$urlBuilder->has(static::NAME)) {
            return true;
        }

        $slugs = $urlBuilder->get(static::NAME, []);
        if (empty($slugs)) {
            throw new IncorrectUrlParameterException();
        }

        // Check for existence
        if (count($slugs) !== $this->selected()->count()) {
            throw new IncorrectUrlParameterException();
        }

        return true;
    }

    /**
     * @param Builder $queryBuilder
     * @param  FilterInterface  $filter
     * @param  array  $criteria
     * @throws \Exception
     */
    public function filter($queryBuilder, FilterInterface $filter, array $criteria = [])
    {
        $urlBuilder = $filter->getUrlBuilder();

        $ids = [];
        if (isset($criteria[static::NAME])) {
            $ids = $criteria[static::NAME];
        } elseif ($urlBuilder->has(static::NAME)) {
            $ids = $this->selected()->pluck('id')->toArray();
        }
        if (!empty($ids)) {
            $queryBuilder->join('product_product_label', 'product_product_label.product_id', '=', 'products.id');
            $queryBuilder->whereIn('product_product_label.product_label_id', $ids);
        }
    }

    /**
     * @param  FilterInterface  $filter
     * @return iterable
     */
    public function buildFormData(FilterInterface $filter): iterable
    {
        $ids = tap($filter->getStorage()->beginSelection(false), function ($query) use ($filter) {
            $filter->applyOnlyHandlers(
                $query,
                [
                    // SearchController
                    KeywordSearch::class,
                    // CategoryController
                    CategoryWithSubCategoriesHandler::class,
                    // Collection controller
                    CategoryHandler::class,
                ]
            );
        })
            ->join('product_product_label', 'product_product_label.product_id', '=', 'products.id')
            ->select('product_product_label.product_label_id')
            ->distinct()
            ->pluck('product_product_label.product_label_id')
            ->filter();

        $labels = ProductLabel::published()
            ->whereIn('product_labels.id', $ids->toArray())
            ->where('published',1)
            ->orderByTranslation('name')
            ->get();

        if ($labels->isEmpty()) {
            return [];
        }

        $options = collect();
        $urlBuilder = $this->filter->getUrlBuilder();
        foreach ($labels as $label) {
            $selected = $urlBuilder->present(static::NAME, $label->slug);
            $options->push([
                'name' => $label->name,
                'id' => $label->id,
                'value' => $label->slug,
                'type' => $label->type,
                'selected' => $selected,
                'disabled' => $selected ? false : !$filter->hasResultByCriteria([static::NAME => [$label->id]]),
                'url' => $urlBuilder->autoBuild(static::NAME, $label->slug),
            ]);
        }

        /**
         * @var $disabled Collection
         * @var $enabled Collection
         */
        list($disabled, $enabled) = $options->partition('disabled');

        return [
            static::NAME => [
                'type' => FilterFormBuilder::TYPE_CHECKBOX,
                'search_placeholder' => __('cms-catalog::site.products.Search by label'),
                'name' => static::NAME,
                'sort' => 2,
                'title' => __('cms-catalog::site.products.Label'),
                'options' => $enabled->merge($disabled)->values()->all(),
                'visible' => false
            ],
        ];
    }

    /**
     * @return array|Collection|mixed
     */
    private function selected()
    {
        return \Cache::driver('array')->rememberForever(__CLASS__ . '-' . __METHOD__, function () {
            $slugs = $this->filter->getUrlBuilder()->get(static::NAME, []);

            if ($slugs) {
                return ProductLabel::select('id')
                    ->published()
                    ->whereHas('translation', function ($query) use ($slugs) {
                        $query->whereIn('slug', $slugs);
                    })
                    ->get();
            }

            return collect();
        });
    }

    /**
     * Generate array with all selected values.
     *
     * @return array
     */
    public function selectedAttributes(): iterable
    {
        $urlBuilder = $this->filter->getUrlBuilder();

        return $this->selected()->map(function ($item) use ($urlBuilder) {
            return [
                'group' => static::NAME,
                'name' => $item->name,
                'removeUrl' => $urlBuilder->buildUrlWithout(static::NAME, $item->slug),
            ];
        });
    }
}
