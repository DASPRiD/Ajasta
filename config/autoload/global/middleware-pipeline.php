<?php
use Zend\Expressive\Container\ApplicationFactory;
use Zend\Expressive\Helper;

return [
    'dependencies' => [
        'factories' => [
            Ajasta\Infrastructure\Authentication\AuthenticationMiddleware::class =>
                Ajasta\Factory\Infrastructure\Authentication\AuthenticationMiddlewareFactory::class,
            PSR7Session\Http\SessionMiddleware::class =>
                Ajasta\Factory\Infrastructure\Http\SessionMiddlewareFactory::class,
            Helper\ServerUrlMiddleware::class => Helper\ServerUrlMiddlewareFactory::class,
            Helper\UrlHelperMiddleware::class => Helper\UrlHelperMiddlewareFactory::class,
        ],
    ],

    'middleware_pipeline' => [
        'always' => [
            'middleware' => [
                PSR7Session\Http\SessionMiddleware::class,
                Helper\ServerUrlMiddleware::class,
            ],
            'priority' => 10000,
        ],

        'routing' => [
            'middleware' => [
                ApplicationFactory::ROUTING_MIDDLEWARE,
                Helper\UrlHelperMiddleware::class,
                Ajasta\Infrastructure\Authentication\AuthenticationMiddleware::class,
                ApplicationFactory::DISPATCH_MIDDLEWARE,
            ],
            'priority' => 1,
        ],

        'error' => [
            'middleware' => [
            ],
            'error'    => true,
            'priority' => -10000,
        ],
    ],
];
