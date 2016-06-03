<?php
use Ajasta\Factory\Infrastructure\Form;

return [
    'dependencies' => [
        'factories' => [
            'Ajasta\Infrastructure\Form\LoginForm' => Form\LoginFormFactory::class,
        ],
    ],
];
