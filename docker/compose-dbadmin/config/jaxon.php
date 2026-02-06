<?php

use App\Http\Middleware\DbAdminPackageConfig;
use Illuminate\Support\Str;
use Jaxon\Di\Container;
use Lagdo\DbAdmin\Db\Config\UserFileReader;
use Lagdo\DbAdmin\Db\DbAdminPackage;
use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;

use function Jaxon\storage;

function getExportStorage(): Filesystem
{
    // Make a Filesystem object with the storage.exports options.
    return storage()->get('exports');
}

function getExportPath(string $filename): string
{
    return Str::slug(auth()->user()->email) . "/$filename";
}

$uploadDir = '/home/dbadmin/uploads/';
$exportDir = '/home/dbadmin/exports/';

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
        'assets' => [
            'uri' => '/jaxon/',
            'dir' => public_path('/jaxon/'),
            'export' => true,
            'minify' => true,
        ],
        'storage' => [
            'stores' => [
                'exports' => [
                    'adapter' => 'local',
                    'dir' => $exportDir,
                ],
                'uploads' => [
                    'adapter' => 'local',
                    'dir' => $uploadDir,
                ],
            ],
        ],
        'upload' => [
            'enabled' => true,
            'files' => [
                'sql_files' => [
                    'storage' => 'uploads',
                ],
            ],
        ],
        'packages' => [
            DbAdminPackage::class => [
                'toast' => [
                    'lib' => 'notyf',
                ],
                'provider' => function(array $options, Container $di): array {
                    $reader = $di->g(UserFileReader::class);
                    return $reader->getOptions($options);
                },
                'access' => [
                    'server' => true,
                    'system' => false,
                ],
                'export' => [
                    'writer' => function(string $content, string $filename): string {
                        try {
                            $storage = getExportStorage();
                            $storage->write(getExportPath($filename), "$content\n");
                        } catch (FilesystemException|UnableToWriteFile) {
                            return '';
                        }
                        // Return the link to the exported file.
                        return "/export/$filename";
                    },
                    'reader' => function(string $filename): string {
                        try {
                            $storage = getExportStorage();
                            $filepath = getExportPath($filename);
                            return !$storage->fileExists($filepath) ?
                                "No file $filename found." : $storage->read($filepath);
                        } catch (FilesystemException|UnableToReadFile) {
                            return "No file $filename found.";
                        }
                    },
                ],
            ],
        ],
        'ui' => [
            'template' => 'bootstrap5',
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
