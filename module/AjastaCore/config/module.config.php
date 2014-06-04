<?php
return [
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
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            'Ajasta\Navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
        'aliases' => [
            'Zend\Authentication\AuthenticationService' => 'doctrine.authenticationservice.orm_default',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'Ajasta\Core\Form\Element\LocaleSelect' => 'Ajasta\Core\Form\Element\LocaleSelect',
            'Ajasta\Core\Form\Element\Toggle' => 'Ajasta\Core\Form\Element\Toggle',
            'Ajasta\Core\Form\Element\UnitSelect' => 'Ajasta\Core\Form\Element\UnitSelect',
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
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
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
];
