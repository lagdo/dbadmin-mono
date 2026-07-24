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
    'queries' => [
        'record' => [
            'library' => [
                'enabled' => false,
            ],
            'builder' => [
                'enabled' => true,
            ],
            'editor' => [
                'enabled' => true,
            ],
        ],
        'admin' => [
            'history' => [
                'show' => true,
                'distinct' => true,
                'limit' => 10,
            ],
            'favorite' => [
                'show' => true,
                'limit' => 10,
            ],
        ],
        'audit' => [
            'users' => [
                // The emails of users that are allowed to access the audit page.
                'admin@company.com',
            ],
        ],
        'database' => [
            // Same as the "servers" items, but "name" is the database name.
            'driver' => 'pgsql',
            'host' => "env(LOGGING_DB_HOST)",
            'port' => "env(LOGGING_DB_PORT)",
            'username' => "env(LOGGING_DB_USERNAME)",
            'password' => "env(LOGGING_DB_PASSWORD)",
            'name' => 'auditdb',
        ],
    ],
];
