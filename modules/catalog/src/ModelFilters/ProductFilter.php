<?php

namespace WezomCms\Catalog\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Http\Request;
use WezomCms\Catalog\Models\Brand;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Model;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Core\Contracts\Filter\FilterFieldInterface;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;

/**
 * Class ProductFilter
 * @package WezomCms\Catalog\ModelFilters
 */
class ProductFilter extends ModelFilter implements FilterListFieldsInterface
{
    protected $brands = [];
    protected $models = [];

    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        $result = [
            FilterField::id(),
            FilterField::makeName(),
        ];

        $optionsTree = view(
            'cms-catalog::admin.categories.categories-options',
            ['tree' => Category::getForSelect(), 'name' => 'category_id']
        );

        $result[] = FilterField::make()
            ->type(FilterField::TYPE_SELECT_WITH_CUSTOM_OPTIONS)
            ->customOptions($optionsTree)
            ->name('category_id')
            ->label(__('cms-catalog::admin.products.Category'))
            ->class('js-select2');

        $result[] = FilterField::make()
            ->type(FilterField::TYPE_RANGE)
            ->name('cost')
            ->step(0.01)
            ->label(__('cms-catalog::admin.products.Cost'));

        if (config('cms.catalog.brands.enabled')) {
            $result[] = FilterField::make()
                ->type(FilterField::TYPE_SELECT)
                ->options($this->brands)
                ->name('brand_id')
                ->label(__('cms-catalog::admin.products.Brand'))
                ->class('js-ajax-select2')
                ->attributes(['data-url' => route('admin.brands.search')]);
        }

        if (config('cms.catalog.models.enabled')) {
            $result[] = FilterField::make()
                ->type(FilterField::TYPE_SELECT)
                ->options($this->models)
                ->name('model_id')
                ->label(__('cms-catalog::admin.products.Model'))
                ->class('js-ajax-select2')
                ->attributes(['data-url' => route('admin.models.search')]);
        }

        $result[] = FilterField::published();

        return $result;
//        return array_merge($result, $this->buildSpecificationsFilterInputs());
    }

    /**
     * @param  Request  $request
     */
    public function restoreSelectedOptions(Request $request)
    {
        if ($brandId = $request->get('brand_id')) {
            $brand = Brand::find($brandId);
            if ($brand) {
                $this->brands = [$brand->id => $brand->name];
            }
        }
        if ($modelId = $request->get('model_id')) {
            $model = Model::find($modelId);
            if ($model) {
                $this->models = [$model->id => $model->name];
            }
        }
    }

    public function id($id)
    {
        $this->whereIn('id', explode(',', $id));
    }

    public function name($name)
    {
        $this->related('translations', 'name', 'LIKE', '%' . Helpers::escapeLike($name) . '%');
    }

    public function category($id)
    {
        $this->where('category_id', $id);
    }

    public function costFrom($cost)
    {
        $this->where('cost', '>=', $cost);
    }

    public function costTo($cost)
    {
        $this->where('cost', '<=', $cost);
    }

    public function brand($id)
    {
        $this->where('brand_id', '=', $id);
    }

    public function model($id)
    {
        $this->where('model_id', '=', $id);
    }

    public function published($published)
    {
        $this->where('published', $published);
    }

    public function specifications($specifications)
    {
        $specifications = array_filter(array_map('array_filter', $specifications));
        $count = count($specifications);
        if ($count) {
            $this->select($this->query->getModel()->getTable() . '.*');
            $this->join('product_specifications', 'product_specifications.product_id', '=', 'products.id');

            $this->where(function ($query) use ($specifications) {
                foreach ($specifications as $specId => $specValues) {
                    $query->orWhere(function ($query) use ($specId, $specValues) {
                        $query->where('spec_id', $specId)
                            ->whereIn('spec_value_id', $specValues);
                    });
                }
            });

            $this->having(\DB::raw('COUNT(DISTINCT product_specifications.spec_id)'), '>=', $count);

            $this->groupBy('products.id');
        }
    }

    /**
     * @return array
     */
    protected function buildSpecificationsFilterInputs(): array
    {
        return Specification::with(['specValues' => function ($query) {
            $query->sorting();
        }])
            ->sorting()
            ->get()
            ->filter(function (Specification $specification) {
                return $specification->name !== null;
            })
            ->map(function (Specification $specification) {
                return FilterField::make()
                    ->type(FilterFieldInterface::TYPE_SELECT)
                    ->label($specification->name)
                    ->name('specifications[' . $specification->id . '][]')
                    ->attributes(['multiple' => true])
                    ->class('js-select2')
                    ->options($specification->specValues->pluck('name', 'id')->all());
            })->all();
    }
}
