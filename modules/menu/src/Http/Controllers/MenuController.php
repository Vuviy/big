<?php

namespace WezomCms\Menu\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use WezomCms\Core\Contracts\ButtonInterface;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Menu\Http\Requests\MenuRequest;
use WezomCms\Menu\Models\Menu;
use WezomCms\Menu\Models\MenuTranslation;

class MenuController extends AbstractCRUDController
{
    /**
     * Model name.
     *
     * @var string
     */
    protected $model = Menu::class;

    /**
     * Indicates whether to use pagination.
     *
     * @var bool
     */
    protected $paginate = false;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-menu::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.menu';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = MenuRequest::class;

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-menu::admin.Menu');
    }

    /**
     * @param $id
     * @param $group
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function copy($id, $group)
    {
        /** @var Menu $item */
        $item = $this->model()::findOrFail($id);
        $groupSettings = config("cms.menu.menu.groups.{$group}");
        abort_if(!$groupSettings, 404);

        $this->authorizeForAction('edit', $item);

        $newItem = $item->replicate();
        $newItem->group = $group;
        $newItem->parent_id = null;
        $newItem->save();

        $this->copyTranslations($newItem->id, $item);

        $this->copyChildren($newItem, $item->children, array_get($groupSettings, 'depth', 100));

        flash()->success(__('cms-menu::admin.Menu items copied successfully'));

        return redirect()->route('admin.menu.index');
    }

    /**
     * @param  Builder|Menu  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->sorting();
    }

    /**
     * @param $result
     * @param  array  $viewData
     * @return array
     */
    protected function indexViewData($result, array $viewData): array
    {
        $result = Helpers::groupByParentId($result, 'group');

        $data = [];
        foreach ($result as $group => $items) {
            $data[$group] = Helpers::groupByParentId($items);
        }

        return ['groups' => config('cms.menu.menu.groups'), 'result' => $data];
    }

    /**
     * @param  Menu  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function createViewData($obj, array $viewData): array
    {

        $tree = [
            '' => __('cms-menu::admin.Root'),
        ];

        if ($obj->group = old('group', $obj->group ?: request()->get('group'))) {
            $tree += $this->generateTree($obj);
        }

        // Groups
        $groups = array_map(function ($el) {
            return __($el['name']);
        }, config('cms.menu.menu.groups'));

        $groups = ['' => __('cms-core::admin.layout.Not set')] + $groups;

        return compact('groups', 'tree');
    }

    /**
     * @param  Menu  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function editViewData($obj, array $viewData): array
    {
        $tree = [
            '' => __('cms-menu::admin.Root'),
        ];

        if ($obj->group) {
            $tree += $this->generateTree($obj);
        }

        // Groups
        $groups = array_map(function ($el) {
            return __($el['name']);
        }, config('cms.menu.menu.groups'));

        $groups = ['' => __('cms-core::admin.layout.Not set')] + $groups;

        return compact('groups', 'tree');
    }

    /**
     * @param $group
     * @param  Request  $request
     * @return array
     */
    public function getParentsList($group, Request $request)
    {
        $query = Menu::select('id', 'parent_id');
        if ($id = $request->get('id')) {
            $query->where('id', '<>', $id);
        }

        $items = $query->where('group', $group)
            ->sorting()
            ->get();

        $groupedItems = Helpers::groupByParentId($items);

        $maxDept = config("cms.menu.menu.groups.{$group}.depth", 100);

        $result = ['' => __('cms-menu::admin.Root')] + $this->generateTreeRecursive($groupedItems, $maxDept);

        $options = [];
        foreach ($result as $id => $name) {
            $options[] = compact('id', 'name');
        }

        return compact('options');
    }

    /**
     * @param $obj
     * @param  bool  $force
     * @return \Illuminate\Http\RedirectResponse|null
     */
    protected function beforeDelete($obj, bool $force = false)
    {
        if ($obj->children()->exists()) {
            flash(__('cms-menu::admin.You can not delete this item, because it contains a sub'), 'error');

            return redirect()->back();
        }

        return null;
    }

    /**
     * @param $action
     * @return array
     */
    protected function addParametersToRedirect($action): array
    {
        if ($action === ButtonInterface::ACTION_SAVE_AND_CREATE) {
            return [
                'group' => app('request')->get('group'),
                'parent_id' => app('request')->get('parent_id'),
            ];
        }

        return [];
    }

    /**
     * @param $obj
     * @return array
     */
    private function generateTree($obj): array
    {
        $items = Menu::select('id', 'parent_id')
            ->where('id', '<>', $obj->id)
            ->where('group', $obj->group)
            ->sorting()
            ->get();

        $groupedItems = Helpers::groupByParentId($items);

        $maxDept = config("cms.menu.menu.groups.{$obj->group}.depth", 100);

        return $this->generateTreeRecursive($groupedItems, $maxDept);
    }

    /**
     * @param  array  $groupedItems
     * @param  int  $maxDepth
     * @param  null  $parentId
     * @param  int  $depth
     * @return array
     */
    private function generateTreeRecursive(array $groupedItems, int $maxDepth, $parentId = null, $depth = 0)
    {
        $result = [];

        if ($depth + 1 >= $maxDepth) {
            return $result;
        }

        $elements = $groupedItems[$parentId] ?? [];

        foreach ($elements as $item) {
            $result[$item->id] = str_repeat('&nbsp;', $depth * 4) . $item->name;

            $result += $this->generateTreeRecursive($groupedItems, $maxDepth, $item->id, $depth + 1);
        }

        return $result;
    }

    /**
     * @param $id
     * @param  Menu  $oldMenuItem
     */
    private function copyTranslations($id, Menu $oldMenuItem)
    {
        foreach ($oldMenuItem->translations as $translation) {
            /** @var MenuTranslation $newTranslation */
            $newTranslation = $translation->replicate();
            $newTranslation->menu_id = $id;
            $newTranslation->save();
        }
    }

    /**
     * @param  Menu  $parent
     * @param  Collection  $children
     * @param  int  $depth
     * @param  int  $currentDepth
     */
    private function copyChildren(Menu $parent, Collection $children, int $depth, int $currentDepth = 1)
    {
        if ($children->isNotEmpty() && $currentDepth < $depth) {
            foreach ($children as $child) {
                /** @var Menu $newChild */
                $newChild = $child->replicate();
                $newChild->group = $parent->group;
                $newChild->parent_id = $parent->id;
                $newChild->save();

                $this->copyTranslations($newChild->id, $child);

                $this->copyChildren($newChild, $child->children, $depth, $currentDepth + 1);
            }
        }
    }
}
