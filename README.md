A database admin dashboard based on Jaxon and Adminer
=====================================================

This set of packages are a rewrite of the [Adminer](https://github.com/vrana/adminer) database management tool.

It inserts a database admin dashboard into an existing PHP application.
Thanks to the [Jaxon library](https://www.jaxon-php.org), it installs and runs in a page of the application.
All its operations are performed with Ajax requests.

## Features and current status

This application and the related packages are still being actively developed, and the provided features are still basic and need improvements.

The following features are currently available:
- Browse servers and databases.
- Show tables and views details.
- Query a table.
- Query a view.
- Execute queries in the query editor.
- Use a better editor for SQL queries.
- Save and show the query history.
- Save queries in user favorites.
- Import or export data.
- Insert, modify or delete data in a table.

The following features are either disabled or not yet implemented, and planned for future releases:
- Navigate through related tables.
- Create, alter or drop a database, table or view.
- Code completion for table and field names in the SQL editor.
- An advanced GUI-based query builder.

Howtos
------

This blog post on the `Jaxon` website explains how to install `Jaxon DbAdmin` on [Voyager](https://voyager-docs.devdojo.com), an admin panel based on the `Laravel` framework: [In english](https://www.jaxon-php.org/blog/2021/03/install-jaxon-adminer-on-voyager.html), and [in french](https://www.jaxon-php.org/blog/2021/03/installer-jaxon-adminer-dans-voyager.html).

### Jaxon DbAdmin applications

The [https://github.com/lagdo/dbadmin-app](https://github.com/lagdo/dbadmin-app) repo provides a ready-to-use application, made with the [Laravel](https://laravel.com/) dframework, and `Jaxon DbAdmin`.

The [https://github.com/lagdo/dbadmin-voyager](https://github.com/lagdo/dbadmin-voyager) repo provides a ready-to-use application, made with the [Voyager Admin](https://voyager.devdojo.com/) dashboard, and `Jaxon DbAdmin`.

The driver packages for [PostgreSQL](https://github.com/lagdo/dbadmin-driver-mysql), [MySQL](https://github.com/lagdo/dbadmin-driver-mysql) and [SQLite](https://github.com/lagdo/dbadmin-driver-sqlite) are already installed, so the user just need to add its databases in the config file.

### Docker Compose

The `docker/docker-compose.yml` file starts a demo app, as well as `PostgreSQL`, `MariaDB` and `MySQL` servers.

The `docker/sh` dir contains scripts to populate sample `PostgreSQL`, `MariaDB` and `SQLite` databases with free datasets available online.
These scripts must be executed in the `dbadmin-demo` container.

Connecting to the `MariaDB` and `MySQL` servers requires to add the following content in the `${HOME}/.my.cnf` file.
```
[mysql]
ssl-verify-server-cert = off
```

Documentation
-------------

Install the Jaxon library so it bootstraps from a config file and handles ajax requests.
Here's the [documentation](https://www.jaxon-php.org/docs/v5x/about/configuration.html).

Install this package with Composer. If a [Jaxon plugin](https://www.jaxon-php.org/docs/v5x/integrations/about.html) exists for your framework, you can also install it. It will automate the previous step.

### The database drivers

Install the drivers packages for the database servers you need to manage.
The following drivers are available:
- MySQL: [https://github.com/lagdo/dbadmin-driver-mysql](https://github.com/lagdo/dbadmin-driver-mysql)
- PostgreSQL: [https://github.com/lagdo/dbadmin-driver-pgsql](https://github.com/lagdo/dbadmin-driver-mysql)
- Sqlite: [https://github.com/lagdo/dbadmin-driver-sqlite](https://github.com/lagdo/dbadmin-driver-sqlite)

Declare the package and the database servers in the `app` section of the [Jaxon configuration file](https://www.jaxon-php.org/docs/v3x/advanced/bootstrap.html).

See the corresponding database driver package for specific database server options.

```php
    'app' => [
        // Other config options
        // ...
        'packages' => [
            Lagdo\DbAdmin\Db\DbAdminPackage::class => [
                'servers' => [
                    // The database servers
                    'pgsql_server' => [ // A unique identifier for this server
                        'driver' => 'pgsql',
                        'name' => '',     // The name to be displayed in the dashboard UI.
                        'host' => '',     // The database host name or address.
                        'port' => 0,      // The database port. Optional.
                        'username' => '', // The database user credentials.
                        'password' => '', // The database user credentials.
                    ],
                    'mysql_server' => [ // A unique identifier for this server
                        'driver' => 'mysql',
                        'name' => '',     // The name to be displayed in the dashboard UI.
                        'host' => '',     // The database host name or address.
                        'port' => 0,      // The database port. Optional.
                        'username' => '', // The database user credentials.
                        'password' => '', // The database user credentials.
                    ],
                ],
            ],
        ],
    ],
```

Insert the CSS and javascript codes in the HTML pages of your application using calls to `Jaxon\jaxon()->getCss()` and `Jaxon\jaxon()->getScript(true)`.

In the page that displays the dashboard, insert the HTML code returned by the call to `Jaxon\jaxon()->package(\Lagdo\DbAdmin\Db\DbAdminPackage::class)->getHtml()`. Two cases are then possible.

- If the dashboard is displayed on a dedicated page, make a call to `Jaxon\jaxon()->package(\Lagdo\DbAdmin\Db\DbAdminPackage::class)->ready()` in your PHP code when loading the page.

- If the dashboard is loaded with an Ajax request in a page already displayed, execute the javascript code returned the call to `Jaxon\jaxon()->package(\Lagdo\DbAdmin\Db\DbAdminPackage::class)->getReadyScript()` after the page is loaded.

### The UI builder

This package uses the [HTML UI builder](https://github.com/lagdo/ui-builder) to build UI components for various frontend frameworks.
The packages for the UI framework in use must also be installed.
The following builders are available:
- Bootstrap 5: [https://github.com/lagdo/ui-builder-bootstrap5](https://github.com/lagdo/ui-builder-bootstrap5)
- Bootstrap 4: [https://github.com/lagdo/ui-builder-bootstrap4](https://github.com/lagdo/ui-builder-bootstrap4)
- Bootstrap 3: [https://github.com/lagdo/ui-builder-bootstrap3](https://github.com/lagdo/ui-builder-bootstrap3)

In the above example, the UI will be built with Bootstrap3 components.

```php
    'app' => [
        'ui' => [
            'template' => 'bootstrap3',
        ],
    ],
```

Additional config options
-------------------------

There are other config options that can be used to customize `Jaxon DbAdmin` operation.

The `default` option sets a database server `Jaxon DbAdmin` must connect to when it starts.

```php
    'app' => [
        'packages' => [
            Lagdo\DbAdmin\Db\DbAdminPackage::class => [
                'servers' => [
                    // The database servers
                ],
                'default' => 'server_id',
            ],
        ],
    ],
```

### Access restriction

The `access` section provides a few options to restrict access to databases on any server.

If the `access.server` option is set to `false` at package level, then the access to all servers information will be forbidden, and the user will have access only to database contents.
The `access.server` option can also be set at a server level, and in this case it applies only to that specific server.

```php
    'app' => [
        'packages' => [
            Lagdo\DbAdmin\Db\DbAdminPackage::class => [
                'servers' => [
                    // The database servers
                    'server_id' => [
                        // Database options
                        'access' => [
                            'server' => true,
                        ],
                    ],
                ],
                'default' => 'server_id',
                'access' => [
                    'server' => false,
                ],
            ],
        ],
    ],
```
In this configuration, the user will get access to server information only on the server with id `server_id`.

The `access.databases` and `access.schemas` options define the set of databases and schemas the user can access.
This options can only be defined at server level, and will apply to that specific server.
The `access.schemas` option will apply only on servers which provide that feature.

```php
    'app' => [
        'packages' => [
            Lagdo\DbAdmin\Db\DbAdminPackage::class => [
                'servers' => [
                    // The database servers
                    'server_id' => [
                        // Database options
                        'access' => [
                            'server' => false,
                            'databases' => ['db1', 'db2', 'db3'],
                            'schemas' => ['public'],
                        ],
                    ],
                ],
                'default' => 'server_id',
            ],
        ],
    ],
```
In this configuration, the user will be able to get access only to three databases on the server with id `server_id`.

### Customizing the package config

The app admin may need to customize the access parameters, depending for example on the connected user account or group.

In this case, the `provider` option can be used to define a callable that returns the access options as an array,
which will then be used to configure the package.

The defined options are passed to the callable, so it can be used as a basis to build the customized config.

```php
$dbAdminOptionsGetter = function($config) {
    $config['servers']['server_mysql'] = [
        'driver' => 'mysql',
        'name' => '',     // The name to be displayed in the dashboard UI.
        'host' => '',     // The database host name or address.
        'port' => 0,      // The database port. Optional.
        'username' => '', // The database user credentials.
        'password' => '', // The database user credentials.
    ];
    $config['servers']['server_pgsql'] = [
        'driver' => 'pgsql',
        'name' => '',     // The name to be displayed in the dashboard UI.
        'host' => '',     // The database host name or address.
        'port' => 0,      // The database port. Optional.
        'username' => '', // The database user credentials.
        'password' => '', // The database user credentials.
    ];
    return $config;
};
```

```php
    'app' => [
        // Other config options
        // ...
        'packages' => [
            Lagdo\DbAdmin\Db\DbAdminPackage::class => [
                // A callable that return the access options.
                'provider' => $dbAdminOptionsGetter,
                'servers' => [],
                'default' => 'server_mysql',
                'access' => [
                    'server' => false,
                ],
            ],
        ],
    ],
```

### Debug console output

Starting from version `0.9.0`, the SQL queries that are executed can also be printed in the browser debug console,
if the `debug.queries` option is set to true.

```php
    'app' => [
        'packages' => [
            Lagdo\DbAdmin\Db\DbAdminPackage::class => [
                'debug' => [
                    'queries' => true,
                ],
                'servers' => [
                    // The database servers
                ],
            ],
        ],
    ],
```

### Data export

Databases can be exported to various types of files: SQL, CSV, and more.

The export feature is configured with two callbacks.

The `writer` callback saves the export data content in a file. It takes the content and the file name as parameters, and returns the URI to the exported file.
It must return an empty string in case of error, and the web app must be configured to return the file content on a request to the URI.

The `reader` callback takes an export file name as parameter, then reads and returns its content.

Both callbacks can use the [Jaxon Storage](https://github.com/jaxon-php/jaxon-storage), as in the example below, to read and write the exported files, which can then be saved on different types of filesystems, thanks to the [Flysystem](https://flysystem.thephpleague.com) library.

The callbacks can also save the file in different locations, depending for example on the application user.

```php
use League\Flysystem\FilesystemException;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToWriteFile;
use function Jaxon\Storage\storage;

    'app' => [
        'storage' => [
            'exports' => [
                'adapter' => 'local',
                'dir' => "/path/to/exports",
            ],
        ],
        'packages' => [
            Lagdo\DbAdmin\Db\DbAdminPackage::class => [
                'servers' => [
                    // The database servers
                ],
                'export' => [
                    'writer' => function(string $content, string $filename): string {
                        try {
                            // Make a Filesystem object with the storage.exports options.
                            $storage = storage()->get('exports');
                            $storage->write($filename, "$content\n");
                        } catch (FilesystemException|UnableToWriteFile) {
                            return '';
                        }
                        // Return the link to the exported file.
                        return "/export.php?file=$filename";
                    },
                    'reader' => function(string $filename): string {
                        try {
                            // Make a Filesystem object with the storage.exports options.
                            $storage = storage()->get('exports');
                            return !$storage->fileExists($filename) ?
                                "No file $filename found." : $storage->read($filename);
                        } catch (FilesystemException|UnableToReadFile) {
                            return "No file $filename found.";
                        }
                    },
                ],
            ],
        ],
    ],
```

### Data import (with file upload)

SQL files can be uploaded and executed on a server. This feature is implemented using the [Jaxon ajax upload](https://github.com/jaxon-php/jaxon-upload) and [Jaxon Storage](https://github.com/jaxon-php/jaxon-storage) packages, which then needs to be configured in the `Jaxon` config file.

```php
    'app' => [
        'storage' => [
            'uploads' => [
                'adapter' => 'local',
                'dir' => '/path/to/the/upload/dir',
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
    ],
```

In this example, `sql_files` is the `name` attribute of the file upload field, and of course `/path/to/the/upload/dir` needs to be writable.
Other parameters can also be defined to limit the size of the uploaded files or retrict their extensions or mime types.
the [Jaxon ajax upload documentation](https://www.jaxon-php.org/docs/v5x/features/upload.html)

Contribute
----------

- Issue Tracker: github.com/lagdo/jaxon-dbadmin/issues
- Source Code: github.com/lagdo/jaxon-dbadmin

License
-------

The project is licensed under the Apache license.
