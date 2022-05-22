<?php

namespace WezomCms\Seo\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Seo\Models\SeoRedirect;

/**
 * Class SeoRedirectFilter
 * @package WezomCms\Seo\ModelFilters
 * @mixin SeoRedirect
 */
class SeoRedirectFilter extends ModelFilter implements FilterListFieldsInterface
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
                ->name('link_from')
                ->label(__('cms-seo::admin.redirects.Link from'))
                ->type(FilterField::TYPE_INPUT),

            FilterField::make()
                ->name('link_to')
                ->label(__('cms-seo::admin.redirects.Link to'))
                ->type(FilterField::TYPE_INPUT)
                ->size(4),

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

    public function linkFrom($link)
    {
        $this->whereLike('link_from', $link);
    }

    public function linkTo($link)
    {
        $this->whereLike('link_to', $link);
    }
}
