<?php
return [
    'address_formats' => [
        'locale_data_uri' => 'http://i18napis.appspot.com/address/data',
        'data_path'       => __DIR__ . '/../data',
        'country_codes'   => require __DIR__ . '/../data/country-codes.php',
    ],
    'doctrine' => [
        'driver' => [
            'ajasta_address_entity' => [
                'class' => 'Doctrine\ORM\Mapping\Driver\XmlDriver',
                'paths' => __DIR__ . '/doctrine',
            ],
            'orm_default' => [
                'drivers' => [
                    'Ajasta\Address\Entity' => 'ajasta_address_entity',
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => [
            'get-address-fields-for-country' => [
                'type' => 'segment',
                'options' => [
                    'route' => '/get-address-fields-for-country/:countryCode',
                    'defaults' => [
                        'controller' => 'Ajasta\Address\Controller\IndexController',
                        'action' => 'get-address-fields-for-country',
                    ],
                    'constraints' => [
                        'countryCode' => '[A-Z]{2}',
                    ],
                ],
            ],
        ],
    ],
    'console' => [
        'router' => [
            'routes' => [
                'update-address-formats' => [
                    'type' => 'simple',
                    'options' => [
                        'route' => 'update-address-formats',
                        'defaults' => [
                            'controller' => 'Ajasta\Address\Controller\IndexController',
                            'action' => 'update-address-formats'
                        ],
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            'Ajasta\Address\Controller\IndexController' => 'Ajasta\Address\Controller\IndexControllerFactory',
        ],
    ],
    'service_manager' => [
        'factories' => [
            'Ajasta\Address\Service\AddressService' => 'Ajasta\Address\Service\AddressServiceFactory',
        ],
    ],
    'form_elements' => [
        'factories' => [
            'Ajasta\Address\Form\AddressFieldset' => 'Ajasta\Address\Form\AddressFieldsetFactory',
            'Ajasta\Address\Form\Element\CountrySelect' => 'Ajasta\Address\Form\Element\CountrySelectFactory',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'addressFormat' => 'Ajasta\Address\View\Helper\AddressFormatFactory',
        ],
    ],
    'validators' => [
        'factories' => [
            'Ajasta\Address\Validator\AddressFieldValidator' => 'Ajasta\Address\Validator\AddressFieldValidatorFactory',
        ],
    ],
    'hydrators' => [
        'factories' => [
            'Ajasta\Address\Hydrator\AddressHydrator' => 'Ajasta\Address\Hydrator\AddressHydratorFactory',
        ],
    ],
];
