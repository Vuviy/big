<?php

use WezomCms\Core\Enums\TranslationSide;

return [
    TranslationSide::ADMIN => [
        'Callbacks' => 'Обратные звонки',
        'Callback' => 'Обратный звонок',
        'Name' => 'Имя',
        'Phone' => 'Телефон',
        'Date' => 'Дата',
        'Create new order' => 'Создать новую заявку',
        'Read' => 'Прочитано',
        'Callbacks new' => 'Новый обратный звонок',
        'email' => [
            'Callback' => 'Обратный звонок',
            'Name' => 'Имя',
            'Phone' => 'Телефон',
            'Date' => 'Дата',
            'New callback order' => 'Новый заказ обратного звонка',
            'Form data' => 'Данные',
            'Created at' => 'Отправлено',
            'Go to admin panel' => 'Перейти в админ-панель',
        ],
    ],
    TranslationSide::SITE => [
        'Name' => 'Имя',
        'Phone' => 'Телефон',
        'Form successfully submitted!' => 'Форма успешно отправлена!',
        'Error creating request!' => 'Ошибка создания заявки!',
    ],
];
