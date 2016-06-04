<?php
return [
    'dependencies' => [
        'factories' => [
            Ajasta\Infrastructure\Middleware\Client\UpdateClient::class =>
                Ajasta\Factory\Infrastructure\Middleware\Client\UpdateClientFactory::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'client.update',
            'path' => '/client/update',
            'middleware' => Ajasta\Infrastructure\Middleware\Client\UpdateClient::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
    ],
];
