<?php
use Ajasta\Domain;
use Ajasta\Factory\Infrastructure\Repository;

return [
    'dependencies' => [
        'factories' => [
            Domain\User\Repository\UsersByUserIdInterface::class => Repository\User\UsersByUserIdFactory::class,
            Domain\User\Repository\UsersByUsernameInterface::class => Repository\User\UsersByUsernameFactory::class,
        ],
    ],
];
