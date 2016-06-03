<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Middleware;

use Ajasta\Infrastructure\Middleware\Logout;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

class LogoutFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Logout(
            $container->get(UrlHelper::class)
        );
    }
}
