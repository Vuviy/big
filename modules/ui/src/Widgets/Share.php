<?php

namespace WezomCms\Ui\Widgets;

use SEO;
use URL;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class Share extends AbstractWidget
{
    /**
     * View name.
     *
     * @var string|null
     */
    protected $view = 'cms-ui::widgets.share';

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        return [
            'title' => $this->parameter('title') ?: SEO::getTitle(),
            'url' => $this->parameter('url') ?: URL::current(),
        ];
    }
}
