<?php

namespace WezomCms\ProductReviews\Http\Controllers\Admin;

use Form;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use WezomCms\Core\Foundation\Buttons\Link;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\Number;
use WezomCms\Core\Settings\Fields\Select;
use WezomCms\Core\Settings\Fields\Wysiwyg;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\PageName;
use WezomCms\Core\Settings\RenderSettings;
use WezomCms\Core\Traits\AjaxResponseStatusTrait;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\Pages\Models\Page;
use WezomCms\ProductReviews\Http\Requests\Admin\ProductReviewRequest;
use WezomCms\ProductReviews\Models\ProductReview;

class ProductReviewsController extends AbstractCRUDController
{
    use SettingControllerTrait;
    use AjaxResponseStatusTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = ProductReview::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-product-reviews::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.product-reviews';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = ProductReviewRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-product-reviews::admin.Product reviews');
    }

    /**
     * @param $id
     * @param  null  $exclude
     * @return \Illuminate\Http\JsonResponse
     */
    public function reviewsByProductId($id, $exclude = null)
    {
        $select = (string) Form::multiLevelSelect(
            'parent_id',
            $this->getReviewsTreeByProductId($id, $exclude),
            $exclude ? ProductReview::find($exclude)->parent_id : null,
            false,
            [
                'class' => 'form-control js-select2',
                'id' => 'parent_id',
                'placeholder' => __('cms-core::admin.layout.Not set')
            ]
        );

        return $this->success(compact('select'));
    }

    /**
     * @param  Builder  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->with([
            'product' => function ($query) {
                $query->withTrashed();
            }
        ]);
    }

    /**
     * @param  ProductReview  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function createViewData($obj, array $viewData): array
    {
        $obj->fill(request()->only('admin_answer', 'published', 'product_id', 'parent_id'));

        return [
            'reviews' => $this->getReviewsTreeByProductId($obj->product_id, $obj->id),
            'products' => $obj->product ? [$obj->product] : [],
        ];
    }

    /**
     * @param  ProductReview  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function editViewData($obj, array $viewData): array
    {
        $obj->load([
            'product' => function ($query) {
                $query->withTrashed();
            }
        ]);

        return [
            'reviews' => $this->getReviewsTreeByProductId($obj->product_id, $obj->id),
            'products' => $obj->product ? [$obj->product] : [],
        ];
    }

    /**
     * @param  int|null  $productId
     * @param  int|null  $exclude
     * @return array
     */
    protected function getReviewsTreeByProductId(?int $productId, ?int $exclude = null): array
    {
        if (!$productId) {
            return [];
        }

        $reviews = ProductReview::where('product_id', $productId)
            ->when($exclude, function ($query, $exclude) {
                $query->whereKeynot($exclude);
            })
            ->get()
            ->map(function (ProductReview $review) {
                if ($review->admin_answer && !$review->name) {
                    $name = __('cms-product-reviews::admin.Site administration');
                } else {
                    $name = sprintf('%s %s (%s)', $review->name, $review->email, $review->created_at->format('d.m.Y'));
                }

                return [
                    'value' => $review->id,
                    'name' => $name,
                    'parent_id' => $review->parent_id,
                ];
            });

        return Helpers::groupByParentId($reviews);
    }


    /**
     * @return array
     * @throws \Exception
     */
    protected function settings(): array
    {
        $result = [];

        $siteRenderSettings = RenderSettings::siteTab();

        $result[] = Number::make($siteRenderSettings)
            ->setName(__('cms-product-reviews::admin.Site reviews limit at product page'))
            ->default(10)
            ->setKey('product_page_limit')
            ->setRules('required|numeric|min:1');

        $result[] = AdminLimit::make();

        return $result;
    }

    /**
     * @param  string  $currentAction
     * @param  ProductReview  $model
     * @param  string|null  $index
     * @param  string|null  $indexAbility
     * @return \WezomCms\Core\Contracts\ButtonsContainerInterface
     */
    protected function formButtons(string $currentAction, $model, string $index = null, string $indexAbility = null)
    {
        $buttons = parent::formButtons($currentAction, $model, $index, $indexAbility);

        if ($currentAction === 'edit') {
            $link = route(
                'admin.product-reviews.create',
                ['admin_answer' => 1, 'published' => 1, 'product_id' => $model->product_id, 'parent_id' => $model->id]
            );

            $buttons->add(Link::make()
                ->setName(__('cms-product-reviews::admin.Write answer'))
                ->setLink($link)
                ->setClass('btn-sm', 'btn-outline-secondary')
                ->setIcon('fa-pencil-square-o')
                ->setSortPosition(5));
        }

        return $buttons;
    }
}
