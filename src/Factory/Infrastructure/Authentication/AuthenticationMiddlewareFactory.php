<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Authentication;

use Ajasta\Domain\User\Repository\UsersByUserIdInterface;
use Ajasta\Infrastructure\Authentication\AuthenticationMiddleware;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

class AuthenticationMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new AuthenticationMiddleware(
            $container->get(UsersByUserIdInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}
