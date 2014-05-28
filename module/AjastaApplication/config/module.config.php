<?php
return [
    'doctrine' => [
        'driver' => [
            'application_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/doctrine',
            ],
            'orm_default' => [
                'drivers' => [
                    'Ajasta\Application\Entity' => 'application_entity',
                ],
            ],
        ],
    ],
    'router' => require __DIR__ . '/routes.config.php',
    'spiffy_navigation' => require __DIR__ . '/navigation.config.php',
    'controllers' => [
        'invokables' => [
            'Ajasta\Application\Controller\IndexController' => 'Ajasta\Application\Controller\IndexController',
        ],
        'factories' => [
            'Ajasta\Application\Controller\ClientController' => 'Ajasta\Application\Controller\ClientControllerFactory',
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            'Ajasta\Application\I18n\CurrencyInformation' => 'Ajasta\Application\I18n\CurrencyInformationFactory',
            'Ajasta\Application\Service\ClientService' => 'Ajasta\Application\Service\ClientServiceFactory',
            'Ajasta\Application\Service\OptionService' => 'Ajasta\Application\Service\OptionServiceFactory',
        ],
        'aliases' => [
            'Zend\Authentication\AuthenticationService' => 'doctrine.authenticationservice.orm_default',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'Ajasta\Application\Form\ClientFieldset' => 'Ajasta\Application\Form\ClientFieldset',
            'Ajasta\Application\Form\ClientForm' => 'Ajasta\Application\Form\ClientForm',
            'Ajasta\Application\Form\Element\LocaleSelect' => 'Ajasta\Application\Form\Element\LocaleSelect',
            'Ajasta\Application\Form\Element\Toggle' => 'Ajasta\Application\Form\Element\Toggle',
            'Ajasta\Application\Form\Element\UnitSelect' => 'Ajasta\Application\Form\Element\UnitSelect',
        ],
        'factories' => [
            'Ajasta\Application\Form\Element\CurrencySelect' => 'Ajasta\Application\Form\Element\CurrencySelectFactory',
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'controller_map' => [
            'Ajasta\Application' => true,
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
    'dynamic_option_defaults' => [
        'invoice.email.sender-address' => ['type' => 'string', 'value' => 'example@localhost'],
        'invoice.email.sender-name' => ['type' => 'string', 'value' => 'Example'],
        'invoice.default.value-added-tax' => ['type' => 'decimal', 'value' => '0'],
        'invoice.default.unit' => ['type' => 'string', 'value' => 'hours'],
        'invoice.default.unit-price' => ['type' => 'decimal', 'value' => '0'],
        'invoice.invoice-incrementer' => ['type' => 'integer', 'value' => 1],
    ],
];
