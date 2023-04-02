<?php

/**
 * ENV will be loaded.
 */
loadENV();

return [
    /*
    |--------------------------------------------------------------------------
    | Default Storage
    |--------------------------------------------------------------------------
    |
    | The Supported Providers:
    | - redis
    | - file
    | - mysql
    | - mongo
    |
    */

    'default' => 'redis',

    'connections' => [
        'redis' => [
            'default' => [
                'scheme' => 'tcp',
                'ttl' => '-1',
                'host' => $_ENV['REDIS_HOST'],
                'username' => $_ENV['REDIS_USERNAME'],
                'password' => $_ENV['REDIS_PASSWORD'],
                'port' => $_ENV['REDIS_PORT'],
                'database' => $_ENV['REDIS_DB'],
            ],
        ],
        'file' => [
            'default' => [
                'path' => $_ENV['FILE_PATH'],
            ],
            'production' => [
                //  Cluster Info (Minio, AWS Object Storage, ...)
            ]
        ]
    ],
    'cache' => [
        'redis' => [
            'default' => [
                'scheme' => 'tcp',
                'ttl' => -1,
                'host' => $_ENV['REDIS_HOST'],
                'username' => $_ENV['REDIS_USERNAME'],
                'password' => $_ENV['REDIS_PASSWORD'],
                'port' => $_ENV['REDIS_PORT'],
                'database' => $_ENV['REDIS_CACHE_DB'],
            ],
        ],
    ],
];
