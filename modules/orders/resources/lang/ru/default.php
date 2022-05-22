<?php

use WezomCms\Core\Enums\TranslationSide;

return [
    TranslationSide::ADMIN => [
        'pieces' => 'шт',
        'Invalid city' => 'Выбранное значение города некорректно',
        'orders' => [
            'Orders' => 'Заказы',
            'New orders' => 'Новые заказы',
            'Create new order' => 'Создать новый заказ',
            'Order: :number from: :date' => 'Заказ №:number, от :date',
            'Full name' => 'ФИО',
            'Name' => 'Имя',
            'Surname' => 'Фамилия',
            'Patronymic' => 'Отчество',
            'User' => 'Пользователь',
            'Phone' => 'Телефон',
            'Email' => 'Email',
            'Count items/Total cost' => 'Кол-во товаров/На сумму',
            'Status' => 'Статус',
            'Date' => 'Дата',
            'Back' => 'Вернуться',
            'Items list' => 'Список товаров',
            'Add item' => 'Добавить товар',
            'Delete item' => 'Удалить товар',
            'Client' => 'Клиент',
            'Delivery' => 'Доставка',
            'Payment' => 'Оплата',
            'Changed' => 'Изменен',
            'Payment method' => 'Способ оплаты',
            'Payed' => 'Оплачен',
            'Payment status is set: :mode :time' => 'Статус оплаты установлен: :mode (:time)',
            'Recipient' => 'Получатель',
            'Comment' => 'Комментарий',
            'Me' => 'Я',
            'Another man' => 'Другой человек',
            'Delivery type' => 'Тип',
            'Delivery method' => 'Метод',
            'Address' => 'Адрес',
            'TTN' => 'ТТН',
            'Image' => 'Изображение',
            'Product name' => 'Название',
            'Price' => 'Цена',
            'Purchase price' => 'Цена (при покупке)',
            'Quantity' => 'Кол-во',
            'Promo code applied' => 'Применен промокод',
            'Promo code not applied' => 'Промокод не применен',
            'Promo code discount' => 'Скидка по промокоду: :discount',
            'Total' => 'Итого',
            'Category' => 'Категория',
            'Product' => 'Товар',
            'Item successfully stored' => 'Товар успешно сохранен',
            'Thanks page' => 'Страница благодарности',
            'History' => 'История',
            'No comments' => 'Комментарии отсутствуют',
            'No orders' => 'Заказы отсутствуют',
            'Custom' => 'Свой вариант',
            'New order: :type' => 'Новый заказ: :type',
            'Go to admin panel' => 'Перейти в Админ-панель',
            'Form data' => 'Данные',
            'Created at' => 'Создано',
            'View order' => 'Просмотреть заказ',
            'Link' => 'Сссылка',
            'Order ID' => 'Номер заказа',
            'See all orders' => 'Посмотреть все заказы',
            'Orders history' => 'История заказов',
            'Product deleted' => 'Товар удален',
            'E-mail' => 'E-mail',
            'Dont call back' => 'Не нужно перезванивать',
            'Order status has been changed' => 'Статус заказа был изменен',
            'Order №:number' => 'Заказ №:number',
            'Locality' => 'Населенный пункт',
            'Delivery cost' => 'Стоимость доставки',
            'Orders history limit at page in LK' => 'Кол-во заказов на странице (история заказов в ЛК пользователя)',
            'Orders history page name at page in LK' => 'Название страницы (история заказов в ЛК пользователя)',
        ],
        'payed_modes' => [
            'manual' => 'Вручную',
            'auto' => 'Автоматически',
        ],
        'payment_types' => [
            'cloud-payment' => 'Картой онлайн',
        ],
        'deliveries' => [
            'pickup' => 'Самовывоз',
            'postal' => 'Почтовое отделение',
            'courier' => 'Адресная доставка',
            'Deliveries' => 'Способы доставки',
            'Name' => 'Название',
            'Delivery type' => 'Тип доставки',
            'Payments' => 'Способы оплаты',
        ],
        'payments' => [
            'Payments' => 'Способы оплаты',
            'Name' => 'Название',
            'Published' => 'Опубликован',
            'payed_modes' => [
                'manual' => 'Вручную',
                'auto' => 'Автоматически',
            ],
            'Payment order' => 'Оплата заказа :order',
            'LiqPay' => 'LiqPay',
            'Public key' => 'Публичный ключ',
            'Private key' => 'Приватный ключ',
            'Sandbox mode' => 'Режим песочницы',
            'Enabled' => 'Включено',
            'Text' => 'Текст',
            'Description payment' => 'Описание оплаты',
        ],
        'email' => [
            'New order' => 'Новый заказ',
            'Order has been paid' => 'Заказ был оплачен',
            'Form data' => 'Данные',
            'Created at' => 'Создан',
            'Paid at' => 'Оплачено',
            'Go to admin panel' => 'Перейти в админ-панель',
            'Payment method' => 'Способ оплаты',
            'Full name' => 'Имя фамилия',
            'Phone' => 'Телефон',
            'Email' => 'Email',
            'Comment' => 'Комментарий',
            'Contact data' => 'Контактные данные',
            'Recipient data' => 'Данные получателя',
            'Order info' => 'Информация о товарах',
            'Delivery type' => 'Способ доставки',
            'Delivery address' => 'Адресс доставки',
            'Delivery variant' => 'Вариант доставки',
            'Payment order' => 'Заказ оплачен:',
            'Product name' => 'Название товара',
            'Amount' => 'Количество',
            'Order cost' => 'Стоимость заказа',
            'Price' => 'Цена',
            'Purchase price' => 'Цена (при покупке)',
            'TTN' => 'ТТН',
            'Delivery and Payment' => 'Доставка и оплата',
            'Count products' => 'Количество товаров',
            'Image' => 'Изображение',
        ],
        'statuses' => [
            'Order statuses' => 'Статусы заказов',
            'Statuses' => 'Статусы',
            'Name' => 'Название',
            'Color' => 'Цвет',
        ],
        'courier' => [
            'Street' => 'Улица',
            'House' => 'Дом',
            'Room' => 'Квартира',
            'Address' => 'Адрес',
        ],
        'pickup' => [
            'Locality' => 'Населенный пункт',
            'Branch' => 'Отделение',
        ],
        'communication' => [
            'Communication methods' => 'Способы связи',
            'Communication method' => 'Способ связи',
            'Preferred communication methods' => 'Предпочтительные способы связи'
        ],
        'Advantages' => 'Преимущества',
        'delivery_drivers' => [
            'pickup' => 'Самовывоз',
            'courier' => 'Курьером',
        ],
    ],
    TranslationSide::SITE => [
        'pieces' => 'шт',
        'house' => 'д.',
        'room' => 'кв.',
        'Invalid city' => 'Выбранное значение города некорректно',
        'cart' => [
            'Cart is empty' => 'Ваша корзина пуста',
            'Product cannot be purchased' => 'Товар не может быть приобретен',
            'Product added to cart' => 'Товар добавлен в корзину!',
            'You have an item in your cart that is no longer available please delete it' => 'В вашей корзине есть товар которого больше нет в наличии, пожалуйста удалите его',
        ],
        'payed_modes' => [
            'manual' => 'Вручную',
            'auto' => 'Автоматически',
        ],
        'payment_types' => [
            'cloud-payment' => 'Картой онлайн',
            'legal-entity' => 'Безналичными для юридических лиц',
        ],
        'checkout' => [
            'Checkout' => 'Оформление заказа',
            'Name' => 'Имя',
            'Surname' => 'Фамилия',
            'Patronymic' => 'Отчество',
            'Email' => 'Email',
            'Phone' => 'Моб. телефон',
            'Register me' => 'Зарегистрировать меня',
            'Comment' => 'Комментарий',
            'Auth' => 'Авторизоваться',
            'You must accept the terms of the user agreement' => 'Вы должны принять условия пользовательского соглашения',
            'User with provided email or phone already exists' => 'Пользователь с указанным E-mail или телефоном уже существует',
            'User with provided email already exists' => 'Пользователь с указанным e-mail уже существует',
            'User with provided phone already exists' => 'Пользователь с указанным телефоном уже существует',
            'Branch' => 'Отделение',
            'City' => 'Город',
            'Postal office' => 'Почтовое отделение',
            'Address' => 'Адрес',
            'Locality' => 'Населенный пункт',
            'Street' => 'Улица',
            'House' => 'Дом',
            'Room' => 'Квартира',
            'Delivery' => 'Доставка',
            'Payment' => 'Оплата',
            'Enter at least 3 characters' => 'Введите хотя бы 3 символа',
            'Choose a locality from the list' => 'Выберите населённый пункт из списка',
            'Order creation error Please try later' => 'Ошибка создания заказа. Повторите попытку чуть позже',
            'Thank you for your order №:number! We will contact you soon' => 'Благодарим за Ваш заказ №:number! Мы скоро свяжемся с Вами',
            'Payment for order :order' => 'Оплата заказа №:order',
            'Repeat payment' => 'Повторить оплату',
            'Close' => 'Закрыть',
            'Failed to pay' => 'Не удалось провести оплату',
        ],
        'email' => [
            'Thank you for your order!' => 'Благодарим за Ваш заказ!',
            'Go to your personal cabinet' => 'Перейти в личный кабинет',
            'Full name' => 'Имя фамилия',
            'Phone' => 'Телефон',
            'Email' => 'Email',
            'Comment' => 'Комментарий',
            'Contact data' => 'Контактные данные',
            'Recipient data' => 'Данные получателя',
            'Order info' => 'Информация о товарах',
            'Delivery address' => 'Адресс доставки',
            'Delivery variant' => 'Вариант доставки',
            'Payment method' => 'Способ оплаты',
            'Payment order' => 'Заказ оплачен:',
            'Product name' => 'Название товара',
            'Amount' => 'Количество',
            'Order cost' => 'Стоимость заказа',
            'Price' => 'Цена',
            'Purchase price' => 'Цена (при покупке)',
            'TTN' => 'ТТН',
            'Delivery and Payment' => 'Доставка и оплата',
            'Count products' => 'Количество товаров',
            'Image' => 'Изображение',
        ],
        'communication' => [
            'Convenient way of communication' => 'Удобный способ связи',
        ],
        'auth' => [
            'Password' => 'Пароль',
            'Confirm password' => 'Подтверди пароль',
            'Register me' => 'Создать аккаунт',
            'Name' => 'Имя',
            'Surname' => 'Фамилия',
            'Email' => 'Email',
        ],
        'delivery_drivers' => [
            'pickup' => 'Самовывоз',
            'courier' => 'Курьером',
        ],
        'addresses' => [
            'city' => 'г.',
            'street' => 'ул.',
            'house' => 'д.',
            'room' => 'кв.',
        ],
        'history' => [
            'Orders history' => 'История заказов',
            'Payed' => 'Оплачен',
            'Not payed' => 'Не оплачен',
        ],
    ],
];