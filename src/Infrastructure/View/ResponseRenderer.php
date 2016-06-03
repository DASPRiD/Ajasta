<?php
declare(strict_types = 1);

namespace Ajasta\Infrastructure\View;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Stream;
use Zend\Expressive\Template\TemplateRendererInterface;

class ResponseRenderer
{
    /**
     * @var TemplateRendererInterface
     */
    private $templateRenderer;

    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function render(
        ServerRequestInterface $request,
        ResponseInterface $response,
        string $name,
        array $variables = []
    ) : ResponseInterface {
        if (null !== $request->getAttribute('user')) {
            $variables['user'] = $request->getAttribute('user');
        }

        $body = new Stream('php://temp', 'wb+');
        $body->write($this->templateRenderer->render($name, $variables));
        $body->rewind();

        return $response->withBody($body);
    }
}
