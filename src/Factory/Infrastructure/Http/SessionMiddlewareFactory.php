<?php
declare(strict_types = 1);

namespace Ajasta\Factory\Infrastructure\Http;

use Dflydev\FigCookies\SetCookie;
use Interop\Container\ContainerInterface;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use PSR7Session\Http\SessionMiddleware;

class SessionMiddlewareFactory
{
    public function __invoke(ContainerInterface $container)
    {
        return new SessionMiddleware(
            new Sha256(),
            'Zd/bnAuJOZ8h9xDV9xC/NYKWisxX3j/AoD9pYkfcEns=',
            'Zd/bnAuJOZ8h9xDV9xC/NYKWisxX3j/AoD9pYkfcEns=',
            SetCookie::create('session')
                ->withSecure(false)
                ->withHttpOnly(true),
            new Parser(),
            60 * 60 * 24 * 30
        );
    }
}
