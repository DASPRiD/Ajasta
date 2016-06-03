<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Middleware;

use Ajasta\Domain\User\Repository\UsersByUsernameInterface;
use Ajasta\Infrastructure\Middleware\Login;
use Ajasta\Infrastructure\View\ResponseRenderer;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Helper\UrlHelper;

class LoginFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Login(
            $container->get(ResponseRenderer::class),
            $container->get('Ajasta\Infrastructure\Form\LoginForm'),
            $container->get(UsersByUsernameInterface::class),
            $container->get(UrlHelper::class)
        );
    }
}
