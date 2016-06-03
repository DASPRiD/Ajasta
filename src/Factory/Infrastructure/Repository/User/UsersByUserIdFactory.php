<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Repository\User;

use Ajasta\Domain\User\User;
use Ajasta\Infrastructure\Repository\User\UsersByUserId;
use Doctrine\ORM\EntityManagerInterface;
use Interop\Container\ContainerInterface;

class UsersByUserIdFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new UsersByUserId(
            $container->get(EntityManagerInterface::class)->getRepository(User::class)
        );
    }
}
