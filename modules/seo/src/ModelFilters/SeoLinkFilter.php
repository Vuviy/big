<?php

namespace WezomCms\Seo\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Seo\Models\SeoLink;

/**
 * Class SeoLinkFilter
 * @package WezomCms\Seo\ModelFilters
 * @mixin SeoLink
 */
class SeoLinkFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::makeName()
                ->size(4),

            FilterField::make()
                ->name('link')
                ->label(__('cms-seo::admin.links.Link'))
                ->type(FilterField::TYPE_INPUT),

            FilterField::make()
                ->name('h1')
                ->label(__('cms-core::admin.seo.H1'))
                ->type(FilterField::TYPE_INPUT)
                ->size(4),

            FilterField::make()
                ->name('title')
                ->label(__('cms-core::admin.seo.Title'))
                ->type(FilterField::TYPE_INPUT),

            FilterField::published(),
        ];
    }

    public function published($published)
    {
        $this->where('published', $published);
    }

    public function name($name)
    {
        $this->whereLike('name', $name);
    }

    public function link($link)
    {
        $this->whereLike('link', $link);
    }

    public function h1($h1)
    {
        $this->whereLike('h1', $h1);
    }

    public function title($title)
    {
        $this->whereLike('title', $title);
    }
}
