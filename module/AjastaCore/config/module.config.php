<?php
return [
    'doctrine' => [
        'driver' => [
            'ajasta_core_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/doctrine',
            ],
            'orm_default' => [
                'drivers' => [
                    'Ajasta\Core\Entity' => 'ajasta_core_entity',
                ],
            ],
        ],
        'configuration' => [
            'orm_default' => [
                'types' => [
                    'optiontypeenum' => 'Ajasta\Core\Dbal\Type\OptionTypeEnumType',
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Ajasta\Core\Controller\IndexController',
                        'action' => 'index',
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            'home' => ['label' => 'Home', 'route' => 'home', 'order' => 100],
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Ajasta\Core\Controller\IndexController' => 'Ajasta\Core\Controller\IndexController',
        ],
        'factories' => [
            'Ajasta\Core\Controller\ClientController' => 'Ajasta\Core\Controller\ClientControllerFactory',
            'Ajasta\Core\Controller\OptionController' => 'Ajasta\Core\Controller\OptionControllerFactory',
            'Ajasta\Core\Controller\ProjectController' => 'Ajasta\Core\Controller\ProjectControllerFactory',
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            'Ajasta\Core\I18n\CurrencyInformation' => 'Ajasta\Core\I18n\CurrencyInformationFactory',
            'Ajasta\Core\Service\ClientService' => 'Ajasta\Core\Service\ClientServiceFactory',
            'Ajasta\Core\Service\OptionService' => 'Ajasta\Core\Service\OptionServiceFactory',
            'Ajasta\Core\Service\ProjectService' => 'Ajasta\Core\Service\ProjectServiceFactory',
            'Ajasta\Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
        'aliases' => [
            'Zend\Authentication\AuthenticationService' => 'doctrine.authenticationservice.orm_default',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'Ajasta\Core\Form\ClientFieldset' => 'Ajasta\Core\Form\ClientFieldset',
            'Ajasta\Core\Form\ClientForm' => 'Ajasta\Core\Form\ClientForm',
            'Ajasta\Core\Form\Element\LocaleSelect' => 'Ajasta\Core\Form\Element\LocaleSelect',
            'Ajasta\Core\Form\Element\Toggle' => 'Ajasta\Core\Form\Element\Toggle',
            'Ajasta\Core\Form\Element\UnitSelect' => 'Ajasta\Core\Form\Element\UnitSelect',
            'Ajasta\Core\Form\ProjectFieldset' => 'Ajasta\Core\Form\ProjectFieldset',
            'Ajasta\Core\Form\ProjectForm' => 'Ajasta\Core\Form\ProjectForm',
        ],
        'factories' => [
            'Ajasta\Core\Form\Element\CurrencySelect' => 'Ajasta\Core\Form\Element\CurrencySelectFactory',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'displayUnit'      => 'Ajasta\Core\View\Helper\DisplayUnit',
            'displayUnitPrice' => 'Ajasta\Core\View\Helper\DisplayUnitPrice',
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
            'Ajasta\Core' => true,
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
