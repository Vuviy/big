<?php

namespace WezomCms\Core\Settings\Fields;

class MultiInput extends AbstractField
{
    /**
     * @return string
     */
    final public function getType(): string
    {
        return static::TYPE_MULTI_INPUT;
    }
}
