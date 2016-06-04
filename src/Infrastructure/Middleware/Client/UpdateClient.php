<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Middleware\Client;

use Ajasta\Infrastructure\View\ResponseRenderer;
use DASPRiD\Formidable\Form;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UpdateClient
{
    /**
     * @var ResponseRenderer
     */
    private $responseRenderer;

    /**
     * @var Form
     */
    private $clientForm;

    public function __construct(ResponseRenderer $responseRenderer, Form $clientForm)
    {
        $this->responseRenderer = $responseRenderer;
        $this->clientForm = $clientForm;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $out = null
    ) : ResponseInterface {
        $clientForm = $this->clientForm;

        return $this->responseRenderer->render($request, $response, 'client::update', [
            'clientForm' => $clientForm,
        ]);
    }
}
