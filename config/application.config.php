<?php
return [
    'modules' => [
        // Local modules
        'Ajasta\Address',
        'Ajasta\Client',
        'Ajasta\Core',
        'Ajasta\I18n',
        'Ajasta\Invoice',

        // Vendor modules
        'TwbBundle',
        'DoctrineModule',
        'DoctrineORMModule',
    ],
    'module_listener_options' => [
        'module_paths' => [
            './module',
            './vendor',
        ],
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
    ],
];
