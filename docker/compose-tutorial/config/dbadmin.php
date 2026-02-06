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
    'audit' => [
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
            'host' => 'env(AUDIT_DB_HOST)',
            'port' => 'env(AUDIT_DB_PORT)',
            'name' => 'auditdb',
        ],
        'allowed' => [
            // The emails of users that are allowed to access the audit page.
            'admin@company.com',
        ],
    ],
];
