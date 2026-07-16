<?php

$assetsDir = dirname(__DIR__, 2) . '/dbadmin-demo/public/assets';

return [
    'app' => [
        'storage' => [
            'stores' => [
                'assets' => [
                    'adapter' => 'local',
                    'dir' => $assetsDir,
                ],
            ],
        ],
    ],
    'lib' => [],
];
