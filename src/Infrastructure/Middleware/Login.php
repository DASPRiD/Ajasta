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

class Login
{
    /**
     * @var ResponseRenderer
     */
    private $responseRenderer;

    /**
     * @var Form
     */
    private $loginForm;

    /**
     * @var UsersByUsername
     */
    private $usersByUsername;

    /**
     * @var UrlHelper
     */
    private $urlHelper;

    public function __construct(
        ResponseRenderer $responseRenderer,
        Form $loginForm,
        UsersByUsername $usersByUsername,
        UrlHelper $urlHelper
    ) {
        $this->responseRenderer = $responseRenderer;
        $this->loginForm = $loginForm;
        $this->usersByUsername = $usersByUsername;
        $this->urlHelper = $urlHelper;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $out = null
    ) : ResponseInterface {
        $form = $this->loginForm;
        $loginError = false;

        if ('POST' === $request->getMethod()) {
            $form = $form->bindFromRequest($request);

            if (!$form->hasErrors()) {
                if ($this->performLogin($request, $value = $form->getValue())) {
                    return new RedirectResponse($this->urlHelper->generate('dashboard'));
                }

                $loginError = true;
            }
        }

        return $this->responseRenderer->render($request, $response, 'app::login', [
            'layout' => 'layout::login',
            'form' => $form,
            'loginError' => $loginError,
        ]);
    }

    private function performLogin(ServerRequestInterface $request, LoginFormData $loginFormData) : bool
    {
        $username = Username::fromString($loginFormData->getUsername());

        if (!$this->usersByUsername->has($username)) {
            return false;
        }

        $user = $this->usersByUsername->get($username);

        if (!$user->verifyPassword($loginFormData->getPassword())) {
            return false;
        }

        /* @var $session SessionInterface */
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        Assertion::isInstanceOf($session, SessionInterface::class);
        $session->set('user_id', (string) $user->getUserId());

        return true;
    }
}
