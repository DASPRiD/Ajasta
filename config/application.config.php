<?php
return [
    'modules' => [
        // Local modules
        'Ajasta\Address',
        'Ajasta\Application',
        'Ajasta\I18n',

        // Vendor modules
        'SpiffyNavigation',
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
