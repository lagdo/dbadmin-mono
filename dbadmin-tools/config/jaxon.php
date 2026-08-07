<?php

$publicDir = dirname(__DIR__, 2) . '/dbadmin-demo/public';

return [
    'app' => [
        'storage' => [
            'stores' => [
                'public' => [
                    'adapter' => 'local',
                    'dir' => $publicDir,
                ],
            ],
        ],
    ],
    'lib' => [],
];
