<?php

namespace WezomCms\News\Http\Controllers\Site;

use Illuminate\Pagination\Paginator;
use Spatie\SchemaOrg\Schema;
use WezomCms\Core\Http\Controllers\SiteController;
use WezomCms\Core\Traits\LoadMoreTrait;
use WezomCms\Core\Traits\MicroDataTrait;
use WezomCms\Core\Traits\OGImageTrait;
use WezomCms\News\Models\News;
use WezomCms\News\Models\NewsTag;

class NewsController extends SiteController
{
    use OGImageTrait;
    use LoadMoreTrait;
    use MicroDataTrait;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        // Module settings
        $settings = settings('news.site', []);

        $result = News::published()
            ->orderByDesc('published_at')
            ->latest('id')
            ->paginate(array_get($settings, 'limit', 16));

        // Render
        return $this->viewLoadMore(
            $result,
            function () use ($result) {
                return view('cms-news::site.partials.news-list', compact('result'));
            },
            function () use ($result, $settings) {
                $this->addBreadcrumb(array_get($settings, 'name'), route('news'));

                $this->seo()->fill($settings, false)->setPrevNext($result);

                return view('cms-news::site.index', compact('result'));
            }
        );
    }

    /**
     * @param  string  $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tag($slug)
    {
        /** @var NewsTag $tag */
        $tag = NewsTag::publishedWithSlug($slug)->firstOrFail();

        /** @var Paginator $result */
        $result = $tag->news()
            ->published()
            ->orderByDesc('published_at')
            ->latest('id')
            ->paginate(settings('news.site.limit', 10));

        // Render
        return $this->viewLoadMore(
            $result,
            function () use ($result) {
                return view('cms-news::site.partials.news-list', compact('result'));
            },
            function () use ($result, $slug, $tag) {
                $this->setLangSwitchers($tag, 'news.tag', ['tag' => 'model.slug'], false);

                $this->addBreadcrumb(settings('news.site.name'), route('news'));
                $this->addBreadcrumb($tag->name, $tag->getFrontUrl());

                $this->seo()->fill($tag, false)->setPrevNext($result);

                return view('cms-news::site.index', ['result' => $result, 'currentTag' => $slug]);
            }
        );
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \WezomCms\Core\Image\Exceptions\IncorrectImageSizeException
     */
    public function inner($slug)
    {
        /** @var News $obj */
        $obj = News::publishedWithSlug($slug)->firstOrFail();

        $this->setLangSwitchers($obj, 'news.inner');

        // Add views
        views($obj)->record();

        // Breadcrumbs
        $this->addBreadcrumb(settings('news.site.name'), route('news'));
        $this->addBreadcrumb($obj->name, $obj->getFrontUrl());

        $this->seo()->fill($obj, false);

        $this->setOGImage($obj);

        $this->setMicroData($obj);

        // Render
        return view('cms-news::site.inner', [
            'obj' => $obj,
        ]);
    }

    /**
     * @param  News  $news
     * @throws \WezomCms\Core\Image\Exceptions\IncorrectImageSizeException
     */
    private function setMicroData(News $news)
    {
        $siteAsOrganization = $this->organization();

        $schemaNews = Schema::newsArticle()
            ->url($news->getFrontUrl())
            ->name($news->name)
            ->headline($news->title ?: $news->name)
            ->description($news->description)
            ->author($siteAsOrganization)
            ->publisher($siteAsOrganization)
            ->datePublished($news->created_at)
            ->dateModified($news->updated_at);

        if ($news->imageExists()) {
            $schemaNews->image($news->getImageUrl());
        }

        $this->renderMicroData($schemaNews);
    }
}
