<?php

namespace WezomCms\Faq\ModelFilters;

use EloquentFilter\ModelFilter;
use WezomCms\Core\Contracts\Filter\FilterListFieldsInterface;
use WezomCms\Core\Filter\FilterField;
use WezomCms\Core\Foundation\Helpers;
use WezomCms\Faq\Models\FaqGroup;
use WezomCms\Faq\Models\FaqQuestion;

/**
 * Class FaqQuestionFilter
 * @package WezomCms\Faq\ModelFilters
 * @mixin FaqQuestion
 */
class FaqQuestionFilter extends ModelFilter implements FilterListFieldsInterface
{
    /**
     * Generate array with fields
     * @return iterable|FilterField[]
     */
    public function getFields(): iterable
    {
        $groupField = FilterField::make()
            ->name('group_id')
            ->label(__('cms-faq::admin.Group'))
            ->class('js-select2')
            ->type(FilterField::TYPE_SELECT)
            ->hide(!config('cms.faq.faq.use_groups'))
            ->options(FaqGroup::sorting()
                ->get()
                ->pluck('name', 'id')
                ->toArray());

        return [
            FilterField::make()->name('question')->label(__('cms-faq::admin.Question')),
            FilterField::make()->name('answer')->label(__('cms-faq::admin.Answer')),
            $groupField,
            FilterField::published(),
        ];
    }

    public function question($question)
    {
        $this->related('translations', 'question', 'LIKE', '%' . Helpers::escapeLike($question) . '%');
    }

    public function answer($answer)
    {
        $this->related('translations', 'answer', 'LIKE', '%' . Helpers::escapeLike($answer) . '%');
    }

    public function group($id)
    {
        $this->where('faq_group_id', $id);
    }

    public function published($published)
    {
        $this->where('published', $published);
    }
}
