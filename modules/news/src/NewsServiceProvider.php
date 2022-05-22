<?php

namespace WezomCms\News;

use Illuminate\Database\Eloquent\Collection;
use WezomCms\Core\BaseServiceProvider;
use WezomCms\Core\Contracts\PermissionsContainerInterface;
use WezomCms\Core\Contracts\SitemapXmlGeneratorInterface;
use WezomCms\Core\Traits\SidebarMenuGroupsTrait;
use WezomCms\News\Models\News;
use WezomCms\News\Models\NewsTag;

class NewsServiceProvider extends BaseServiceProvider
{
    use SidebarMenuGroupsTrait;

    /**
     * All module widgets.
     *
     * @var array|string|null
     */
    protected $widgets = 'cms.news.news.widgets';

    /**
     * Dashboard widgets.
     *
     * @var array|string|null
     */
    protected $dashboard = 'cms.news.news.dashboards';

    /**
     * Register admin menu links.
     */
    public function adminMenu()
    {
        if (config('cms.news.news.use_tags')) {
            $group = $this->contentGroup()
                ->add(__('cms-news::admin.News'), route('admin.news.index'))
                ->data('icon', 'fa-newspaper-o')
                ->nickname('news');

            $group->add(__('cms-news::admin.News'), route('admin.news.index'))
                ->data('permission', 'news.view')
                ->data('icon', 'fa-list')
                ->data('position', 1);

            $group->add(__('cms-news::admin.Tags'), route('admin.news-tags.index'))
                ->data('permission', 'news-tags.view')
                ->data('icon', 'fa-tags')
                ->data('position', 3);
        } else {
            $this->contentGroup()
                ->add(__('cms-news::admin.News'), route('admin.news.index'))
                ->data('permission', 'news.view')
                ->data('icon', 'fa-newspaper-o')
                ->nickname('news');
        }
    }

    /**
     * Define admin permissions.
     *
     * @param  PermissionsContainerInterface  $permissions
     */
    public function permissions(PermissionsContainerInterface $permissions)
    {
        $permissions->add('news', __('cms-news::admin.News'))->withEditSettings();
        if (config('cms.news.news.use_tags')) {
            $permissions->add('news-tags', __('cms-news::admin.News tags'));
        }
    }

    /**
     * @return array
     */
    public function sitemap()
    {
        $root = [
            'id' => 'news',
            'parent_id' => 0,
            'name' => settings('news.site.name'),
            'url' => route('news'),
        ];

        if (config('cms.news.news.sitemap.news')) {
            /** @var Collection $news */
            $news = News::published()
                ->select('id')
                ->with('translation:name,slug,locale,news_id')
                ->orderByDesc('published_at')
                ->latest('id')
                ->get()
                ->map(function (News $item) {
                    return [
                        'parent_id' => 'news',
                        'id' => $item->id,
                        'name' => $item->name,
                        'url' => $item->getFrontUrl(),
                    ];
                });

            // Add tags
            if (config('cms.news.news.use_tags') && config('cms.news.news.sitemap.tags')) {
                /** @var Collection $tags */
                $tags = NewsTag::published()
                    ->select(['id', 'slug'])
                    ->with('translation:name,locale,news_tag_id')
                    ->latest('id')
                    ->get()
                    ->map(function (NewsTag $item) {
                        return [
                            'parent_id' => 'news_tags',
                            'id' => $item->id,
                            'name' => $item->name,
                            'url' => $item->getFrontUrl(),
                        ];
                    });

                if ($tags->isNotEmpty()) {
                    $tags->prepend(
                        [
                            'id' => 'news_tags',
                            'parent_id' => 'news',
                            'sort' => -1,
                            'name' => __('cms-news::admin.Tags')
                        ]
                    );
                    $news = $tags->merge($news);
                }
            }

            return $news->prepend($root)->toArray();
        } else {
            return [$root];
        }
    }

    /**
     * @param  SitemapXmlGeneratorInterface  $sitemap
     * @throws \ErrorException
     */
    public function sitemapXml(SitemapXmlGeneratorInterface $sitemap)
    {
        $sitemap->addLocalizedRoute('news');

        $sitemap->add(function () {
            return News::published()
                ->select('id')
                ->with('translation:slug,locale,news_id')
                ->get()
                ->mapWithKeys(function (News $news) {
                    return [$news->id => $news->getFrontUrl()];
                });
        });


        if (config('cms.news.news.use_tags')) {
            $sitemap->add(function () {
                return NewsTag::published()
                    ->select('id', 'slug')
                    ->with('translation:locale,news_tag_id')
                    ->get()
                    ->mapWithKeys(function (NewsTag $item) {
                        return [$item->id => $item->getFrontUrl()];
                    });
            });
        }
    }
}
