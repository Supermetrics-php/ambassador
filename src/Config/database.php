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
                'host' => getenv('REDIS_HOST', '127.0.0.1'),
                'username' => getenv('REDIS_USERNAME'),
                'password' => getenv('REDIS_PASSWORD'),
                'port' => getenv('REDIS_PORT', '6379'),
                'database' => getenv('REDIS_DB', '0'),
            ],
        ],
    ],
    'cache' => [
        'redis' => [
            'default' => [
                'scheme' => 'tcp',
                'ttl' => '10',
                'host' => getenv('REDIS_HOST', '127.0.0.1'),
                'username' => getenv('REDIS_USERNAME'),
                'password' => getenv('REDIS_PASSWORD'),
                'port' => getenv('REDIS_PORT', '6379'),
                'database' => getenv('REDIS_CACHE_DB', '1'),
            ],
        ],
    ],
];
