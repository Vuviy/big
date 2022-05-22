<?php

namespace WezomCms\Catalog\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use WezomCms\Catalog\Http\Requests\Admin\ProductRequest;
use WezomCms\Catalog\Models\Category;
use WezomCms\Catalog\Models\Product;
use WezomCms\Catalog\Models\ProductSpecification;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Core\Foundation\Buttons\Button;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\MetaFields\Description;
use WezomCms\Core\Settings\MetaFields\Heading;
use WezomCms\Core\Settings\MetaFields\Keywords;
use WezomCms\Core\Settings\MetaFields\Title;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Settings\Tab;
use WezomCms\Core\Traits\AjaxResponseStatusTrait;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Core\Traits\SoftDeletesActionsTrait;
use WezomCms\Orders\Models\OrderItem;

class ProductController extends AbstractCRUDController
{
    use SettingControllerTrait;
    use AjaxResponseStatusTrait;
    use SoftDeletesActionsTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-catalog::admin.products';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.products';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = ProductRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-catalog::admin.products.Products');
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        /** @var Collection|Product[]|LengthAwarePaginator $products */
        $products = Product::search($request->get('term'), $request->only('category_id'));

        $results = [];
        if (!$request->get('page') && !$request->get('multiple')) {
            $results[] = ['id' => '', 'text' => __('cms-core::admin.layout.Not set')];
        }
        foreach ($products as $product) {
            $results[] = [
                'id' => $product->id,
                'text' => sprintf('ID-%s %s (%s)', $product->id, $product->name, money($product->cost, true)),
                'data' => [
                    'name' => $product->name,
                    'cost' => money($product->cost),
                    'currency' => money()->adminCurrencySymbol(),
                    'image' => $product->getImageUrl(),
                    'min' => $product->minCountForPurchase(),
                    'step' => $product->stepForPurchase(),
                    'unit' => $product->unit(),
                ]
            ];
        }

        return $this->success([
            'results' => $results,
            'pagination' => [
                'more' => $products->hasMorePages(),
            ]
        ]);
    }

    /**
     * @param $id
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function setSort($id, Request $request)
    {
        $product = Product::findOrFail($id);

        $this->authorizeForAction('edit', $product);

        $product->sort = $request->get('sort', 0);

        $product->save();

        return $this->success(['message' => __('cms-core::admin.layout.Data successfully updated')]);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function copy($id)
    {
        $product = Product::findOrFail($id);

        $this->authorizeForAction('copy', $product);

        try {
            $newProduct = \DB::transaction(function () use ($product) {
                $item = tap($product->replicateWithTranslations(), function (Product $product) {
                    $product->saveOrFail();
                });

                $item->primarySpecValues()->sync($product->primarySpecValues->pluck('id'));

                foreach ($product->productSpecifications as $relation) {
                    $item->productSpecifications()->create($relation->only('spec_id', 'spec_value_id'));
                }

                // Copy images
                foreach ($product->images as $image) {
                    $newImage = $image->replicate();

                    $newImage->product_id = $item->id;

                    $newImage->save();
                }

                return $item;
            });

            return redirect()->route($this->makeRouteName('edit'), $newProduct->id);
        } catch (\Exception $e) {
            report($e);

            flash(__('cms-catalog::admin.products.Error copying data'))->error();

            return back();
        }
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function specificationsWidget(Request $request)
    {
        $categoryId = $request->input('category_id');
        $product = Product::find($request->input('product_id'));

        if ($categoryId) {
            $html = app('widget')->show(
                'catalog:product-specifications-tab',
                ['product' => $product, 'categoryId' => $categoryId]
            );
        } else {
            $html = '';
        }

        return $this->success([
            'html' => $html,
            'primary_search_url' => route('admin.specifications.search-grouped-values', ['category_id' => $categoryId]),
        ]);
    }

    /**
     * @param  Collection|Product[]  $result
     * @param  array  $viewData
     * @return array
     */
    protected function indexViewData($result, array $viewData): array
    {
        $buttons = [];
        if ($this->allowsForAction('edit', $this->model())) {
            $buttons[] = Button::make()
                ->setAttribute('data-list-action', 'changeCategoryPopup')
                ->setClass('btn btn-sm btn-info')
                ->setTitle(__('cms-catalog::admin.products.Move products to another category'))
                ->setIcon('fa fa-share');
        }

        return compact('buttons');
    }

    /**
     * @param  Builder  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->with('category')->orderBy('group_key')->sorting();
    }

    /**
     * @param  Product  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function formData($obj, array $viewData): array
    {
        return [
            'categoriesTree' => Category::getForSelect(),
        ];
    }

    /**
     * @param  Product  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fill($obj, FormRequest $request): array
    {
        $data = $request->validated();

        $data['videos'] = array_filter($request->get('videos', []));

        if (!$request->get('sale')) {
            $data['old_cost'] = 0;
        }

        $obj->expires_at = Carbon::parse($request->get('expires_at'))->endOfDay();
        $obj->discount_percentage = $request->get('discount_percentage');

        if (config('cms.catalog.brands.enabled', false)) {
            $obj->brand()->associate($request->get('brand_id'));
        }

        if (config('cms.catalog.models.enabled', false)) {
            $obj->model()->associate($request->get('model_id'));
        }

        return $data;
    }

    /**
     * @param  Product  $obj
     * @param  Request  $request
     */
    protected function afterSuccessfulSave($obj, Request $request)
    {
        $obj->updateSpecValueRelation($request->get('SPEC_VALUES', []), $request->get('primarySpecValues', []));
        $obj->primarySpecValues()->sync($request->get('primarySpecValues', []));
        $obj->productAccessories()->sync($request->get('PRODUCT_ACCESSORIES', []));
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changeCategoryPopup()
    {
        return view($this->view . '.change-category-popup', ['categoriesTree' => Category::getForSelect()]);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function changeCategory(Request $request)
    {
        $this->authorizeForAction('edit', $this->model());

        $categoryId = $request->get('category_id');
        $ids = $request->get('IDS', []);
        if (!$categoryId || !count($ids)) {
            return $this->error(__('cms-catalog::admin.products.Please select category and products'));
        }

        $this->model()::whereKey($ids)
            ->each(function (Product $product) use ($categoryId) {
                $product->category()->associate($categoryId);
                $product->save();
            });

        return $this->success(['reload' => true]);
    }

    /**
     * @param $obj
     * @param  bool  $force
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function beforeDelete($obj, bool $force = false)
    {
        if (OrderItem::where('product_id', $obj->id)->exists()) {
            flash(__('cms-catalog::admin.products.You cannot delete this item because there is an order with this item'), 'error');

            return redirect()->back();
        }
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function settings(): array
    {
        $result = [];

        // Products
        $products = new RenderSettings(
            new Tab('products', __('cms-catalog::admin.products.Products'), 2, 'fa-folder-o')
        );

        // Products meta
        $items = [
            Title::make()
                ->setHelpText(__('cms-catalog::admin.products.Product meta-tags keys')),
            Heading::make()
                ->setHelpText(__('cms-catalog::admin.products.Product meta-tags keys')),
            Description::make()
                ->setHelpText(__('cms-catalog::admin.products.Product meta-tags keys')),
            Keywords::make()
                ->setHelpText(__('cms-catalog::admin.products.Product meta-tags keys')),
        ];

        $result[] = new MultilingualGroup($products, $items);

        $result[] = AdminLimit::make();

        return $result;
    }
}
