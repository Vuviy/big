<?php

namespace WezomCms\MediaBlocks\Widgets;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;
use WezomCms\Core\Models\Translation;
use WezomCms\MediaBlocks\Models\MediaBlock;
use WezomCms\MediaBlocks\Models\MediaBlockTranslation;

class MediaBlocks extends AbstractWidget
{
    public static $models = [MediaBlock::class, MediaBlockTranslation::class, Translation::class];

    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        $type = array_get($this->data, 'type', 'top-categories-1');
        $limit = array_get($this->data, 'limit', 8);

        $result = MediaBlock::whereType($type)
            ->published()
            ->orderBy('sort')
            ->latest('id')
            ->limit($limit)
            ->get();

        $result = $result->filter(function (MediaBlock $slide) {
            return $slide->imageExists() || $slide->fileExists('video');
        });

        if ($result->isEmpty()) {
            return null;
        }

        return compact('result');
    }
}
