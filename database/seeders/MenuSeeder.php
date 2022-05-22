<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use WezomCms\Menu\Models\Menu;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!$menus = Menu::count()) {
            $lang = 'ru';
            foreach ($this->menus() as $group => $menu) {
                foreach ($menu as $key => $item) {
                    $item[$lang]['url'] = $item[$lang]['url'] ?? '#';
                    $item['group'] = $group;
                    $item['sort'] = $key;

                    $newItem = Menu::create(Arr::except($item, ['children']));

                    if (isset($item['children'])) {
                        foreach ($item['children'] as $subKey => $subItem) {
                            $subItem[$lang]['url'] = $subItem[$lang]['url'] ?? '#';
                            $subItem['group'] = $group;
                            $subItem['sort'] = $subKey;
                            $subItem['parent_id'] = $newItem->id;

                            Menu::create($subItem);
                        }
                    }
                }
            }
        }
    }

    /**
     * @return array
     */
    public function menus()
    {
        $menus = [
            Menu::HEADER_GROUP => [
                [
                    'ru' => [
                        'name' => 'Компания',
                        'url' => 'about'
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Новости',
                        'url' => 'news'
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'FAQ',
                        'url' => 'faq'
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Доставка и оплата',
                        'url' => 'page/dostavka-i-oplata'
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Контакты',
                        'url' => 'contacts'
                    ]
                ],
            ],
            Menu::HEADER_CATALOG_GROUP => [
                [
                    'ru' => [
                        'name' => 'Бытовая техника',
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Электроника',
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Компьютерная техника',
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Детские товары',
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Акции',
                    ],
                ],
            ],
            Menu::FOOTER_GROUP => [
                [
                    'ru' => [
                        'name' => 'Каталог'
                    ],
                    'children' => [
                        [
                            'ru' => [
                                'name' => 'Акции и скидки'
                            ]
                        ],
                        [
                            'ru' => [
                                'name' => 'Бытовая техника'
                            ]
                        ],
                        [
                            'ru' => [
                                'name' => 'Электроника'
                            ]
                        ],
                        [
                            'ru' => [
                                'name' => 'Компьютерная техника',
                            ]
                        ],
                        [
                            'ru' => [
                                'name' => 'Мебель'
                            ]
                        ],
                    ]
                ],
                [
                    'ru' => [
                        'name' => 'Компания',
                    ],
                    'children' => [
                        [
                            'ru' => [
                                'name' => 'О компании',
                                'url' => 'about'
                            ]
                        ],
                        [
                            'ru' => [
                                'name' => 'Блог',
                                'url' => 'news'
                            ]
                        ],
                        [
                            'ru' => [
                                'name' => 'Забота о клиентах'
                            ]
                        ],
                    ]
                ],
                [
                    'ru' => [
                        'name' => 'Поддержка',
                    ],
                    'children' => [
                        [
                            'ru' => [
                                'name' => 'Доставка и оплата'
                            ]
                        ],
                        [
                            'ru' => [
                                'name' => 'Условия возврата и обмена'
                            ]
                        ],
                        [
                            'ru' => [
                                'name' => 'Faq'
                            ]
                        ],
                    ]
                ],
            ],
            Menu::MOBILE_GROUP => [
                [
                    'ru' => [
                        'name' => 'Компания',
                        'url' => 'about'
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Новости',
                        'url' => 'news'
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Отзывы',
                        'url' => 'reviews'
                    ]
                ],
                [
                    'ru' => [
                        'name' => 'FAQ',
                        'url' => 'faq'
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Доставка и оплата',
                        'url' => 'page/dostavka-i-oplata'
                    ],
                ],
                [
                    'ru' => [
                        'name' => 'Контакты',
                        'url' => 'contacts'
                    ]
                ],
            ]
        ];
        return $menus;
    }
}
