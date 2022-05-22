<?php

namespace WezomCms\Slider\Widgets;

use Illuminate\Database\Eloquent\Collection;
use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;
use WezomCms\Slider\Models\Slide;
use WezomCms\Slider\Models\SlideTranslation;

class Slider extends AbstractWidget
{
    /**
     * A list of models that, when changed, will clear the cache of this widget.
     *
     * @var array
     */
    public static $models = [Slide::class, SlideTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $sliderKey = $this->parameter('key', 'main');

        /** @var Collection $result */
        $result = Slide::published()
            ->where('slider', $sliderKey)
            ->sorting()
            ->get();

        $result = $result->filter(function (Slide $slide) {
            return $slide->imageExists('medium', 'image') && $slide->imageExists('medium', 'image_mobile');
        });

        if ($result->isEmpty()) {
            return null;
        }

        return compact('result');
    }
}
