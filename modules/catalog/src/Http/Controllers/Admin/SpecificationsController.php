<?php

namespace WezomCms\Catalog\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use WezomCms\Catalog\Http\Requests\Admin\SpecificationRequest;
use WezomCms\Catalog\Models\Specifications\Specification;
use WezomCms\Catalog\Models\Specifications\SpecValue;
use WezomCms\Core\Contracts\Assets\AssetManagerInterface;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Traits\SettingControllerTrait;

class SpecificationsController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Specification::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-catalog::admin.specifications';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.specifications';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = SpecificationRequest::class;

    /**
     * @var bool
     */
    protected $hasAnImage;

    /**
     * SpecificationsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->hasAnImage = config('cms.catalog.specifications.has_an_image', false);
    }

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-catalog::admin.specifications.Specifications');
    }

    /**
     * @param  Builder  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->sorting();
    }

    /**
     * @param  Specification  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function formData($obj, array $viewData): array
    {
        $this->renderJsTranslations();

        return ['hasAnImage' => $this->hasAnImage];
    }

    /**
     * @param  Specification  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fill($obj, FormRequest $request): array
    {
        $data = $request->only(array_keys(app('locales')));

        $data['published'] = $request->get('published', false);
        $data['multiple'] = $request->get('multiple', false);
        $data['slug'] = $request->get('slug');

        return $data;
    }

    /**
     * @return array
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [AdminLimit::make()];
    }

    private function renderJsTranslations()
    {
        $words = [
            'createNewSpecValue' => __('cms-catalog::admin.specifications.Create new spec value'),
            'cancel' => __('cms-catalog::admin.specifications.Cancel'),
            'published' => __('cms-catalog::admin.specifications.Published'),
            'name' => __('cms-catalog::admin.specifications.Name'),
            'slug' => __('cms-core::admin.layout.Slug'),
            'generateSlug' => __('cms-core::admin.layout.Generate slug'),
            'color' => __('cms-catalog::admin.specifications.Color'),
            'add' => __('cms-core::admin.layout.Add'),
            'save' => __('cms-core::admin.layout.Save'),
            'delete' => __('cms-core::admin.layout.Delete'),
            'itemsPerPage' => __('cms-catalog::admin.specifications.Items per page'),
            'position' => __('cms-catalog::admin.specifications.Position'),
            'control' => __('cms-core::admin.layout.Manage'),
            'filter' => __('cms-catalog::admin.specifications.Filter'),
        ];

        $this->assets->addInlineScript('window.translations.specifications = ' . json_encode($words))
            ->group(AssetManagerInterface::GROUP_ADMIN);
    }

    /**
     * @param  string  $type
     * @param  Model  $obj
     * @param  string  $field
     * @param  FormRequest  $formRequest
     * @return array|\Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|null
     */
    protected function associateSource(string $type, Model $obj, string $field, FormRequest $formRequest)
    {
        if (!$this->hasAnImage && $type === 'image' && $field === 'image') {
            return null;
        }

        return parent::associateSource($type, $obj, $field, $formRequest);
    }

    /**
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        /** @var \Illuminate\Database\Eloquent\Collection|Specification[]|LengthAwarePaginator $items */
        $items = Specification::when($request->get('term'), function ($builder, $term) {
            $builder->whereTranslationLike('name', '%' . $term . '%');
        })->without('translation')
            ->orderByTranslation('name')
            ->paginate(30);

        return $this->searchResponse($items, $request);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     */
    public function searchGroupedValues(Request $request)
    {
        /** @var Collection|SpecValue[]|LengthAwarePaginator $items */
        $items = SpecValue::when($request->get('term'), function ($builder, $term) {
            $builder->whereTranslationLike('name', '%' . $term . '%');
        })
            ->when($request->get('category_id'), function ($builder, $categoryId) {
                $builder->whereHas('specification', function ($builder) use ($categoryId) {
                    $builder->whereHas('categories', function ($builder) use ($categoryId) {
                        $builder->where('id', $categoryId);
                    });
                });
            })
            ->whereHas('specification')
            ->with('specification')
            ->without('translation')
            ->leftJoin(
                'specification_translations',
                'specification_translations.specification_id',
                '=',
                'spec_values.specification_id'
            )
            ->where('specification_translations.locale', app()->getLocale())
            ->orderBy('specification_translations.name')
            ->orderByDesc('specification_translations.specification_id')
            ->orderByTranslation('name')
            ->paginate(30);

        $results = $items->values()->mapToGroups(function (SpecValue $specValue) {
            return [$specValue->specification_id => $specValue];
        })->map(function (Collection $specValues) {
            $specification = $specValues->first()->specification;

            return [
                'id' => $specification->id,
                'text' => $specification->name,
                'children' => $specValues->map(function (SpecValue $specValue) {
                    return [
                        'id' => $specValue->id,
                        'text' => $specValue->name,
                    ];
                })
            ];
        })->values()->all();

        return $this->success([
            'results' => $results,
            'pagination' => [
                'more' => $items->hasMorePages(),
            ]
        ]);
    }

    /**
     * @param  Specification  $specification
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchValues(Specification $specification, Request $request)
    {
        /** @var Collection|SpecValue[]|LengthAwarePaginator $items */
        $items = $specification->specValues()
            ->when($request->get('term'), function ($builder, $term) {
                $builder->whereTranslationLike('name', '%' . $term . '%');
            })
            ->without('translation')
            ->orderByTranslation('name')
            ->paginate(30);

        return $this->searchResponse($items, $request);
    }

    /**
     * @param  LengthAwarePaginator  $items
     * @param  Request  $request
     * @return JsonResponse
     */
    protected function searchResponse(LengthAwarePaginator $items, Request $request): JsonResponse
    {
        $results = [];
        if (!$request->get('page') && !$request->get('multiple')) {
            $results[] = ['id' => '', 'text' => __('cms-core::admin.layout.Not set')];
        }

        foreach ($items as $item) {
            $results[] = [
                'id' => $item->id,
                'text' => $item->name,
            ];
        }

        return $this->success([
            'results' => $results,
            'pagination' => [
                'more' => $items->hasMorePages(),
            ]
        ]);
    }
}
