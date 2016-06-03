<?php
require 'vendor/autoload.php';
$container = require 'config/container.php';

$entityManager = $container->get(Doctrine\ORM\EntityManagerInterface::class);

return new Symfony\Component\Console\Helper\HelperSet([
    'em' => new Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager),
    'connection' => new Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($entityManager->getConnection()),
]);
