<?php

namespace WezomCms\Seo\Widgets;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class MetricsWidget extends AbstractWidget
{
    protected $view = 'cms-seo::site.widgets.metrics-widget';

    public function execute(): ?array
    {
        $position = $this->parameter('position');

        $content = settings('seo.metrics.' . $position);

        if ($position === 'head') {
            $content = strip_tags($content, ['<style>', '<link>', '<meta>', '<script>']);
        }

        return compact('content');
    }
}
