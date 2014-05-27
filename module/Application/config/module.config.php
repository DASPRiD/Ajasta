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
                    'Application\Entity' => 'application_entity',
                ],
            ],
        ],
    ],
    'router' => require __DIR__ . '/routes.config.php',
    'spiffy_navigation' => require __DIR__ . '/navigation.config.php',
    'controllers' => [
        'invokables' => [
            'Application\Controller\IndexController' => 'Application\Controller\IndexController',
        ],
        'factories' => [
            'Application\Controller\ClientController' => 'Application\Controller\ClientControllerFactory',
        ],
    ],
    'service_manager' => [
        'abstract_factories' => [
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ],
        'factories' => [
            'Application\I18n\CurrencyInformation' => 'Application\I18n\CurrencyInformationFactory',
            'Application\Service\AddressService' => 'Application\Service\AddressServiceFactory',
            'Application\Service\ClientService' => 'Application\Service\ClientServiceFactory',
            'Application\Service\OptionService' => 'Application\Service\OptionServiceFactory',
        ],
        'aliases' => [
            'Zend\Authentication\AuthenticationService' => 'doctrine.authenticationservice.orm_default',
            'translator' => 'MvcTranslator',
        ],
    ],
    'form_elements' => [
        'invokables' => [
            'Application\Form\ClientForm' => 'Application\Form\ClientForm',
            'Application\Form\Element\CountrySelect' => 'Application\Form\Element\CountrySelect',
            'Application\Form\Element\LocaleSelect' => 'Application\Form\Element\LocaleSelect',
            'Application\Form\Element\Toggle' => 'Application\Form\Element\Toggle',
            'Application\Form\Element\UnitSelect' => 'Application\Form\Element\UnitSelect',
        ],
        'factories' => [
            'Application\Form\AddressFieldset' => 'Application\Form\AddressFieldsetFactory',
            'Application\Form\ClientFieldset' => 'Application\Form\ClientFieldsetFactory',
            'Application\Form\Element\CurrencySelect' => 'Application\Form\Element\CurrencySelectFactory',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'displayLanguage' => 'Application\View\Helper\DisplayLanguage',
        ],
        'factories' => [
            'addressFormat' => 'Application\View\Helper\AddressFormatFactory',
            'displayCurrency' => 'Application\View\Helper\DisplayCurrencyFactory',
        ],
    ],
    'validators' => [
        'factories' => [
            'Application\Validator\AddressFieldValidator' => 'Application\Validator\AddressFieldValidatorFactory',
        ],
    ],
    'hydrators' => [
        'invokables' => [
            'Application\Hydrator\ClientHydrator' => 'Application\Hydrator\ClientHydrator',
        ],
        'factories' => [
            'Application\Hydrator\AddressHydrator' => 'Application\Hydrator\AddressHydratorFactory',
        ],
    ],
    'translator' => [
        'locale' => 'en-US',
        'translation_file_patterns' => [
            [
                'type'        => 'phparray',
                'base_dir'    => __DIR__ . '/../resources/languages',
                'pattern'     => '%s/Zend_Validate.php',
                'text_domain' => 'default',
            ],
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
