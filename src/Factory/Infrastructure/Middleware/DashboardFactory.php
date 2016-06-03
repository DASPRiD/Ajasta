<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Middleware;

use Ajasta\Infrastructure\Middleware\Dashboard;
use Ajasta\Infrastructure\View\ResponseRenderer;
use Interop\Container\ContainerInterface;

class DashboardFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new Dashboard(
            $container->get(ResponseRenderer::class)
        );
    }
}
