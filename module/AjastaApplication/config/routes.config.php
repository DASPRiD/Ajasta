<?php
return [
    'routes' => [
        'home' => [
            'type' => 'literal',
            'options' => [
                'route'    => '/',
                'defaults' => [
                    'controller' => 'Ajasta\Application\Controller\IndexController',
                    'action' => 'index',
                ],
            ],
        ],
        'clients' => [
            'type' => 'literal',
            'options' => [
                'route' => '/clients',
                'defaults' => [
                    'controller' => 'Ajasta\Application\Controller\ClientController',
                    'action' => 'index',
                ],
            ],
            'may_terminate' => true,
            'child_routes' => [
                'create' => [
                    'type' => 'literal',
                    'options' => [
                        'route' => '/create',
                        'defaults' => [
                            'action' => 'create',
                        ],
                    ],
                ],
                'edit' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => '/edit/:clientId',
                        'defaults' => [
                            'action' => 'edit',
                        ],
                        'constraints' => [
                            'clientId' => '\d+',
                        ],
                    ],
                ],
                'show' => [
                    'type' => 'segment',
                    'options' => [
                        'route' => '/show/:clientId',
                        'defaults' => [
                            'action' => 'show',
                        ],
                        'constraints' => [
                            'clientId' => '\d+',
                        ],
                    ],
                ],
            ],
        ],
    ],
];
