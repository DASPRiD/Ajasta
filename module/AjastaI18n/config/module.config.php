<?php
return [
    'cldr' => [
        'data_path' => __DIR__ . '/../data',
    ],
    'service_manager' => [
        'factories' => [
            'Ajasta\I18n\Cldr\Manager' => 'Ajasta\I18n\Cldr\ManagerFactory',
            'Ajasta\I18n\Cldr\Reader' => 'Ajasta\I18n\Cldr\ReaderFactory',
        ],
    ],
    'view_helpers' => [
        'invokables' => [
            'displayLanguage' => 'Ajasta\I18n\View\Helper\DisplayLanguage',
        ],
        'factories' => [
            'displayCurrency' => 'Ajasta\I18n\View\Helper\DisplayCurrencyFactory',
        ],
    ],
];
