<?php

namespace WezomCms\News\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use WezomCms\Core\Http\Controllers\AbstractCRUDController;
use WezomCms\Core\Settings\AdminLimit;
use WezomCms\Core\Settings\Fields\AbstractField;
use WezomCms\Core\Settings\MetaFields\SeoFields;
use WezomCms\Core\Settings\MultilingualGroup;
use WezomCms\Core\Settings\SiteLimit;
use WezomCms\Core\Traits\SettingControllerTrait;
use WezomCms\News\Http\Requests\Admin\NewsRequest;
use WezomCms\News\Models\News;
use WezomCms\News\Models\NewsTag;

class NewsController extends AbstractCRUDController
{
    use SettingControllerTrait;

    /**
     * Model name.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Base view path name.
     *
     * @var string
     */
    protected $view = 'cms-news::admin';

    /**
     * Resource route name.
     *
     * @var string
     */
    protected $routeName = 'admin.news';

    /**
     * Form request class name.
     *
     * @var string
     */
    protected $request = NewsRequest::class;

    /**
     * @var bool
     */
    private $useTags;

    /**
     * NewsController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->useTags = (bool) config('cms.news.news.use_tags');
    }

    /**
     * Resource name for breadcrumbs and title.
     *
     * @return string
     */
    protected function title(): string
    {
        return __('cms-news::admin.News');
    }

    /**
     * @return string|null
     */
    protected function frontUrl(): ?string
    {
        return route('news');
    }

    /**
     * @param  Builder|News  $query
     * @param  Request  $request
     */
    protected function selectionIndexResult($query, Request $request)
    {
        $query->latest('published_at');
    }

    /**
     * @param  News  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function createViewData($obj, array $viewData): array
    {
        $tags = [];
        if ($this->useTags) {
            $tags = NewsTag::published()
                ->orderByTranslation('name')
                ->getForSelect();
        }

        return [
            'tags' => $tags,
            'selectedTags' => [],
        ];
    }

    /**
     * @param  News  $obj
     * @param  FormRequest  $request
     * @return array
     */
    protected function fill($obj, FormRequest $request): array
    {
        $data = parent::fill($obj, $request);

        $data['published_at'] = strtotime($request->get('published_at') . ' ' . date('H:i:s'));

        return $data;
    }

    /**
     * @param  News  $obj
     * @param  Request  $request
     */
    protected function afterSuccessfulSave($obj, Request $request)
    {
        if ($this->useTags) {
            $obj->tags()->sync($request->get('tags', []));
        }
    }

    /**
     * @param  News  $obj
     * @param  array  $viewData
     * @return array
     */
    protected function editViewData($obj, array $viewData): array
    {
        $tags = [];
        $selectedTags = [];
        if ($this->useTags) {
            $tags = NewsTag::published()
                ->orderByTranslation('name')
                ->getForSelect();

            $selectedTags = $obj->tags()->pluck('news_tag_id')->toArray();
        }

        return [
            'tags' => $tags,
            'selectedTags' => $selectedTags,
        ];
    }

    /**
     * @return array|AbstractField[]|MultilingualGroup[]
     * @throws \Exception
     */
    protected function settings(): array
    {
        return [
            SiteLimit::make(),
            SeoFields::make('News'),
            AdminLimit::make(),
        ];
    }
}
