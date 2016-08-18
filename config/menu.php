<?php

return [
            [
                'label' => '首页',
                'icon' => 'ion-ios-home',
                'uri' => '/',
            ],
            [
                'label' => '技巧',
                'icon' => 'ion-ios-paper-outline',
                'submenus' => [
                    [
                        'label' => '所有技巧',
                        'uri' => 'tricks',
                    ],
                ],
            ],
            [
                'label' => '分类',
                'icon' => 'ion-ios-folder-outline',
                'submenus' => [
                    [
                        'label' => '所有分类',
                        'uri' => 'categories',
                    ],
                    [
                        'label' => '新增分类',
                        'uri' => 'categories/create',
                    ],
                ],
            ],
            [
                'label' => '标签',
                'icon' => 'ion-ios-pricetags-outline',
                'submenus' => [
                    [
                        'label' => '所有标签',
                        'uri' => 'tags',
                    ],
                    [
                        'label' => '新增标签',
                        'uri' => 'tags/create',
                    ],
                ],
            ],
            [
                'label' => '友情链接',
                'icon' => 'ion-ios-infinite',
                'submenus' => [
                    [
                        'label' => '所有链接',
                        'uri' => 'links',
                    ],
                    [
                        'label' => '新增链接',
                        'uri' => 'links/create',
                    ],
                ],
            ],
            [
                'label' => '网站设置',
                'icon' => 'ion-ios-gear',
                'submenus' => [
                    [
                        'label' => '网站设置',
                        'uri' => 'settings',
                    ],
                    [
                        'label' => '密码修改',
                        'uri' => 'users/password',
                    ],
                ],
            ],
        ];
