<?php

namespace WezomCms\MediaBlocks\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\MediaBlocks\Http\Requests\Admin\MediaBlockRequest;
use WezomCms\MediaBlocks\Models\MediaBlock;

class MediaBlocksController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = MediaBlock::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-media-blocks::admin';


    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.media-blocks';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = MediaBlockRequest::class;

    /**
     * Indicates whether to use pagination.
     *
     * @var bool
     */
    protected $paginate = false;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-media-blocks::admin.Media blocks');
    }

    /**
     * @param  Builder  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->orderBy('sort');
    }

    /**
     * @param $result
     * @param  array  $viewData
     * @return array
     */
    protected function indexViewData($result, array $viewData): array
    {
        $result = Helpers::groupByParentId($result, 'type');

        $data = [];
        foreach ($result as $group => $items) {
            $data[$group] = Helpers::groupByParentId($items);
        }

        return ['groups' => config('cms.media-blocks.media-blocks.groups'), 'result' => $data];
    }

    /**
     * @param  MediaBlock  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function createViewData($obj, array $viewData): array
    {
        // Groups
        $groups = array_map(function ($el) {
            return __($el['name']);
        }, config('cms.media-blocks.media-blocks.groups'));

        $groups = ['' => __('cms-core::admin.layout.Not set')] + $groups;

        return compact('groups');
    }

    /**
     * @param  MediaBlock  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function editViewData($obj, array $viewData): array
    {
        // Groups
        $groups = array_map(function ($el) {
            return __($el['name']);
        }, config('cms.media-blocks.media-blocks.groups'));

        $groups = ['' => __('cms-core::admin.layout.Not set')] + $groups;

        return compact('groups');
    }

    /**
     * @param  Model  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fill($obj, FormRequest $request): array
    {
        $data = $request->validated();

        foreach (array_keys(app('locales')) as $locale) {
            $data[$locale]['url'] = setHttpsForLocalLinks($data[$locale]['url']);
        }

        return $data;
    }
}
