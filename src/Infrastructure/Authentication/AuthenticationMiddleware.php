<?php
declare(strict_types = 1);

namespace Ajasta\Infrastructure\Authentication;

use Ajasta\Domain\User\UserId;
use Ajasta\Infrastructure\Repository\User\UsersByUserId;
use Assert\Assertion;
use PSR7Session\Http\SessionMiddleware;
use PSR7Session\Session\SessionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Helper\UrlHelper;
use Zend\Expressive\Router\RouteResult;

class AuthenticationMiddleware
{
    const PUBLIC_ROUTES = [
        'login',
    ];

    /**
     * @var UsersByUserId
     */
    private $usersByUserId;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(UsersByUserId $usersByUserId, UrlHelper $urlHelper)
    {
        $this->usersByUserId = $usersByUserId;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $out
    ) : ResponseInterface {
        /* @var $session SessionInterface */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        Assertion::isInstanceOf($session, SessionInterface::class);
        $request = $request->withAttribute('user', $this->getUserFromSession($session));

        /* @var $routeResult RouteResult */
        $routeResult = $request->getAttribute(RouteResult::class);
        Assertion::isInstanceOf($routeResult, RouteResult::class);

        if ($routeResult->isFailure()) {
            return $out($request, $response);
        }

        $isPublicRoute = in_array($routeResult->getMatchedRouteName(), self::PUBLIC_ROUTES);

        if (null !== $request->getAttribute('user')) {
            if ($isPublicRoute) {
                return new RedirectResponse($this->urlHelper->generate('dashboard'));
            }

            return $out($request, $response);
        }

        if (!$isPublicRoute) {
            return new RedirectResponse($this->urlHelper->generate('login'));
        }

        return $out($request, $response);
    }

    private function getUserFromSession(SessionInterface $session)
    {
        if (!$session->has('user_id')) {
            return null;
        }

        $userId = UserId::fromString($session->get('user_id'));

        if (!$this->usersByUserId->has($userId)) {
            return null;
        }

        return $this->usersByUserId->get($userId);
    }
}
