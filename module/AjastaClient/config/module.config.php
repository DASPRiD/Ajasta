<?php
return [
    'doctrine' => [
        'driver' => [
            'ajasta_client_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/doctrine',
            ],
            'orm_default' => [
                'drivers' => [
                    'Ajasta\Client\Entity' => 'ajasta_client_entity',
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'clients' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/clients',
                    'defaults' => [
                        'controller' => 'Ajasta\Client\Controller\ClientController',
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
            'projects' => [
                'type' => 'literal',
                'options' => [
                    'route' => '/project',
                    'defaults' => [
                        'controller' => 'Ajasta\Client\Controller\ProjectController',
                    ],
                ],
                'child_routes' => [
                    'create' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/create/:clientId',
                            'defaults' => [
                                'action' => 'create',
                            ],
                            'constraints' => [
                                'clientId' => '\d+',
                            ],
                        ],
                    ],
                    'edit' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/edit/:projectId',
                            'defaults' => [
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'projectId' => '\d+',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            'clients' => [
                'label' => 'Clients',
                'route' => 'clients',
                'order' => 300,
                'pages' => [
                    ['route' => 'clients/create'],
                    ['route' => 'clients/show'],
                    ['route' => 'clients/edit'],
                    ['route' => 'contacts/create'],
                    ['route' => 'contacts/edit'],
                    ['route' => 'projects/create'],
                    ['route' => 'projects/edit'],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Ajasta\Client\Controller\ClientController' => 'Ajasta\Client\Controller\ClientControllerFactory',
            'Ajasta\Client\Controller\ProjectController' => 'Ajasta\Client\Controller\ProjectControllerFactory',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Ajasta\Client\Service\ClientService' => 'Ajasta\Client\Service\ClientServiceFactory',
            'Ajasta\Client\Service\ProjectService' => 'Ajasta\Client\Service\ProjectServiceFactory',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'Ajasta\Client\Form\ClientFieldset' => 'Ajasta\Client\Form\ClientFieldset',
            'Ajasta\Client\Form\ClientForm' => 'Ajasta\Client\Form\ClientForm',
            'Ajasta\Client\Form\ProjectFieldset' => 'Ajasta\Client\Form\ProjectFieldset',
            'Ajasta\Client\Form\ProjectForm' => 'Ajasta\Client\Form\ProjectForm',
        ],
    ],
    'view_manager' => [
        'controller_map' => [
            'Ajasta\Client' => true,
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
