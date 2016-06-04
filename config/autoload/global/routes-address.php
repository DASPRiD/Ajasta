<?php
return [
    'dependencies' => [
        'factories' => [
            Ajasta\Infrastructure\Middleware\Address\GetCountryData::class =>
                Ajasta\Factory\Infrastructure\Middleware\Address\GetCountryDataFactory::class,
        ],
    ],

    'routes' => [
        [
            'name' => 'address.getCountryData',
            'path' => '/address/get-country-data/{countryCode:[A-Z]{2}}',
            'middleware' => Ajasta\Infrastructure\Middleware\Address\GetCountryData::class,
            'allowed_methods' => ['GET'],
        ],
    ],
];
