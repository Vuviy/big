<?php

namespace WezomCms\Contacts\Widgets;

use WezomCms\Core\Foundation\Widgets\AbstractWidget;

class FooterContacts extends AbstractWidget
{
    /**
     * @return array|null
     */
    public function execute(): ?array
    {
        return [
            'settings' => settings('contacts', [])
        ];
    }
}
