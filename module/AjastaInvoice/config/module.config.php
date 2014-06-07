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
            'Ajasta\Invoice\Service\InvoiceService' => 'Ajasta\Invoice\Service\InvoiceServiceFactory',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'Ajasta\Invoice\Form\InvoiceFieldset' => 'Ajasta\Invoice\Form\InvoiceFieldset',
            'Ajasta\Invoice\Form\InvoiceForm' => 'Ajasta\Invoice\Form\InvoiceForm',
            'Ajasta\Invoice\Form\InvoiceItemFieldset' => 'Ajasta\Invoice\Form\InvoiceItemFieldset',
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
