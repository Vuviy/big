<?php

use WezomCms\Core\Enums\TranslationSide;

return [
    TranslationSide::ADMIN => [
        'Catalog' => 'Каталог',
        'Promo codes' => 'Промо коды',
        'brands' => [
            'Brand' => 'Бренд',
            'Brands' => 'Бренды',
            'Name' => 'Название',
            'Image' => 'Изображение',
            'Position' => 'Позиция',
        ],
        'catalog-seo-templates' => [
            'SEO templates' => 'SEO шаблоны',
            'Name' => 'Название',
            'Parameters' => 'Параметры',
            'H1' => 'H1',
            'Title' => 'Заголовок (title)',
            'Keywords' => 'Ключевые слова (keywords)',
            'Description' => 'Описание (description)',
            'Default product template' => 'Мета товаров по умолчанию',
            'Image template' => 'Шаблон мета изображений',
            'Category seo template meta-tags keys' => '[category] - название категории',
            'Categories meta-tags keys' => '[name] - Название, [id] - ID категории',
            'Image meta-tags keys' => '[name] - Название товара, [brand] - название бренда, [category] - название категории, [cost] - цена',
            'Categories' => 'Категории',
            'Seo text' => 'Seo текст',
            'Image alt' => 'Alt',
            'Image title' => 'Title',
        ],
        'categories' => [
            'Categories' => 'Категории',
            'Image' => 'Обложка',
            'Icon' => 'Иконка',
            'Main data' => 'Основные данные',
            'SEO' => 'SEO данные',
            'Name' => 'Название',
            'Text' => 'Текст',
            'Category description' => 'описание внизу страницы',
            'Parent' => 'Родительский элемент',
            'Root' => 'Корневой',
            'Number of root entries in the admin panel' => 'Количество отображаемых корневых элементов в админ-панели',
            'Site products limit at page' => 'Кол-во отображаемых товаров на странице списка товаров',
            'Site categories limit at page' => 'Кол-во отображаемых категорий на странице списка категорий',
            'Site root categories limit at menu' => 'Кол-во отображаемых корневых категорий в меню',
            'Show on main' => 'Показывать на главной',
            'Show on menu' => 'Показывать в меню',
            'Specifications selection is available for end categories' => 'Выбор характеристик доступен для конечных категорий',
        ],
        'models' => [
            'Models' => 'Модели',
            'Name' => 'Название',
            'Brand' => 'Бренд',
        ],
        'products' => [
            'pieces' => 'шт',
            'Products' => 'Товары',
            'Name' => 'Название',
            'Base name' => 'Базовое название',
            'Cost' => 'Цена',
            'Text' => 'Описание товара',
            'Main data' => 'Основные данные',
            'Meta data' => 'Мета данные',
            'SEO' => 'SEO',
            'Brand' => 'Бренд',
            'Model' => 'Модель',
            'Created at' => 'Создано',
            'Best offer' => 'Лучшее предложение',
            'Images' => 'Изображения',
            'Videos' => 'Видео',
            'Product' => 'Товар',
            'Please login' => 'Пожалуйста авторизуйтесь',
            'Invalid video url' => 'Недопустимое значение видео: ":input". Пример: https://youtube.com/v=31235423.',
            'Catalog' => 'Каталог',
            'Page name' => 'Название страницы',
            'For links and breadcrumbs' => 'Для названия ссылки и хлебных крошек',
            'Product meta-tags keys' => '[name] - Название, [id] - ID, [cost] - Цена',
            'Novelty' => 'Новинка',
            'Popular' => 'Популярный',
            'Sale' => 'Акция',
            'Old cost' => 'Старая цена',
            'Product type' => 'Тип товара',
            'Min length' => 'Минимальная длина',
            'Step' => 'Шаг',
            'Category' => 'Категория',
            'Labels' => 'Ярлыки',
            'Color' => 'Цвет',
            'Group key' => 'Ключ группы',
            'Specify the key by which the goods will be combined' => 'Укажите фразу (ключ) по которой будут объединяться товары',
            'Relations' => 'Связи',
            'Description image' => 'Изображение для описания',
            'Color image' => 'Изображение для иконки цвета',
            'Are available' => 'Есть в наличии',
            'Product available' => 'Товары в наличии',
            'Position' => 'Позиция',
            'Expires at' => 'Дата окончания',
            'Discount percentage' => 'Процент скидки',
            'Calculate discount price' => 'Рассчитать цену со скидкой',
            'End date of the promotion' => 'Дата окончания акции должна быть больше текущей даты',
            'Move products to another category' => 'Переместить выбранные товары в другую категорию',
            'Select new category' => 'Выберите новую категорию',
            'Please select category and products' => 'Пожалуйста выберите категорию и товары',
            'Copy product' => 'Копировать товар',
            'Copy' => 'Копировать',
            'Error copying data' => 'Ошибка при копировании',
            'Primary spec values' => 'Ключевые характеристики',
            'Features that will be available for selection when added to the cart' => 'Характеристики, которые будут доступны к выбору при добавлении в корзину',
            'Accessories' => 'Аксессуары',
            'Vendor code' => 'Артикул',
            'You cannot delete this item because there is an order with this item' => 'Вы не можете удалить этот элемент, потому что существует заказ с этим товаром',
        ],
        'search' => [
            'Search' => 'Поиск',
            'Page name' => 'Название страницы',
            'Site search limit at page' => 'Кол-во отображаемых элементов на странице',
            'Edit search settings' => 'Редактировать настройки поиска',
        ],
        'specifications' => [
            'Filter' => 'Фильтр',
            'Specifications' => 'Характеристики',
            'Name' => 'Название',
            'Values list' => 'Список значений',
            'row' => 'строка',
            'Image' => 'Иконка',
            'Create new spec value' => 'Создание новой спецификации',
            'Cancel' => 'Отмена',
            'Published' => 'Опубликовано',
            'Color' => 'Цвет',
            'Items per page' => 'Элеменов на странице:',
            'Position' => 'Позиция',
            'Multiple' => 'Мультивыбор',
        ],
    ],
    TranslationSide::SITE => [
        'catalog' => [
            'Catalog' => 'Каталог',
        ],
        'products' => [
            'Image' => 'Изображение',
            'Product' => 'Товар',
            'sort' => [
                'Default' => 'По популярности',
                'Cost asc' => 'От дешевых к дорогим',
                'Cost desc' => 'От дорогих к дешевым',
                'Created at' => 'По дате добавления',
            ],
            'pieces' => 'шт',
            'Cost' => 'Цена',
            'from' => 'от',
            'to' => 'до',
            'Novelty products' => 'Новинки',
            'Popular products' => 'Популярное',
            'Sale products' => 'Акционные товары',
            'Brand' => 'Бренд',
            'Model' => 'Модель',
            'Same products' => 'Похожие товары',
            'Viewed products' => 'Просмотренные товары',
            'With this product buy' => 'Вместе с этим товаром покупают',
            'Product group' => 'Группа товаров',
        ],
        'search' => [
            'Search' => 'Поиск',
            'Search query' => 'Строка поиска',
            'Search result :search' => 'Результаты поиска :search',
        ],
        'filter' => [
            'Novelty' => 'Новинка',
            'Popular' => 'Популярное',
            'Sale' => 'Акция',
            'Tags' => 'Метки',
        ],
        'flags' => [
            'Sale' => 'Акция',
            'Popular' => 'Популярное',
            'Novelty' => 'Новинка',
            'All novelty' => 'Все новинки',
            'All popular' => 'Все популярные товары',
            'All sale' => 'Все акционные товары',
        ],
    ],
];