<?php
return [
    'doctrine' => [
        'driver' => [
            'ajasta_invoice_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/doctrine',
            ],
            'orm_default' => [
                'drivers' => [
                    'Ajasta\Invoice\Entity' => 'ajasta_invoice_entity',
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'invoices' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/invoices',
                    'defaults' => [
                        'controller' => 'Ajasta\Invoice\Controller\InvoiceController',
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
                            'route' => '/edit/:invoiceId',
                            'defaults' => [
                                'action' => 'edit',
                            ],
                            'constraints' => [
                                'invoiceId' => '\d+',
                            ],
                        ],
                    ],
                    'show' => [
                        'type' => 'segment',
                        'options' => [
                            'route' => '/show/:invoiceId',
                            'defaults' => [
                                'action' => 'show',
                            ],
                            'constraints' => [
                                'invoiceId' => '\d+',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
        'default' => [
            'invoices' => ['label' => 'Invoices', 'route' => 'invoices', 'order' => 200],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Ajasta\Invoice\Controller\InvoiceController' => 'Ajasta\Invoice\Controller\InvoiceControllerFactory',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Ajasta\Invoice\Options' => 'Ajasta\Invoice\OptionsFactory',
            'Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorInterface'
                => 'Ajasta\Invoice\Service\InvoiceNumberGenerator\GeneratorFactory',
            'Ajasta\Invoice\Service\InvoicePersistenceStrategy\StrategyInterface'
                => 'Ajasta\Invoice\Service\InvoicePersistenceStrategy\StrategyFactory',
            'Ajasta\Invoice\Service\InvoiceService' => 'Ajasta\Invoice\Service\InvoiceServiceFactory',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'Ajasta\Invoice\Form\InvoiceForm' => 'Ajasta\Invoice\Form\InvoiceForm',
            'Ajasta\Invoice\Form\InvoiceItemFieldset' => 'Ajasta\Invoice\Form\InvoiceItemFieldset',
        ],
        'factories' => [
            'Ajasta\Invoice\Form\InvoiceFieldset' => 'Ajasta\Invoice\Form\InvoiceFieldsetFactory',
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Ajasta\Invoice\Hydrator\InvoiceHydrator' => 'Ajasta\Invoice\Hydrator\InvoiceHydratorFactory',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'invoiceOptions' => 'Ajasta\Invoice\View\Helper\InvoiceOptionsFactory',
        ],
    ],
    'view_manager' => [
        'controller_map' => [
            'Ajasta\Invoice' => true,
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
