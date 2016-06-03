<?php
require 'vendor/autoload.php';

/* @var $container Interop\Container\ContainerInterface */
$container = require 'config/container.php';
/* @var $entityManager Doctrine\ORM\EntityManagerInterface */
$entityManager = $container->get(Doctrine\ORM\EntityManagerInterface::class);

$username = Zend\Console\Prompt\Line::prompt('Username: ');
$emailAddress = Zend\Console\Prompt\Line::prompt('Email Address: ');
$password = Zend\Console\Prompt\Password::prompt('Password: ', true);

$user = Ajasta\Domain\User\User::create(
    Ajasta\Domain\User\Username::fromString($username),
    Ajasta\Domain\EmailAddress::fromString($emailAddress),
    Ajasta\Domain\User\PasswordHash::fromPassword($password)
);

$entityManager->persist($user);
$entityManager->flush();
