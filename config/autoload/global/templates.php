<?php
return [
    'dependencies' => [
        'factories' => [
            'Zend\Expressive\FinalHandler' =>
                Zend\Expressive\Container\TemplatedErrorHandlerFactory::class,

            Zend\Expressive\Template\TemplateRendererInterface::class =>
                Zend\Expressive\Plates\PlatesRendererFactory::class,

            Ajasta\Infrastructure\View\Extension\AddressExtension::class =>
                Ajasta\Factory\Infrastructure\View\Extension\AddressExtensionFactory::class,
        ],
    ],

    'templates' => [
        'extension' => 'phtml',
        'paths' => [
            'form' => ['templates/form'],
            'common' => ['templates/common'],
            'address' => ['templates/address'],
            'client' => ['templates/client'],
            'layout' => ['templates/layout'],
            'error'  => ['templates/error'],
        ],
    ],

    'plates' => [
        'extensions' => [
            Ajasta\Infrastructure\View\Extension\AddressExtension::class,
        ],
    ],
];
