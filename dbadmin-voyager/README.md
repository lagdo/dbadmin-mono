## About

This is [Voyager Admin](https://voyager.devdojo.com/) dashboard, with [Jaxon DbAdmin](https://github.com/lagdo/jaxon-dbadmin) included.

![Database tables in Jaxon Db Admin](/img/tables.png "Database tables in Jaxon Db Admin")

What this package is about is presented here.

[EN] https://www.jaxon-php.org/blog/2022/01/install-jaxon-dbadmin-on-voyager.html

[FR] https://www.jaxon-php.org/blog/2022/01/installer-jaxon-dbadmin-dans-voyager.html

### Installation

Clone this repo, and install the dependencies.

```bash
composer install
```

Follow the Voyager installation steps, as described here: https://github.com/thedevdojo/voyager.
There's no need to install the `tcg/voyager` package, since it is already included with this repo.

Run the Jaxon DbAdmin installer.

> php artisan dbadmin:install

List the databases to be managed in the `config/jaxon.php` file.

Learn more about the available options here: https://github.com/lagdo/jaxon-dbadmin.

```php
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
```

By default, only the Voyager database is listed.
You may need to change the `driver` option if it is not a MySQL database.

You can also add more databases to the list, or customize the options by providing a callable that returns the options values.
You could for example return a different set of databases depending on the current user.

```php
$dbAdminOptionsGetter = function() {
    return [
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
    ];
};
```

```php
        'packages' => [
            Lagdo\DbAdmin\App\Package::class => [
                'provider' => $dbAdminOptionsGetter,
            ],
        ],
```
