<?php

use App\Http\Middleware\DbAdminPackageConfig;
use App\Infisical\InfisicalConfigReader;
use Infisical\SDK\InfisicalSDK;
use Jaxon\Di\Container;
use Lagdo\DbAdmin\Db\Config\AuthInterface;
use Lagdo\DbAdmin\Db\Config\UserFileReader;
use Lagdo\DbAdmin\Db\DbAdminPackage;

return [
    'app' => [
        'metadata' => [
            'cache' => [
                'enabled' => true,
                'dir' => '/var/cache/jaxon/attributes',
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
            DbAdminPackage::class => [
                'provider' => function(array $options) {
                    $di = jaxon()->di();
                    $reader = $di->g(UserFileReader::class);
                    $cfgFilePath = $di->g('dbadmin_config_file_path');
                    return $reader->getOptions($cfgFilePath, $options);
                },
                'config' => [
                    'reader' => InfisicalConfigReader::class,
                ],
                'access' => [
                    'server' => true,
                    'system' => false,
                ],
            ],
        ],
        'container' => [
            'set' => [
                InfisicalConfigReader::class => function(Container $di) {
                    $auth = $di->g(AuthInterface::class);

                    $infisicalSdk = new InfisicalSDK(env('INFISICAL_SERVER_URL'));
                    $clientId = env('INFISICAL_MACHINE_CLIENT_ID');
                    $clientSecret = env('INFISICAL_MACHINE_CLIENT_SECRET');
                    // Authenticate on the Infisical server.
                    $infisicalSdk->auth()->universalAuth()->login($clientId, $clientSecret);
                    // Create the Infisical secrets service.
                    $secrets = $infisicalSdk->secrets();
                    $projectId = env('INFISICAL_PROJECT_ID');
                    return new  InfisicalConfigReader($auth, $secrets, $projectId, 'dev');
                },
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
