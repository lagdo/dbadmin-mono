<?php

return [
    'common' => [
        'access' => [
            'server' => true,
            'system' => false,
        ],
    ],
    'fallback' => [
    ],
    'users' => [
    ],
    'logging' => [
        'options' => [
            'library' => [
                'enabled' => false,
            ],
            'enduser' => [
                'enabled' => true,
            ],
            'history' => [
                'enabled' => true,
                'distinct' => true,
                'limit' => 15,
            ],
            'favorite' => [
                'enabled' => true,
                'limit' => 10,
            ],
        ],
        'database' => [
            // Same as the "servers" items, but "name" is the database name.
            'driver' => 'pgsql',
            'host' => 'postgresql-17',
            'port' => 5432,
            'username' => 'postgres',
            'password' => 'dbadmin',
            'name' => 'logging',
        ],
        'allowed' => [
            // The emails of users that are allowed to access the logging page.
        ],
    ],
];
