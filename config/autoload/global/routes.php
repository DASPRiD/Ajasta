<?php
return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
        ],
        'factories' => [
            Ajasta\Infrastructure\Middleware\Dashboard::class =>
                Ajasta\Factory\Infrastructure\Middleware\DashboardFactory::class,
            Ajasta\Infrastructure\Middleware\Login::class =>
                Ajasta\Factory\Infrastructure\Middleware\LoginFactory::class,
            Ajasta\Infrastructure\Middleware\Logout::class =>
                Ajasta\Factory\Infrastructure\Middleware\LogoutFactory::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'dashboard',
            'path' => '/',
            'middleware' => Ajasta\Infrastructure\Middleware\Dashboard::class,
            'allowed_methods' => ['GET'],
        ],
        [
            'name' => 'login',
            'path' => '/login',
            'middleware' => Ajasta\Infrastructure\Middleware\Login::class,
            'allowed_methods' => ['GET', 'POST'],
        ],
        [
            'name' => 'logout',
            'path' => '/logout',
            'middleware' => Ajasta\Infrastructure\Middleware\Logout::class,
            'allowed_methods' => ['GET'],
        ],
    ],
];
