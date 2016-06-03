<?php
declare(strict_types=1);

namespace Ajasta\Domain\User\Exception;

use DomainException;

class InvalidPasswordHash extends DomainException implements ExceptionInterface
{
    public static function fromInvalidPasswordHash(string $hash) : self
    {
        return new self(sprintf('Invalid password hash "%s" provided', $hash));
    }
}
