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
    'view_manager' => [
        'controller_map' => [
            'Ajasta\Invoice' => true,
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
