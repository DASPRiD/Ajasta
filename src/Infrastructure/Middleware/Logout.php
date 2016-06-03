<?php
declare(strict_types=1);

namespace Ajasta\Infrastructure\Middleware;

use Ajasta\Domain\User\Username;
use Ajasta\Infrastructure\FormData\LoginFormData;
use Ajasta\Infrastructure\Repository\User\UsersByUsername;
use Ajasta\Infrastructure\View\ResponseRenderer;
use Assert\Assertion;
use DASPRiD\Formidable\Form;
use PSR7Session\Http\SessionMiddleware;
use PSR7Session\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;

class Logout
{
    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(UrlHelper $urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $out = null
    ) : ResponseInterface {
        /* @var $session SessionInterface */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        Assertion::isInstanceOf($session, SessionInterface::class);
        $session->remove('user_id');

        return new RedirectResponse($this->urlHelper->generate('login'));
    }
}
