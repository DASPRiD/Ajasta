<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Middleware\Client;

use Ajasta\Infrastructure\Middleware\Client\UpdateClient;
use Ajasta\Infrastructure\View\ResponseRenderer;
use Interop\Container\ContainerInterface;

class UpdateClientFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new UpdateClient(
            $container->get(ResponseRenderer::class),
            $container->get('Ajasta.Form.Client.ClientForm')
        );
    }
}
