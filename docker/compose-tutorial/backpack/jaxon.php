<?php

use App\Infisical\InfisicalConfigReader;
use Infisical\SDK\InfisicalSDK;
use Jaxon\Di\Container;
use Lagdo\DbAdmin\Db\Config\AuthInterface;
use Lagdo\DbAdmin\Db\Config\ConfigProvider;
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
        /*'request' => [
            'route' => 'jaxon.ajax', // The route name
            'middlewares' => [
                'web', // Includes the Illuminate\Session\Middleware\StartSession
                // middleware, which returns a 419 error when the sessions has expired.
                DbAdminPackageConfig::class,
            ],
	    ],*/
        'directories' => [],
        'packages' => [
            DbAdminPackage::class => [
                'toast' => [
                    'lib' => 'butterup',
                ],
                'provider' => function(array $options, Container $di) {
                    $reader = $di->g(ConfigProvider::class);
                    return $reader->getOptions($options);
                },
                'config' => [
                    'reader' => InfisicalConfigReader::class,
                ],
                'access' => [
                    'server' => true,
                    'system' => false,
                ],
            ],
            DbAuditPackage::class => [
                'config' => [
                    'reader' => InfisicalConfigReader::class,
                ],
            ],
        ],
        'container' => [
            'set' => [
                InfisicalConfigReader::class => function(Container $di) {
                    $auth = $di->get(AuthInterface::class);

                    $infisicalSdk = new InfisicalSDK(env('INFISICAL_SERVER_URL'));
                    $clientId = env('INFISICAL_MACHINE_CLIENT_ID');
                    $clientSecret = env('INFISICAL_MACHINE_CLIENT_SECRET');
                    // Authenticate on the Infisical server.
                    $infisicalSdk->auth()->universalAuth()->login($clientId, $clientSecret);
                    // Create the Infisical secrets service.
                    $secrets = $infisicalSdk->secrets();
                    $projectId = env('INFISICAL_PROJECT_ID');
                    return new InfisicalConfigReader($auth, $secrets, $projectId, 'dev');
                },
            ],
        ],
        'ui' => [
            'template' => 'bootstrap4',
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
