<?php
return [
    'debug' => true,
    'config_cache_enabled' => false,

    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'url' => 'mysql://dev:dev@mysql/ajasta',
                ],
            ],
        ],
    ],
];
