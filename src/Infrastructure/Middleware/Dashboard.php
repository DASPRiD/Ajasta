<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Middleware;

use Ajasta\Infrastructure\View\ResponseRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dashboard
{
    /**
     * @var ResponseRenderer
     */
    private $responseRenderer;

    public function __construct(ResponseRenderer $responseRenderer)
    {
        $this->responseRenderer = $responseRenderer;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $out = null
    ) : ResponseInterface {
        return $this->responseRenderer->render($request, $response, 'app::dashboard');
    }
}
