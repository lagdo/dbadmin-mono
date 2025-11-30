<?php

use App\Http\Middleware\DbAdminPackageConfig;
use Illuminate\Support\Str;
use Lagdo\DbAdmin\Config\UserFileReader;

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => true,
                'dir' => storage_path('jaxon/attributes'),
            ],
        ],
        'request' => [
            'route' => 'jaxon.ajax', // The route name
            'middlewares' => [
                'web', // Includes the Illuminate\Session\Middleware\StartSession
                // middleware, which returns a 419 error when the sessions has expired.
                DbAdminPackageConfig::class,
            ],
        ],
        'directories' => [],
        'packages' => [
            Lagdo\DbAdmin\DbAdminPackage::class => [
                'provider' => function(array $options): array {
                    $di = jaxon()->di();
                    $cfgFilePath = $di->g('dbadmin_config_file_path');
                    /** @var UserFileReader */
                    $reader = $di->g(UserFileReader::class);
                    return $reader->getOptions($cfgFilePath, $options);
                },
                'export' => [
                    'writer' => function(string $content, string $filename): bool|int {
                        $exportDir = '/home/dbadmin/exports/' . Str::slug(auth()->user()->email);
                        @mkdir($exportDir, 0755, true);
                        return @file_put_contents("$exportDir/$filename", "$content\n");
                    },
                    'reader' => function(string $filename): string {
                        $exportDir = '/home/dbadmin/exports/' . Str::slug(auth()->user()->email);
                        $filepath = "$exportDir/$filename";
                        return !is_dir($exportDir) || !is_file($filepath) ?
                            "No file $filepath found." : file_get_contents($filepath);
                    },
                    'url' => fn(string $filename): string => "/export/$filename",
                ],
                'access' => [
                    'server' => true,
                    'system' => false,
                ],
            ],
        ],
        'ui' => [
            'template' => 'bootstrap5',
        ],
        'dialogs' => [
            'default' => [
                'modal' => 'bootbox',
                'alert' => 'toastr',
                'confirm' => 'noty',
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
            ],
            'app' => [
                'uri' => '/jaxon/',
                'dir' => public_path('/jaxon/'),
                'export' => false,
                'minify' => false,
            ],
        ],
    ],
];
