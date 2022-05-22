<?php

namespace WezomCms\Faq\Dashboards;

use WezomCms\Core\Foundation\Dashboard\AbstractValueDashboard;
use WezomCms\Faq\Models\FaqQuestion;

class FaqDashboard extends AbstractValueDashboard
{
    /**
     * @var null|int - cache time in minutes.
     */
    protected $cacheTime = 5;

    /**
     * @var null|string - permission for link
     */
    protected $ability = 'faq.view';

    /**
     * @return int
     */
    public function value(): int
    {
        return FaqQuestion::count();
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return __('cms-faq::admin.Questions');
    }

    /**
     * @return string
     */
    public function icon(): string
    {
        return 'fa-question-circle-o';
    }

    /**
     * @return null|string
     */
    public function url(): ?string
    {
        return route('admin.faq.index');
    }
}
