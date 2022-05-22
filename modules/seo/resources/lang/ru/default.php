<?php

use WezomCms\Core\Enums\TranslationSide;

return [
    TranslationSide::ADMIN => [
        'SEO' => 'SEO',
        'Settings' => 'Настройки',
        'Metrics' => 'Метрики',
        'Inside head tag' => 'Внутри тега <head>',
        'Inside body tag' => 'Внутри тега <body>',
        'Robots' => 'robots.txt',
        'Content' => 'Содержимое',
        'For correct operation, the server should not have a robots file' => 'Для корректной работы на сервере не должно быть файла <strong>robots.txt</strong> в директории <strong>public</strong>',
        'links' => [
            'Links' => 'Ссылки',
            'Name' => 'Название',
            'Link' => 'Ссылка',
            'Relative reference' => 'Относительная ссылка',
            'Link from' => 'Ссылка с',
            'Link to' => 'Ссылка на',
            'SEO links' => 'SEO ссылки',
        ],
        'redirects' => [
            'Name' => 'Название',
            'Link' => 'Ссылка',
            'Relative reference' => 'Относительная ссылка',
            'Link from' => 'Ссылка с',
            'Link to' => 'Ссылка на',
            'Redirects' => 'Перенаправления',
            'Redirects list' => 'Список перенаправлений',
            'SEO redirects' => 'SEO перенаправления',
            'HTTP status' => 'HTTP статус ответа',
            'HTTP status not required' => 'HTTP статус ответа (не обязательный, по умолчанию 301)',
            '301 Moved Permanently «перемещено навсегда»' => '301 Moved Permanently («перемещено навсегда»)',
            '302 Moved Temporarily «перемещено временно»' => '302 Moved Temporarily («перемещено временно»)',
            '303 See Other смотреть другое' => '303 See Other (смотреть другое)',
            '307 Temporary Redirect «временное перенаправление»' => '307 Temporary Redirect («временное перенаправление»)',
            'File' => 'Файл',
            'Redirects import' => 'Импорт редиректов',
            'Import' => 'Загрузить',
            'Import redirects from file' => 'Ипрорт редиректов с файла',
            'File structure' => 'Структура файла',
            'Import successfully completed' => 'Импорт успешно выполнен',
            'Go to site, check link' => 'Перейти на сайт (проверить ссылку/редирект)',
        ],
    ],
    TranslationSide::SITE => [
    ],
];
