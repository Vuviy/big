<?php

use WezomCms\Core\Enums\TranslationSide;

return [
    TranslationSide::ADMIN => [
        'currency_symbol' => '₸',
        'Phone is entered incorrectly' => 'Телефон введён неверно. Корректный формат: :format',
        'or' => 'или',
        'Page not found' => 'Страница не найдена',
        'Sorry, the page you requested was not found' => 'К сожалению, страница, которую Вы запросили, не была найдена.',
        'Server error' => 'Серверная ошибка',
        'Oops, something went wrong on our servers' => 'Упс, что-то пошло не так на наших серверах',
        'CSRF token mismatch' => 'Ваша сессия устарела. Пожалуйста отправьте форму повторно',
        'administrators' => [
            'Administrators' => 'Администраторы',
            'List of administrators' => 'Список администраторов',
            'Name' => 'ФИО',
            'E-mail' => 'E-mail',
            'Password' => 'Пароль',
            'Roles list' => 'Список ролей',
            'Status' => 'Статус',
            'Phones' => 'Телефоны',
            'Additionally' => 'Дополнительно',
            'Roles' => 'Роли',
            'Role' => 'Роль',
            'Image' => 'Изображение',
            'General manager' => 'Главный менеджер',
            'Token' => 'Токен',
        ],
        'auth' => [
            'E-Mail address' => 'E-Mail адрес',
            'Login' => 'Логин',
            'Password' => 'Пароль',
            'Forgotten Password?' => 'Забыли пароль?',
            'Sign in' => 'Войти',
            'Remember Me' => 'Запомнить меня',
            'Reset password' => 'Сбросить пароль',
            'Send Password Reset Link' => 'Отправить ссылку для сброса пароля',
            'E-Mail' => 'E-Mail',
            'New password' => 'Новый пароль',
            'Confirm password' => 'Повторите пароль',
            'Reset Password Notification' => 'Сбросить пароль',
            'Reset password receive text1' => 'Вы получаете это электронное письмо, потому что мы получили запрос на сброс пароля для вашей учетной записи.',
            'Reset Password' => 'Сбросить Пароль',
            'This password reset link will expire in :count minutes' => 'Эта ссылка для сброса пароля будет активна в течение :count минут.',
            'If you did not request a password reset no further action is required' => 'Если вы не запрашивали сброс пароля, никаких дополнительных действий не требуется.',
            'You do not have access to this section' => 'У вас нет доступа к этому разделу',
            'Come back' => 'Вернуться',
            'Access is denied!' => 'В доступе отказано!',
            'You are not allowed to access this section' => 'Вам не разрешен доступ к этому разделу',
            'Back to home' => 'Вернуться на главную',
            'For security reasons your request has been canceled Please try again later' => 'В целях безопасности ваш запрос отменен. Пожалуйста попробуйте позже.',
            'failed' => 'Имя пользователя и пароль не совпадают. Или аккаунт деактивирован.',
            'throttle' => 'Слишком много попыток входа. Пожалуйста, попробуйте еще раз через :seconds секунд.',
            'passwords' => [
                'password' => 'Пароль должен быть не менее шести символов и совпадать с подтверждением.',
                'reset' => 'Ваш пароль успешно сброшен!',
                'sent' => 'Ссылка на сброс пароля была отправлена!',
                'token' => 'Ошибочный код сброса пароля.',
                'user' => 'Не удалось найти пользователя с указанным электронным адресом.',
            ],
        ],
        'buttons' => [
            'Create' => 'Создать',
            'Create new resource' => 'Создать новую запись',
            'Settings' => 'Настройки',
            'Edit module settings' => 'Редактировать настройки модуля',
            'Save' => 'Сохранить',
            'Save and add' => 'Сохранить и добавить',
            'Save and close' => 'Сохранить и закрыть',
            'Close' => 'Закрыть',
        ],
        'dropzone' => [
            'Drop files here to upload' => 'Перетащите файлы сюда, чтобы загрузить',
            'Upload' => 'Загрузить',
            'Cancel upload' => 'Отменить загрузку',
            'Remove file' => 'Удалить файл',
        ],
        'filter' => [
            'Filter' => 'Фильтр',
            'Apply' => 'Найти',
            'Reset' => 'Очистить фильтр',
            'Unpublished' => 'Неопубликовано',
            'Published' => 'Опубликовано',
            'ID' => 'ID',
            'Name' => 'Название',
            'Publication' => 'Публикация',
            'Language' => 'Язык',
            'From' => 'от',
            'To' => 'до',
        ],
        'layout' => [
            'All rights reserved' => '© :year Все права защищены.',
            'Developed by' => 'Разработано',
            'Version :version' => 'Версия :version',
            'Dashboard' => 'Панель управления',
            'Manage' => 'Управление',
            'Save' => 'Сохранить',
            'Close' => 'Закрыть',
            'Edit' => 'Редактировать',
            'Editing' => 'Редактирование',
            'Create' => 'Создать',
            'Creating' => 'Создание',
            'Delete' => 'Удалить',
            'Are you sure?' => 'Вы уверены?',
            'This action is irreversible!' => 'Это действие необратимо!',
            'You can recover in the deleted section' => 'Вы сможете восстановить в разделе "Удаленные записи"',
            'You can recover in the :section' => 'Вы сможете восстановить в разделе ":section"',
            'Deleted records' => 'Удаленные записи',
            'Delete all trashed' => 'Удалить все записи',
            'Restore selected records?' => 'Восстановить выбранные записи?',
            'Record successfully restored' => 'Запись успешно восстановлена',
            'Record restore error' => 'Ошибка восстановления записи',
            'Restore' => 'Восстановить',
            'Yes, delete it' => 'Да, удалить!',
            'Data deleted successfully' => 'Данные успешно удалены',
            'Data deletion error' => 'Ошибка удаления данных',
            'Error saving data' => 'Ошибка сохранения данных',
            'Error creating data' => 'Ошибка создания данных',
            'Error updating data' => 'Ошибка обновления данных',
            'Data successfully created' => 'Данные успешно созданы',
            'Data successfully updated' => 'Данные успешно обновлены',
            'Record not found or was deleted' => 'Запись не найдена или была удалена',
            'Main data' => 'Основная информация',
            'Save and Add' => 'Сохранить и добавить',
            'Save and Close' => 'Сохранить и закрыть',
            'List' => 'Список',
            'Add' => 'Добавить',
            'Download' => 'Скачать',
            'View' => 'Просмотреть',
            'View / Download' => 'Просмотреть / Скачать',
            'File successfully deleted' => 'Файл успешно удалён',
            'Image successfully deleted' => 'Изображение успешно удалено',
            'Yes' => 'Да',
            'No' => 'Нет',
            'Slug' => 'Алиас',
            'Canonical URL' => 'Канонический URL',
            'Generate Slug' => 'Генерировать алиас',
            'Publication' => 'Публикация',
            'Read' => 'Прочитано',
            'Unread' => 'Не прочитано',
            'Status' => 'Статус',
            'Inactive' => 'Не активен',
            'Active' => 'Активен',
            'Published' => 'Опубликовано',
            'Unpublished' => 'Неопубликовано',
            'Settings' => 'Настройки',
            'No uploaded images!' => 'Нет загруженных изображений!',
            'Check' => 'Отметить',
            'Cover' => 'Обложка',
            'Browsing' => 'Просмотр',
            'Uploading images' => 'Загрузка изображений',
            'Add images' => 'Добавить изображения',
            'Upload all' => 'Загрузить все',
            'Check all' => 'Отметить все',
            'Uncheck all' => 'Снять все',
            'Uploaded images' => 'Загруженные изображения',
            'Delete selected' => 'Удалить выбранные элементы',
            'Cancel all' => 'Отменить все',
            'Sort updated' => 'Сортировка обновлена',
            'Not set' => 'Не указано',
            'Number of entries in the admin panel' => 'Количество отображаемых элементов в админ-панели',
            'Number of items displayed on the site' => 'Количество отображаемых элементов на сайте',
            'Insufficient data to perform the operation' => 'Недостаточно данных для выполнения операции',
            'Object not found' => 'Объект не найден',
            'No language specified' => 'Не указан язык',
            'The model must have a method getMainColumn' => 'Модель должна иметь метод "getMainColumn"',
            'to' => 'до',
            'Invalid phone value' => 'Недопустимое значение телефона: ":input". Пример: +77009333939',
            'The list is empty' => 'Список пуст',
            'Cancel' => 'Отмена',
            'Edit image' => 'Изменить',
            'Go to the website' => 'Перейти на сайт',
            'View on site' => 'Посмотреть',
            'Search address' => 'Начните вводить адрес...',
            'Crop image' => 'Обрезать изображение',
            'Rename' => 'Переименовать',
            'Name' => 'Название',
            'Alt' => 'Alt',
            'Title' => 'Title',
            'Admin panel' => 'Админ-панель',
            'Site' => 'Сайт',
            'pagination' => [
                'previous' => '&laquo; Назад',
                'next' => 'Вперёд &raquo;',
            ],
            'The attribute field is required when' => 'Поле :attribute обязательное если :other',
            'The attribute field is required' => 'Поле :attribute обязательное к заполнению',
            'Service' => 'Служебное',
            'Content' => 'Контент',
            'The recommended size of the loaded image' => 'Рекомендуемый размер загружаемого изображения',
            'No items' => 'Записи отсутствуют',
            'No items found using filter' => 'По заданным параметрам ничего не найдено. Попробуйте изменить параметры фильтра',
            'Google maps key' => 'Ключ Google Maps',
            'Yandex maps key' => 'Ключ Yandex карт',
            'Please select at least one entry to delete' => 'Пожалуйста, выберите хотя-бы одну запись для удаления',
            'Please select at least one entry to restore' => 'Пожалуйста, выберите хотя-бы одну запись для восстановления',
            'Deleting selected entries is prohibited' => 'Удаление выбранных записей запрещено',
            'Delete selected items' => 'Удалить выбранные элементы',
            'Check/Uncheck all' => 'Отметить / Убрать выбор',
            'Back' => 'Назад',
            'Trashed :title' => 'Удаленные :title',
            'Display by' => 'Выводить по',
            'Created at' => 'Создано',
            'Updated at' => 'Обновлено',
            'Copy to another lang fields' => 'Скопировать значение в другие языки',
            'Total' => 'Всего',
            'record|records' => 'запись|записи|записей',
        ],
        'menu' => [
            'Nothing found' => 'Ничего не найдено',
            'Search' => 'Поиск',
        ],
        'notifications' => [
            'Notifications' => 'Уведомления',
            'No notifications' => 'Уведомления отсутствуют',
            'Mark as read' => 'Отметить как прочитано',
            'All notifications are marked as read' => 'Все уведомления отмечены как прочитано',
        ],
        'profile' => [
            'Profile' => 'Профиль',
            'Logout' => 'Выйти',
            'Edit profile' => 'Редактировать профиль',
            'Main data' => 'Основная информация',
            'E-mail' => 'E-mail',
            'Name' => 'ФИО',
            'Update password' => 'Обновить пароль',
            'Password' => 'Пароль',
            'Confirm password' => 'Подтвердить пароль',
            'Change password' => 'Изменить пароль',
            'Receive notifications' => 'Получать уведомления',
            'API access token' => 'Токен доступа к API',
        ],
        'roles' => [
            'Roles' => 'Роли',
            'List of roles' => 'Список ролей',
            'Name' => 'Название',
            'Permissions list' => 'Список разрешений',
            'Check all' => 'Отметить все',
            'view' => 'Просматривать список',
            'show' => 'Просматривать запись',
            'create' => 'Создавать',
            'edit' => 'Редактировать',
            'delete' => 'Удалять',
            'restore' => 'Восстановить удаленное',
            'force-delete' => 'Полное удаление',
            'edit-settings' => 'Редактировать настройки',
        ],
        'seo' => [
            'H1' => 'H1',
            'Title' => 'Заголовок (title)',
            'Keywords' => 'Ключевые слова (keywords)',
            'Description' => 'Описание (description)',
            'Seo text' => 'SEO текст',
            'Name' => 'Название',
            'Link' => 'Ссылка',
        ],
        'translations' => [
            'Translations' => 'Переводы',
            'Translation' => 'Перевод',
            'Admin panel' => 'Админ-панель',
            'Site' => 'Сайт',
            'Keys' => 'Ключи',
        ],
        'translation_side' => [
            'admin' => 'Админ-панель',
            'site' => 'Сайт',
        ],
        'settings' => [
            'View' => 'Просматривать',
            'Settings' => 'Настройки',
            'Global settings' => 'Глобальные настройки',
            'Edit global settings' => 'Редактировать глобальные настройки',
            'Page name' => 'Название страницы',
            'Might be used in breadcrumbs, sitemap and some other places' => 'Может быть использовано в хлебных крошках на сайте, на карте сайта и в прочих местах',
        ],
        'js' => [
            'daterangepicker' => [
                'Apply' => 'Применить',
                'Cancel' => 'Отмена',
                'From' => 'От',
                'To' => 'До',
                'Custom' => 'Вручную',
            ],
            'tinymce' => [
                'Default' => 'По умолчанию',
                'Without border' => 'Без границ',
                'Zebra' => 'Зебра',
                'Design' => 'По дизайну',
            ],
        ],
        'video' => [
            'Video' => 'Видео',
            'The file must have the extension' => 'Файл должен иметь расширение',
            'File size must not exceed' => 'Размер файла не должен превышать',
            'The recommended resolution of the loaded video' => 'Рекомендуемое разрешение загружаемого видео файла',
        ],
        'fields' => [
            'Icon' => 'Иконка',
        ],
    ],
    TranslationSide::SITE => [
        'currency_symbol' => '₸',
        'Page not found' => 'Страница не найдена',
        'Page: :page' => 'Страница: :page',
        'The given data was invalid' => 'Введены не корректные данные',
        'Method not allowed' => 'Метод не разрешен',
        'Server error' => 'Извините, произошла ошибка сервера',
        'CSRF token mismatch' => 'Ваша сессия устарела. Пожалуйста обновите страницу и повторно отправьте форму',
        'Unauthenticated' => 'Не авторизован',
        'To many attempts Retry after :seconds seconds' => 'Слишком много запросов. Повторите после :seconds секунд',
        'To many attempts' => 'Слишком много запросов. Повторите позже',
        'For security reasons your request has been canceled Please try again later' => 'В целях безопасности ваш запрос отменен. Пожалуйста попробуйте позже.',
        'Phone is entered incorrectly' => 'Телефон введён неверно. Корректный формат: :format',
        'or' => 'или',
        'auth' => [
            'failed' => 'Имя пользователя и пароль не совпадают. Или аккаунт деактивирован.',
            'throttle' => 'Слишком много попыток входа. Пожалуйста, попробуйте еще раз через :seconds секунд.',
            'Field :attribute should doesnt match old password' => 'Поле :attribute не должно соответствовать старому паролю',
        ],
        'Data saved' => 'Данные сохранены',
        'Internal server error! Please try again later' => 'Внутренняя ошибка сервера! Пожалуйста, попробуйте позже',
        'layout' => [
            'Not set' => 'Не указано',
        ],
    ],
];
