<?php
return [
    'dependencies' => [
        'factories' => [
            Doctrine\ORM\EntityManagerInterface::class => ContainerInteropDoctrine\EntityManagerFactory::class,
        ],
    ],
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'params' => [
                    'driverOptions' => [
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
                    ],
                ],
            ],
        ],
        'driver' => [
            'orm_default' => [
                'class' => Doctrine\ORM\Mapping\Driver\XmlDriver::class,
                'cache' => 'array',
                'paths' => __DIR__ . '/../../doctrine/',
            ],
        ],
        'types' => [
            'Ajasta.Client.ClientId' => Ajasta\Infrastructure\Doctrine\Type\Client\ClientIdType::class,
            'Ajasta.Invoice.InvoiceId' => Ajasta\Infrastructure\Doctrine\Type\Invoice\InvoiceIdType::class,
            'Ajasta.Invoice.InvoiceNumber' => Ajasta\Infrastructure\Doctrine\Type\Invoice\InvoiceNumberType::class,
            'Ajasta.LineItem.LineItemId' => Ajasta\Infrastructure\Doctrine\Type\LineItem\LineItemIdType::class,
            'Ajasta.LineItem.Quantity' => Ajasta\Infrastructure\Doctrine\Type\LineItem\QuantityType::class,
            'Ajasta.Project.ProjectId' => Ajasta\Infrastructure\Doctrine\Type\Project\ProjectIdType::class,
            'Ajasta.User.PasswordHash' => Ajasta\Infrastructure\Doctrine\Type\User\PasswordHashType::class,
            'Ajasta.User.UserId' => Ajasta\Infrastructure\Doctrine\Type\User\UserIdType::class,
            'Ajasta.User.Username' => Ajasta\Infrastructure\Doctrine\Type\User\UsernameType::class,
            'Ajasta.CurrencyCode' => Ajasta\Infrastructure\Doctrine\Type\CurrencyCodeType::class,
            'Ajasta.EmailAddress' => Ajasta\Infrastructure\Doctrine\Type\EmailAddressType::class,
            'Ajasta.Descriptor' => Ajasta\Infrastructure\Doctrine\Type\DescriptorType::class,
            'Ajasta.ImmutableDate' => Ajasta\Infrastructure\Doctrine\Type\ImmutableDateType::class,
            'Ajasta.Locale' => Ajasta\Infrastructure\Doctrine\Type\LocaleType::class,
            'Ajasta.Price' => Ajasta\Infrastructure\Doctrine\Type\PriceType::class,
            'Ajasta.Unit' => Ajasta\Infrastructure\Doctrine\Type\UnitType::class,
            'Ajasta.VatPercentage' => Ajasta\Infrastructure\Doctrine\Type\VatPercentageType::class,
        ],
    ],
];
