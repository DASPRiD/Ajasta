<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\View;

use Ajasta\Infrastructure\View\ResponseRenderer;
use Interop\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class ResponseRendererFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new ResponseRenderer(
            $container->get(TemplateRendererInterface::class)
        );
    }
}
