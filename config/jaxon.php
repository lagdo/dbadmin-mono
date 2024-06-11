<?php

return [
    'app' => [
        'request' => [
            'route' => 'jaxon',
            'middlewares' => ['web', 'jaxon.ajax'],
        ],
        'packages' => [
            Lagdo\DbAdmin\App\Package::class => [
                'template' => 'bootstrap3',
                'servers' => [
                    'voyager' => [
                        'name' => 'Voyager database',
                        'driver' => 'mysql',
                        'host' => env('DB_HOST'),
                        'port' => env('DB_PORT'),
                        'username' => env('DB_USERNAME'),
                        'password' => env('DB_PASSWORD'),
                    ],
                    // Add more databases here
                ],
                'default' => 'voyager',
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'language' => 'en',
            'encoding' => 'UTF-8',
            'request' => [
                'csrf_meta' => 'csrf-token',
            ],
            'prefix' => [
                'class' => '',
            ],
            'annotations' => [
                'enabled' => true,
            ],
            'debug' => [
                'on' => false,
                'verbose' => false,
            ],
            'error' => [
                'handle' => false,
            ],
        ],
        'js' => [
            'lib' => [
                // 'uri' => '/jaxon/lib',
            ],
            'app' => [
                'uri' => '/js',
                'dir' => public_path('js'),
                'file' => 'dbadmin-0.0.1b2',
                'export' => false,
                'minify' => false,
            ],
        ],
        'dialogs' => [
            'default' => [
                'modal' => 'bootstrap',
                'message' => 'noty',
                'question' => 'noty',
            ],
            'assets' => [
                'include' => [
                    'all' => true,
                ],
            ],
        ],
    ],
];
