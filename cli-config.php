<?php
require 'vendor/autoload.php';
$container = require 'config/container.php';

return new Symfony\Component\Console\Helper\HelperSet([
    'em' => new Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper(
        $container->get(Doctrine\ORM\EntityManagerInterface::class)
    ),
]);
