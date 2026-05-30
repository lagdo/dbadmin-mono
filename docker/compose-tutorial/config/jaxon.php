<?php

use Jaxon\Di\Container;
use Lagdo\DbAdmin\App\DbAdminPackage;
use Lagdo\DbAdmin\App\DbAuditPackage;
use Lagdo\DbAdmin\Support\Provider;

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => true,
                'dir' => '/var/cache/jaxon/attributes',
            ],
        ],
        'directories' => [],
        'packages' => [
            DbAdminPackage::class => [
                'toast' => [
                    'lib' => 'butterup',
                ],
                'provider' => function(array $options, Container $di) {
                    $reader = $di->g(Provider\ConfigProvider::class);
                    return $reader->getOptions($options);
                },
                'config' => [
                    'reader' => Provider\InfisicalConfigReader::class,
                ],
                'access' => [
                    'server' => true,
                    'system' => false,
                ],
            ],
            DbAuditPackage::class => [
                'config' => [
                    'reader' => Provider\InfisicalConfigReader::class,
                ],
            ],
        ],
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'assets' => [
            'export' => true,
            'minify' => true,
            'uri' => '/jaxon/',
            'dir' => public_path('/jaxon/'),
        ],
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'sweetalert',
                'confirm' => 'sweetalert',
            ],
            'lib' => [
                'use' => ['butterup'],
            ],
        ],
    ],
    'lib' => [
        'core' => [
            'language' => 'en',
            'encoding' => 'UTF-8',
            'prefix' => [
                'class' => '',
            ],
            'request' => [
                'csrf_meta' => 'csrf-token',
                'uri' => '/jaxon', // The route url
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
                // 'uri' => '',
            ],
        ],
    ],
];
