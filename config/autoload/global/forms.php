<?php
use Ajasta\Factory\Infrastructure\Form;

return [
    'dependencies' => [
        'factories' => [
            'Ajasta.Form.LoginForm' => Form\LoginFormFactory::class,
            'Ajasta.Form.Address.AddressMapping' => Form\Address\AddressMappingFactory::class,
            'Ajasta.Form.Client.ClientForm' => Form\Client\ClientFormFactory::class,
        ],
    ],
];
