<?php

use Jaxon\Di\Container;
use Lagdo\DbAdmin\Db\Config;
use Lagdo\DbAdmin\Db\DbAdminPackage;
use Lagdo\DbAdmin\Db\DbAuditPackage;

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
                    'lib' => 'notyf',
                ],
                'provider' => function(array $options, Container $di) {
                    $reader = $di->g(Config\UserFileReader::class);
                    return $reader->getOptions($options);
                },
                'config' => [
                    'reader' => Config\InfisicalConfigReader::class,
                ],
                'access' => [
                    'server' => true,
                    'system' => false,
                ],
            ],
            DbAuditPackage::class => [
                'config' => [
                    'reader' => Config\InfisicalConfigReader::class,
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
                'use' => ['notyf'],
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
