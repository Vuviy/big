<?php

namespace WezomCms\Newsletter\ModelFilters;

use EloquentFilter\ModelFilter;
use Illuminate\Support\Carbon;
use WezomCms\Core\Contracts\Filter\FilterFieldInterface;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Newsletter\Models\NewsletterHistory;

/**
 * Class NewsletterHistoryFilter
 * @package WezomCms\Newsletter\ModelFilters
 * @mixin NewsletterHistory
 */
class NewsletterHistoryFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with filter fields.
     * @return iterable|FilterFieldInterface[]
     */
    public function getFields(): iterable
    {
        return [
            FilterField::make()->name('created_at')->type(FilterField::TYPE_DATE_RANGE)
                ->label(__('cms-newsletter::admin.Sent in')),
            FilterField::make()->name('subject')->label(__('cms-newsletter::admin.Subject')),
            FilterField::make()->name('text')->label(__('cms-newsletter::admin.Text')),
            FilterField::locale(['size' => 3]),
        ];
    }

    public function subject($subject)
    {
        $this->whereLike('subject', $subject);
    }

    public function text($text)
    {
        $this->whereLike('text', $text);
    }

    public function createdAtFrom($date)
    {
        $this->where('created_at', '>=', Carbon::parse($date));
    }

    public function createdAtTo($date)
    {
        $this->where('created_at', '<=', Carbon::parse($date)->endOfDay());
    }

    public function locale($locale)
    {
        $this->where('locale', $locale);
    }
}
